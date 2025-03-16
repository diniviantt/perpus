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
use Yajra\DataTables\Facades\DataTables;

class AnggotaController extends Controller
{
    public function index()
    {
        $user = User::role('peminjam')->get();
        return view('anggota.tampil', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'npm' => 'required|unique:profiles',
            'prodi' => 'required',
            'alamat' => 'required',
            'noTelp' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Alert::success('Success', 'Berhasil Menambah Anggota');
        return redirect('/anggota');
    }

    public function show($id)
    {
        $anggota = User::find($id);

        if (!$anggota) {
            return response()->json(['error' => 'Anggota tidak ditemukan.'], 404);
        }

        return response()->json($anggota);
    }

    public function update(Request $request, $id)
    {
        $anggota = User::find($id);

        if (!$anggota) {
            return response()->json(['error' => 'Anggota tidak ditemukan.'], 404);
        }

        $anggota->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'Data anggota berhasil diperbarui.']);
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('anggota.edit', compact('user'));
    }

    public function destroy($id)
    {
        try {
            $User = User::findOrFail($id);
            $User->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data!'
            ], 500);
        }
    }
    public function TabelPeminjam()
    {
        $peminjam = User::role('peminjam')->get();
        // dd($peminjam);

        return DataTables::of($peminjam)
            ->addIndexColumn()
            ->addColumn('name', function ($peminjam) {
                if (isset($peminjam->avatar)) {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . $peminjam->avatar . '" alt="" class="object-cover rounded-full size-10">
                    <span>' . $peminjam->name . '</span>
                    </div>';
                } else {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . asset('assets/img/profile.webp') . '" alt="" class="object-cover rounded-full size-10">
                    <span>' . $peminjam->name . '</span>
                    </div>';
                }

                return $img;
            })
            ->addColumn('email', function ($peminjam) {
                return $peminjam->email ?? '-';
            })
            ->addColumn('option', 'anggota.dropdown-anggota')
            ->rawColumns(['name', 'email', 'option']) // Memastikan HTML bisa dirender dengan benar
            ->make(true);
    }



    public function TabelPetugas()
    {
        $peminjam = User::role('petugas')->get();
        // dd($peminjam);

        return DataTables::of($peminjam)
            ->addIndexColumn()
            ->addColumn('name', function ($peminjam) {
                if (isset($peminjam->avatar)) {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . $peminjam->avatar . '" alt="" class="object-cover rounded-full size-10">
                    <span>' . $peminjam->name . '</span>
                    </div>';
                } else {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . asset('assets/img/profile.webp') . '" alt="" class="object-cover rounded-full size-10">
                    <span>' . $peminjam->name . '</span>
                    </div>';
                }

                return $img;
            })
            ->addColumn('email', function ($peminjam) {
                return $peminjam->email ?? '-';
            })
            ->addColumn('option', 'anggota.dropdown-anggota')
            ->rawColumns(['name', 'email', 'option']) // Memastikan HTML bisa dirender dengan benar
            ->make(true);
    }

    public function TabelAdmin()
    {
        $peminjam = User::role('admin')->get();
        // dd($peminjam);

        return DataTables::of($peminjam)
            ->addIndexColumn()
            ->addColumn('name', function ($peminjam) {
                if (isset($peminjam->avatar)) {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . $peminjam->avatar . '" alt="" class="object-cover rounded-full size-10">
                    <span>' . $peminjam->name . '</span>
                    </div>';
                } else {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . asset('assets/img/profile.webp') . '" alt="" class="object-cover rounded-full size-10">
                    <span>' . $peminjam->name . '</span>
                    </div>';
                }

                return $img;
            })
            ->addColumn('email', function ($peminjam) {
                return $peminjam->email ?? '-';
            })
            ->addColumn('option', 'anggota.dropdown-anggota')
            ->rawColumns(['name', 'email', 'option']) // Memastikan HTML bisa dirender dengan benar
            ->make(true);
    }
}
