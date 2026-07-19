<?php

use App\Contracts\PaymentGateway;
use App\Models\CourseClass;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\TrialRegistration;
use App\Models\Tutor;
use App\Models\User;
use App\Models\WaitingList;
use Illuminate\Foundation\Testing\RefreshDatabase;

if (in_array('sqlite', PDO::getAvailableDrivers(), true)) {
    uses(RefreshDatabase::class);
} else {
    beforeEach(function () {
        $this->markTestSkipped('PDO SQLite tidak tersedia pada environment ini.');
    });
}

beforeEach(function () {
    config([
        'services.midtrans.server_key' => 'SB-Mid-server-test',
        'services.midtrans.client_key' => 'SB-Mid-client-test',
        'services.midtrans.is_production' => false,
        'services.midtrans.expiry_hours' => 24,
    ]);

    app()->bind(PaymentGateway::class, fn () => new class implements PaymentGateway
    {
        public function createSnapToken(Payment $payment): string
        {
            $payment->update([
                'snap_token' => 'snap-'.$payment->id,
                'snap_token_created_at' => now(),
            ]);

            return 'snap-'.$payment->id;
        }

        public function transactionStatus(string $orderId): array
        {
            return [];
        }
    });
});

function createAvailableSchedule(string $level = 'Beginner', int $capacity = 10): Schedule
{
    $tutor = Tutor::create([
        'name' => 'Tutor '.$level,
        'email' => strtolower($level).uniqid().'@example.com',
        'phone_number' => '081234567890',
        'expertise' => 'Bahasa Inggris',
    ]);

    $prices = ['Beginner' => 350000, 'Intermediate' => 375000, 'Advance' => 400000];
    $course = CourseClass::create([
        'name' => 'English '.$level,
        'language' => 'Inggris',
        'level' => $level,
        'tutor_id' => $tutor->id,
        'price' => $prices[$level],
        'description' => 'Kelas untuk pengujian alur pendaftaran.',
    ]);

    return Schedule::create([
        'class_id' => $course->id,
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addMonths(3)->toDateString(),
        'day' => 'Senin & Rabu',
        'start_time' => '19:00',
        'end_time' => '20:30',
        'room' => 'Ruang Test',
        'capacity' => $capacity,
    ]);
}

function registerStudent($test, Schedule $schedule, string $email = 'siswa@example.com')
{
    return $test->post(route('registration.store', $schedule), [
        'full_name' => 'Siswa Baru',
        'email' => $email,
        'phone_number' => '081298765432',
        'address' => 'Padang',
        'password' => 'rahasia',
        'password_confirmation' => 'rahasia',
    ]);
}

function midtransPayload(Payment $payment, array $overrides = []): array
{
    $payload = array_merge([
        'order_id' => $payment->order_id,
        'status_code' => '200',
        'gross_amount' => number_format((float) $payment->amount, 2, '.', ''),
        'transaction_id' => 'midtrans-'.$payment->id,
        'transaction_status' => 'settlement',
        'fraud_status' => 'accept',
        'settlement_time' => now()->format('Y-m-d H:i:s'),
    ], $overrides);
    $payload['signature_key'] = hash('sha512',
        $payload['order_id'].$payload['status_code'].$payload['gross_amount'].config('services.midtrans.server_key')
    );

    return $payload;
}

test('registration snapshots level price and shows admin fee only at checkout', function (string $level, int $subtotal, int $total) {
    $schedule = createAvailableSchedule($level);

    $this->get(route('classes.index'))
        ->assertOk()
        ->assertSee(number_format($subtotal, 0, ',', '.'))
        ->assertDontSee('Biaya admin');

    registerStudent($this, $schedule)->assertRedirect();
    $registration = Registration::firstOrFail();
    $payment = $registration->latestPayment;

    expect((int) $payment->subtotal)->toBe($subtotal)
        ->and((int) $payment->admin_fee)->toBe(2500)
        ->and((int) $payment->amount)->toBe($total)
        ->and($payment->order_id)->toStartWith('RB-REG-')
        ->and($registration->user->is_active)->toBeFalse();

    $this->get(URL::temporarySignedRoute('registration.payment.show', now()->addHour(), [
        'registration' => $registration,
        'payment' => $payment,
        'access_token' => $payment->access_token,
    ]))->assertOk()
        ->assertSee('Biaya admin')
        ->assertSee(number_format($total, 0, ',', '.'));
})->with([
    'beginner' => ['Beginner', 350000, 352500],
    'intermediate' => ['Intermediate', 375000, 377500],
    'advance' => ['Advance', 400000, 402500],
]);

test('checkout token is created server side and reused', function () {
    $schedule = createAvailableSchedule();
    registerStudent($this, $schedule);
    $registration = Registration::firstOrFail();
    $payment = $registration->latestPayment;

    $route = route('registration.payment.start', [$registration, $payment]);
    $this->postJson($route)->assertOk()->assertJson(['token' => 'snap-'.$payment->id]);
    $this->postJson($route)->assertOk()->assertJson(['token' => 'snap-'.$payment->id]);
    expect($payment->fresh()->snap_token)->toBe('snap-'.$payment->id);
});

