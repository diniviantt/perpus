<?php

namespace App\Http\Controllers;

use App\Models\ModelHasRole;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class AnggotaController extends Controller
{
    public function index()
    {
        $user = User::role('user')->get();
        return view('anggota.tampil', compact('user'));
    }

    public function create()
    {
        $user = User::role('admin')->get();
        return view('anggota.tambah', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'npm' => 'required|unique:profiles', // Fixing unique table name
            'prodi' => 'required',
            'alamat' => 'required',
            'noTelp' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ], [
            'name.required' => "Nama tidak boleh kosong",
            'npm.required' => "Nomor Induk tidak boleh kosong",
            'npm.unique' => "NPM Telah Digunakan",
            'prodi.required' => "Prodi tidak boleh kosong",
            'alamat.required' => "Alamat tidak boleh kosong",
            'noTelp.required' => "Nomor Telepon tidak boleh kosong",
            'email.required' => "Email tidak boleh kosong",
            'email.unique' => "Email Telah Digunakan",
            'password.required' => "Password Tidak boleh kosong",
            'password.min' => "Password tidak boleh kurang dari 8 karakter"
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);



        Alert::success('Success', 'Berhasil Menambah Anggota');
        return redirect('/anggota');
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email', // Menambahkan validasi email
                'avatar' => 'nullable|mimes:jpg,jpeg,png|max:2048'
            ],
            [
                'name.required' => "Nama tidak boleh kosong",
                'email.required' => "Nomor Induk tidak boleh kosong",
                'email.email' => "Format email tidak valid", // Pesan untuk validasi email
                'avatar.mimes' => "Foto Profile Harus Berupa jpg, jpeg, atau png",
                'avatar.max' => "Ukuran gambar tidak boleh lebih dari 2048 KB" // Memperbaiki satuan dari MB ke KB
            ]
        );

        $user = User::find($id);

        if ($request->hasFile('avatar')) { // Memperbaiki nama 'photoProfile' menjadi 'avatar'
            $path = public_path('images/photoProfile'); // Menyimpan path ke variabel

            // Hapus gambar lama jika ada
            if ($user->avatar) {
                File::delete($path . '/' . $user->avatar);
            }

            // Menyimpan gambar baru
            $namaGambar = time() . '.' . $request->avatar->extension();
            $request->avatar->move($path, $namaGambar);
            $user->avatar = $namaGambar;
        }

        // Mengupdate nama dan email
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        Alert::success('Success', 'Berhasil Mengubah Profile');
        return redirect()->route('anggota.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $pinjamanUser = Peminjaman::where('users_id', $user->id)->get();
        return view('anggota.detail', compact('user', 'pinjamanUser'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('anggota.edit', compact('user'));
    }
}
