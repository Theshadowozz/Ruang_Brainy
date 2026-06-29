<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\TrialRegistration;
use App\Models\User;
use App\Rules\ValidNik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClassRegistrationController extends Controller
{
    public function index()
    {
        $classes = CourseClass::query()
            ->with(['tutor', 'schedules' => fn ($query) => $query
                ->withCount(['registrations as occupied_seats' => fn ($registration) => $registration
                    ->whereIn('status', ['pending', 'accepted'])])
                ->orderBy('start_date')
                ->orderBy('start_time')])
            ->whereHas('schedules')
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
        $request->merge([
            'nik' => ValidNik::normalize($request->input('nik')),
        ]);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'nik' => [
                'required',
                'digits:16',
                new ValidNik,
                Rule::unique('registrations', 'nik'),
            ],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
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

            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => User::ROLE_SISWA,
                'is_active' => false,
            ]);

            $registration = Registration::create([
                'full_name' => $validated['full_name'],
                'nik' => $validated['nik'],
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

    public function checkNik(Request $request)
    {
        $nik = ValidNik::normalize($request->query('nik'));
        $context = $request->query('context') === 'trial' ? 'trial' : 'registration';
        $valid = ValidNik::passes($nik);
        $classRegistered = $nik !== '' && Registration::query()->where('nik', $nik)->exists();
        $trialRegistered = $nik !== '' && TrialRegistration::query()->where('nik', $nik)->exists();
        $registered = $context === 'trial'
            ? $classRegistered || $trialRegistered
            : $classRegistered;

        $message = match (true) {
            strlen($nik) !== 16 => 'NIK harus terdiri dari 16 digit.',
            ! $valid => 'NIK tidak valid.',
            $context === 'trial' && $trialRegistered => 'NIK ini sudah pernah digunakan untuk trial.',
            $context === 'trial' && $classRegistered => 'NIK ini sudah terdaftar sebagai siswa.',
            $classRegistered => 'NIK ini sudah pernah digunakan untuk pendaftaran kelas.',
            $trialRegistered => 'NIK valid. Trial sebelumnya tercatat, lanjutkan pendaftaran kelas.',
            default => 'NIK valid dan belum terdaftar.',
        };

        return response()->json([
            'nik' => $nik,
            'context' => $context,
            'valid' => $valid,
            'registered' => $registered,
            'class_registered' => $classRegistered,
            'trial_registered' => $trialRegistered,
            'available' => $valid && ! $registered,
            'message' => $message,
        ]);
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
