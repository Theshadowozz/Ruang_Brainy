<?php

use App\Models\CourseClass;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

if (in_array('sqlite', PDO::getAvailableDrivers(), true)) {
    uses(RefreshDatabase::class);
} else {
    beforeEach(function () {
        $this->markTestSkipped('PDO SQLite tidak tersedia pada environment ini.');
    });
}

function createAvailableSchedule(): Schedule
{
    $tutor = Tutor::create([
        'name' => 'Tutor Test',
        'email' => 'tutor.test@example.com',
        'phone_number' => '081234567890',
        'expertise' => 'Bahasa Inggris',
    ]);

    $course = CourseClass::create([
        'name' => 'English Test Class',
        'language' => 'Inggris',
        'level' => 'Beginner',
        'tutor_id' => $tutor->id,
        'price' => 1500000,
        'description' => 'Kelas untuk pengujian alur pendaftaran.',
    ]);

    return Schedule::create([
        'class_id' => $course->id,
        'start_date' => '2026-07-01',
        'end_date' => '2026-09-30',
        'day' => 'Senin & Rabu',
        'start_time' => '19:00',
        'end_time' => '20:30',
        'room' => 'Ruang Test',
        'capacity' => 10,
    ]);
}

test('student registration creates an inactive account and pending payment', function () {
    $schedule = createAvailableSchedule();

    $response = $this->post(route('registration.store', $schedule), [
        'full_name' => 'Siswa Baru',
        'email' => 'siswa.baru@example.com',
        'phone_number' => '081298765432',
        'address' => 'Padang',
        'password' => 'rahasia',
        'password_confirmation' => 'rahasia',
    ]);

    $registration = Registration::firstOrFail();

    $response->assertRedirect(route('registration.payment.show', $registration));
    expect($registration->user->is_active)->toBeFalse()
        ->and($registration->status)->toBe('pending')
        ->and($registration->payment->status)->toBe('pending')
        ->and($registration->payment->transaction_code)->toBeNull();
});

test('student can simulate payment and admin confirmation activates login', function () {
    $schedule = createAvailableSchedule();

    $this->post(route('registration.store', $schedule), [
        'full_name' => 'Siswa Aktif',
        'email' => 'siswa.aktif@example.com',
        'phone_number' => '081298765433',
        'address' => 'Padang',
        'password' => 'rahasia',
        'password_confirmation' => 'rahasia',
    ]);

    $registration = Registration::firstOrFail();

    $this->post(route('registration.payment.pay', $registration))
        ->assertRedirect(route('registration.payment.show', $registration));

    $payment = Payment::firstOrFail();
    expect($payment->fresh()->transaction_code)->not->toBeNull();

    $this->post(route('login.store'), [
        'email' => 'siswa.aktif@example.com',
        'password' => 'rahasia',
    ])->assertSessionHasErrors('email');

    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'is_active' => true,
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.payments.confirm', $payment))
        ->assertSessionHas('success');

    expect($registration->fresh()->status)->toBe('accepted')
        ->and($registration->user->fresh()->is_active)->toBeTrue()
        ->and($payment->fresh()->status)->toBe('paid');

    $this->post(route('logout'));

    $this->post(route('login.store'), [
        'email' => 'siswa.aktif@example.com',
        'password' => 'rahasia',
    ])->assertRedirect(route('dashboard'));
});

test('admin and tutor login are not restricted by student payment status', function (int $role) {
    $user = User::factory()->create([
        'role' => $role,
        'is_active' => true,
        'password' => 'rahasia',
    ]);

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'rahasia',
    ])->assertRedirect(route('dashboard'));
})->with([
    'admin' => User::ROLE_ADMIN,
    'tutor' => User::ROLE_TUTOR,
]);
