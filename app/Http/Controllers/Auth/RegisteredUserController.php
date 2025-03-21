<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16', 'unique:users,nik'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_telp' => ['nullable', 'digits_between:10,15'],
            'ktp' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // ✅ Tambahkan validasi KTP
        ]);

        // Cek apakah user mengupload file KTP
        if ($request->hasFile('ktp')) {
            // Ambil ekstensi file asli
            $originalName = $request->file('ktp')->getClientOriginalName();
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);

            // Buat nama unik untuk file
            $filename = uniqid() . '.' . $extension;

            // Simpan file ke folder `images/photoProfile/`
            $request->file('ktp')->storeAs('photoProfile', $filename, 'public');

            // Simpan hanya nama file ke database
            $ktpPath = $filename; // ✅ Hanya menyimpan nama file
        } else {
            $ktpPath = null;
        }

        // Simpan user ke database
        $user = User::create([
            'name' => $validatedData['name'],
            'nik' => $validatedData['nik'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'ktp' => $ktpPath, // ✅ Hanya nama file yang disimpan
            'data' => [
                'alamat' => $validatedData['alamat'] ?? null,
                'no_telp' => $validatedData['no_telp'] ?? null,
            ],
        ]);




        $user->assignRole('peminjam');

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