test('valid Midtrans settlement activates a reserved student and duplicate callback is idempotent', function () {
    $schedule = createAvailableSchedule();
    registerStudent($this, $schedule, 'aktif@example.com');
    $registration = Registration::firstOrFail();
    $payment = $registration->latestPayment;
    $payload = midtransPayload($payment);

    $this->postJson(route('webhooks.midtrans'), $payload)->assertOk();
    $paidAt = $payment->fresh()->paid_at;
    $this->postJson(route('webhooks.midtrans'), $payload)->assertOk();

    expect($payment->fresh()->status)->toBe(Payment::STATUS_PAID)
        ->and($payment->fresh()->paid_at->equalTo($paidAt))->toBeTrue()
        ->and($registration->fresh()->status)->toBe(Registration::STATUS_ACCEPTED)
        ->and($registration->fresh()->access_starts_at->isSameDay($schedule->start_date))->toBeTrue()
        ->and($registration->user->fresh()->is_active)->toBeTrue();

    $this->post(route('login.store'), ['email' => 'aktif@example.com', 'password' => 'rahasia'])
        ->assertRedirect(route('dashboard'));
});

test('webhook rejects forged signature and wrong amount', function () {
    $schedule = createAvailableSchedule();
    registerStudent($this, $schedule);
    $payment = Payment::firstOrFail();

    $forged = midtransPayload($payment);
    $forged['signature_key'] = 'forged';
    $this->postJson(route('webhooks.midtrans'), $forged)->assertUnprocessable();

    $wrongAmount = midtransPayload($payment, ['gross_amount' => '1.00']);
    $this->postJson(route('webhooks.midtrans'), $wrongAmount)->assertUnprocessable();
    expect($payment->fresh()->status)->toBe(Payment::STATUS_PENDING);
});

test('full class creates paid waiting list account that stays inactive until admin promotion', function () {
    $schedule = createAvailableSchedule(capacity: 1);
    $existing = User::factory()->create(['role' => User::ROLE_SISWA, 'is_active' => true]);
    Registration::create([
        'full_name' => $existing->name,
        'user_id' => $existing->id,
        'schedule_id' => $schedule->id,
        'phone_number' => '081111111111',
        'address' => 'Padang',
        'status' => Registration::STATUS_ACCEPTED,
        'access_starts_at' => now()->subDay(),
        'access_ends_at' => now()->addMonth(),
    ]);

    registerStudent($this, $schedule, 'waiting@example.com');
    $waitingRegistration = Registration::whereHas('user', fn ($query) => $query->where('email', 'waiting@example.com'))->firstOrFail();
    $payment = $waitingRegistration->latestPayment;
    $waiting = WaitingList::where('user_id', $waitingRegistration->user_id)->firstOrFail();

    $this->postJson(route('webhooks.midtrans'), midtransPayload($payment))->assertOk();
    expect($waitingRegistration->fresh()->status)->toBe(Registration::STATUS_WAITING_LIST)
        ->and($waitingRegistration->user->fresh()->is_active)->toBeFalse();

    $existing->registrations()->first()->update(['status' => Registration::STATUS_FINISHED]);
    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'is_active' => true]);
    $this->actingAs($admin)->post(route('admin.waitinglist.promote', $waiting))->assertSessionHas('success');

    expect($waiting->fresh()->status)->toBe(WaitingList::STATUS_ACCEPTED)
        ->and($waitingRegistration->fresh()->status)->toBe(Registration::STATUS_ACCEPTED)
        ->and($waitingRegistration->fresh()->access_starts_at->isToday())->toBeTrue()
        ->and($waitingRegistration->user->fresh()->is_active)->toBeTrue();
});

test('expired class access keeps login but locks learning route and renewal resets access from payment', function () {
    $schedule = createAvailableSchedule();
    $student = User::factory()->create(['role' => User::ROLE_SISWA, 'is_active' => true, 'password' => 'rahasia']);
    $registration = Registration::create([
        'full_name' => $student->name,
        'user_id' => $student->id,
        'schedule_id' => $schedule->id,
        'phone_number' => '081111111111',
        'address' => 'Padang',
        'status' => Registration::STATUS_ACCEPTED,
        'access_starts_at' => now()->subMonths(2),
        'access_ends_at' => now()->subMonth(),
    ]);

    $this->post(route('login.store'), ['email' => $student->email, 'password' => 'rahasia'])
        ->assertRedirect(route('dashboard'));
    $this->get(route('siswa.audio.index'))->assertRedirect(route('siswa.dashboard'));

    $this->actingAs($student)->post(route('siswa.registration.renew', $registration))->assertRedirect();
    $renewal = $registration->payments()->where('type', Payment::TYPE_RENEWAL)->firstOrFail();
    $this->postJson(route('webhooks.midtrans'), midtransPayload($renewal))->assertOk();

    expect($registration->fresh()->hasActiveAccess())->toBeTrue()
        ->and($registration->fresh()->access_starts_at->isToday())->toBeTrue();
});

test('admin and tutor login are not restricted by student payment status', function (int $role) {
    $user = User::factory()->create(['role' => $role, 'is_active' => true, 'password' => 'rahasia']);
    $this->post(route('login.store'), ['email' => $user->email, 'password' => 'rahasia'])
        ->assertRedirect(route('dashboard'));
})->with(['admin' => User::ROLE_ADMIN, 'tutor' => User::ROLE_TUTOR]);

test('trial registration is stored and visible to admin', function () {
    $this->post(route('trial.store'), [
        'full_name' => 'Siswa Trial',
        'email' => 'trial@example.com',
        'phone_number' => '081298765400',
        'password' => 'rahasia',
        'password_confirmation' => 'rahasia',
    ])->assertRedirect(route('trial.create'));

    expect(TrialRegistration::query()->count())->toBe(1);
});
