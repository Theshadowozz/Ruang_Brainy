<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ClassRegistrationController extends Controller
{
    public function index()
    {
        $classes = CourseClass::query()
            ->with(['tutor', 'schedules' => fn ($query) => $query
                ->withCount(['registrations as occupied_seats' => fn ($registration) => $registration
                    ->whereIn('status', ['pending', 'accepted'])])
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
                ->whereIn('status', ['pending', 'accepted'])]);

        abort_if($schedule->occupied_seats >= $schedule->capacity, 422, 'Jadwal kelas ini sudah penuh.');

        return view('registration.create', compact('schedule'));
    }

    public function store(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:6'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $registration = DB::transaction(function () use ($validated, $schedule) {
            $schedule = Schedule::query()->lockForUpdate()->findOrFail($schedule->id);
            $occupiedSeats = $schedule->registrations()
                ->whereIn('status', ['pending', 'accepted'])
                ->count();

            abort_if($occupiedSeats >= $schedule->capacity, 422, 'Maaf, jadwal kelas ini baru saja penuh.');

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
                'status' => 'pending',
            ]);

            Payment::create([
                'registration_id' => $registration->id,
                'amount' => $schedule->courseClass->price,
                'payment_method' => 'Belum dilakukan',
                'status' => 'pending',
            ]);

            return $registration;
        });

        $request->session()->put('registration_id', $registration->id);

        return redirect()->route('registration.payment.show', $registration);
    }

    public function showPayment(Request $request, Registration $registration)
    {
        $this->ensureRegistrationOwner($request, $registration);
        $registration->load(['user', 'schedule.courseClass.tutor', 'payment']);

        return view('registration.payment', compact('registration'));
    }

    public function pay(Request $request, Registration $registration)
    {
        $this->ensureRegistrationOwner($request, $registration);

        if (! $registration->payment->transaction_code) {
            $registration->payment->update([
                'payment_method' => 'Simulasi pembayaran',
                'transaction_code' => 'SIM-'.now()->format('YmdHis').'-'.$registration->id,
                'status' => 'pending',
            ]);
        }

        return redirect()
            ->route('registration.payment.show', $registration)
            ->with('success', 'Pembayaran simulasi tercatat dan sedang menunggu konfirmasi admin.');
    }

    private function ensureRegistrationOwner(Request $request, Registration $registration): void
    {
        abort_unless((int) $request->session()->get('registration_id') === $registration->id, 403);
    }
}
