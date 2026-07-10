<?php

namespace App\Http\Controllers;

use App\Models\TrialRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TrialRegistrationController extends Controller
{
    public function create()
    {
        return view('trial.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'],
            'phone_number' => ['required', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => User::ROLE_SISWA,
                'is_active' => false,
            ]);

            TrialRegistration::create([
                'user_id' => $user->id,
                'phone_number' => $validated['phone_number'],
                'status' => 'pending',
            ]);
        });

        return redirect()
            ->route('trial.create')
            ->with('success', 'Pendaftaran trial berhasil. Admin akan menghubungi kamu melalui nomor telepon yang didaftarkan.');
    }
}
