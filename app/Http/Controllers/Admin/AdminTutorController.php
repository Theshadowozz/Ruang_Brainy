<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminTutorController extends Controller
{
    public function index()
    {
        return view('admin.tutors', [
            'tutors' => Tutor::query()
                ->with(['user', 'classes.schedules'])
                ->withCount('classes')
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => User::ROLE_TUTOR,
                'is_active' => true,
            ]);

            Tutor::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'expertise' => $validated['expertise'],
            ]);
        });

        return back()->with('success', 'Profil dan akun login tutor berhasil dibuat.');
    }

    public function update(Request $request, Tutor $tutor)
    {
        $validated = $this->validated($request, $tutor);

        DB::transaction(function () use ($validated, $tutor) {
            $user = $tutor->user;

            if (! $user) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role' => User::ROLE_TUTOR,
                    'is_active' => true,
                ]);
            } else {
                $user->fill([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'is_active' => true,
                ]);

                if (! empty($validated['password'])) {
                    $user->password = $validated['password'];
                }

                $user->save();
            }

            $tutor->update([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'expertise' => $validated['expertise'],
            ]);
        });

        return back()->with('success', 'Data tutor berhasil diperbarui.');
    }

    public function destroy(Tutor $tutor)
    {
        DB::transaction(function () use ($tutor) {
            $user = $tutor->user;
            $tutor->delete();
            $user?->delete();
        });

        return back()->with('success', 'Tutor dan akun loginnya berhasil dihapus.');
    }

    private function validated(Request $request, ?Tutor $tutor = null): array
    {
        $userId = $tutor?->user_id;

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
                Rule::unique('tutors', 'email')->ignore($tutor?->id),
            ],
            'phone_number' => ['required', 'string', 'max:20'],
            'expertise' => ['required', 'string', 'max:255'],
            'password' => [$tutor && $tutor->user ? 'nullable' : 'required', 'confirmed', 'min:6'],
        ]);
    }
}
