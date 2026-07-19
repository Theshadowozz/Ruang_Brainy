<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\User;
use App\Models\WaitingList;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class ClassRegistrationController extends Controller
{
    public function index()
    {
        $classes = CourseClass::query()
            ->with(['tutor', 'schedules' => fn ($query) => $query
                ->withCount(['registrations as occupied_seats' => fn ($registration) => $registration
                    ->where(fn ($status) => $status
                        ->where('status', Registration::STATUS_ACCEPTED)
                        ->orWhere(fn ($pending) => $pending
                            ->where('status', Registration::STATUS_PENDING)
                            ->where('seat_reserved_until', '>', now())))])
                ->whereDate('end_date', '>=', today())
                ->orderBy('start_date')
                ->orderBy('start_time')])
            ->whereHas('schedules', fn ($query) => $query->whereDate('end_date', '>=', today()))
            ->orderBy('language')
            ->orderBy('level')
            ->get();

        return view('registration.classes', compact('classes'));
    }

    public function create(Schedule $schedule)
    {
        $schedule->load(['courseClass.tutor'])
            ->loadCount(['registrations as occupied_seats' => fn ($query) => $query
                ->where(fn ($status) => $status
                    ->where('status', Registration::STATUS_ACCEPTED)
                    ->orWhere(fn ($pending) => $pending
                        ->where('status', Registration::STATUS_PENDING)
                        ->where('seat_reserved_until', '>', now())))]);

        return view('registration.create', [
            'schedule' => $schedule,
            'willJoinWaitingList' => $schedule->occupied_seats >= $schedule->capacity,
        ]);
    }

    public function store(Request $request, Schedule $schedule, PaymentService $payments)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:6'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        [$registration, $payment] = DB::transaction(function () use ($validated, $schedule, $payments) {
            $schedule = Schedule::query()->with('courseClass')->lockForUpdate()->findOrFail($schedule->id);
            $occupiedSeats = $schedule->registrations()
                ->where(fn ($status) => $status
                    ->where('status', Registration::STATUS_ACCEPTED)
                    ->orWhere(fn ($pending) => $pending
                        ->where('status', Registration::STATUS_PENDING)
                        ->where('seat_reserved_until', '>', now())))
                ->count();
            $hasSeat = $occupiedSeats < $schedule->capacity;

            $user = User::query()->where('email', $validated['email'])->first();

            if ($user && (! $user->isSiswa() || ! Hash::check($validated['password'], $user->password))) {
                throw ValidationException::withMessages([
                    'email' => 'Email sudah digunakan atau password akun tidak sesuai.',
                ]);
            }

            if ($user?->registrations()->where('schedule_id', $schedule->id)->exists()) {
                throw ValidationException::withMessages([
                    'email' => 'Akun ini sudah terdaftar pada jadwal yang dipilih.',
                ]);
            }

            if (! $user) {
                $user = User::create([
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role' => User::ROLE_SISWA,
                    'is_active' => false,
                ]);
            }

            $registration = Registration::create([
                'full_name' => $validated['full_name'],
                'user_id' => $user->id,
                'schedule_id' => $schedule->id,
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
                'status' => $hasSeat ? Registration::STATUS_PENDING : Registration::STATUS_WAITING_LIST,
                'seat_reserved_until' => $hasSeat
                    ? now()->addHours((int) config('services.midtrans.expiry_hours', 24))
                    : null,
            ]);

            if (! $hasSeat) {
                $queueNumber = ((int) WaitingList::query()
                    ->where('schedule_id', $schedule->id)
                    ->max('queue_number')) + 1;

                WaitingList::create([
                    'user_id' => $user->id,
                    'schedule_id' => $schedule->id,
                    'full_name' => $validated['full_name'],
                    'phone_number' => $validated['phone_number'],
                    'address' => $validated['address'],
                    'queue_number' => $queueNumber,
                    'status' => WaitingList::STATUS_WAITING,
                ]);
            }

            return [$registration, $payments->createPayment($registration)];
        });

        $request->session()->put('registration_id', $registration->id);

        return redirect(URL::temporarySignedRoute(
            'registration.payment.show',
            now()->addDays(7),
            [
                'registration' => $registration,
                'payment' => $payment,
                'access_token' => $payment->access_token,
            ]
        ));
    }
}
