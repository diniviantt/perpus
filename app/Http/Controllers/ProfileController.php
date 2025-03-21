<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'indisposable', 'max:255', Rule::unique(User::class)->ignore(auth()->user()->id)],
            'avatar' => ['nullable', 'image', 'file', 'max:2048'],
        ]);
        if ($request->file('avatar')) {
            if (auth()->user()->avatar) {
                Storage::delete($request->user()->rawAvatar());
            }
            $validatedData['avatar'] = $request->file('avatar')->store('avatar');
        }

        try {
            $request->user()->update($validatedData);

            flash('Profile information has been updated!');

            return Redirect::route('profile.edit');
        } catch (\Throwable $err) {
            Log::error($err->getMessage());

            flash('Failed to update profile information!', 'err');

            return Redirect::route('profile.edit');
        }
    }

    public function updateDataPribadi(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'digits:16', Rule::unique('users')->ignore(auth()->id())],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_telp' => ['nullable', 'digits_between:10,15'],
            'ktp' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, &$validatedData) {
            $user = $request->user();

            // Hapus & Simpan Foto KTP Baru dengan Nama Asli
            if ($request->file('ktp')) {
                if ($user->ktp && Storage::exists("photoKtp/{$user->ktp}")) {
                    Storage::delete("photoKtp/{$user->ktp}");
                }

                $file = $request->file('ktp');
                $fileName = $file->getClientOriginalName(); // Ambil nama asli
                $file->storeAs('photoKtp', $fileName); // Simpan dengan nama asli

                $validatedData['ktp'] = $fileName; // Simpan hanya nama file di database
            }

            // Update hanya data pribadi tanpa mengganggu data lain
            $user->update([
                'nik' => $validatedData['nik'],
                'ktp' => $validatedData['ktp'] ?? $user->ktp,
                'data' => array_merge($user->data ?? [], [
                    'alamat' => $validatedData['alamat'] ?? $user->data['alamat'] ?? null,
                    'no_telp' => $validatedData['no_telp'] ?? $user->data['no_telp'] ?? null,
                ]),
            ]);
        });

        flash('Data pribadi telah diperbarui!');

        return Redirect::route('profile.edit');
    }


    /**
     * Update the user's password.
     */
    public function password(Request $request): RedirectResponse
    {
        $validatedData = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        try {
            $request->user()->update(['password' => $validatedData['password']]);

            flash('Password has been updated!');

            return Redirect::route('profile.edit');
        } catch (\Throwable $err) {
            Log::error($err->getMessage());

            flash('Failed to update password!', 'err');

            return Redirect::route('profile.edit');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        Auth::logout();
        $user->delete();
        if ($user->avatar) {
            Storage::delete($user->rawAvatar());
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }
}
