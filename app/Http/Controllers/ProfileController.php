<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(): View
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $wantsPasswordChange = $request->filled('password') || $request->filled('password_confirmation');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'bio_penulis' => ['nullable', 'string', 'max:1000'],
        ];

        if ($wantsPasswordChange) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = [
                'required',
                'string',
                'min:12',
                'confirmed',
                'different:current_password',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+\[\]{};:\'",.<>\/?\\|`~]).{12,}$/',
            ];
            $rules['password_confirmation'] = ['required', 'string', 'min:12'];
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'bio_penulis.max' => 'Informasi penulis maksimal 1000 karakter.',
            'current_password.required' => 'Password saat ini wajib diisi untuk mengganti password.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 12 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.different' => 'Password baru harus berbeda dari password saat ini.',
            'password.regex' => 'Password baru harus minimal 12 karakter dan mengandung huruf besar, huruf kecil, angka, serta simbol.',
            'password_confirmation.required' => 'Konfirmasi password baru wajib diisi.',
            'password_confirmation.min' => 'Konfirmasi password baru minimal 12 karakter.',
        ]);

        $oldAttributes = Arr::only($user->getOriginal(), ['name', 'email', 'bio_penulis']);
        $bio = trim((string) ($validated['bio_penulis'] ?? ''));

        $updateData = [
            'name' => trim($validated['name']),
            'email' => trim($validated['email']),
            'bio_penulis' => $bio !== '' ? $bio : null,
        ];

        if ($wantsPasswordChange) {
            $updateData['password'] = Hash::make($validated['password']);
            $updateData['remember_token'] = Str::random(60);
        }

        $user->update($updateData);

        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'old' => $oldAttributes,
                'attributes' => Arr::only($user->fresh()->toArray(), ['name', 'email', 'bio_penulis']),
                'password_changed' => $wantsPasswordChange,
            ])
            ->log($wantsPasswordChange ? 'Memperbarui profil dan mengganti password' : 'Memperbarui profil akun');

        if ($wantsPasswordChange) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('status', 'Profil dan password berhasil diperbarui. Silakan login ulang.');
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
