<?php

namespace App\Http\Controllers;

use App\Models\TrialRegistration;
use App\Rules\ValidNik;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrialRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'nik' => ValidNik::normalize($request->input('nik')),
        ]);

        $validated = $request->validateWithBag('trial', [
            'full_name' => ['required', 'string', 'max:255'],
            'nik' => [
                'required',
                'digits:16',
                new ValidNik,
                Rule::unique('trial_registrations', 'nik'),
                Rule::unique('registrations', 'nik'),
            ],
            'program' => ['required', 'string', Rule::in(['Bahasa Inggris', 'Bahasa Jepang', 'Bahasa Korea'])],
        ]);

        TrialRegistration::create($validated);

        return redirect()
            ->to(route('home').'#trial')
            ->with('trial_success', 'Pendaftaran trial berhasil dicatat. Tim Brainy akan menghubungi kamu untuk jadwal berikutnya.');
    }
}
