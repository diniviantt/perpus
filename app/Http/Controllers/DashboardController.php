<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\ModelHasRole;
use App\Models\Peminjaman;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $iduser = Auth::id();
        $kategori = Kategori::count();
        $buku = Buku::count();
        $user = User::role('user')->count();
        $riwayat_pinjam = Peminjaman::with(['user', 'buku'])->orderBy('updated_at', 'desc')->get();
        $jumlah_riwayat = Peminjaman::count();
        $pinjamanUser = Peminjaman::where('users_id', $iduser)->where('tanggal_pengembalian', null)->count();
        return view('dashboard.index', compact('kategori', 'buku', 'user', 'riwayat_pinjam', 'jumlah_riwayat'));
    }

    public function admin()
    {
        $user = ModelHasRole::with(['user', 'role'])->where('role_id',  '2')->get();
        return view('dashboard.admin', [
            'user' => $user
        ]);
    }

    public function TableUserManage()
    {
        $users = ModelHasRole::with(['user', 'role'])
            ->where('role_id', 2) // Pastikan ini adalah role_id yang Anda inginkan
            ->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($user) {
                // return $user->user ? $user->user->name : 'N/A'; // Pengecekan null
                if (isset($user->user->avatar)) {
                    $img = '<div class="flex flex-row gap-x-3 items-center">
                    <img src="' . $user->user->avatar . '" alt="" class="rounded-full size-10 object-cover">
                    <span>' . $user->user->name . '</span>
                    </div>';
                } else {
                    $img = '<div class="flex flex-row gap-x-3 items-center">
                    <img src="' . asset('assets/img/profile.webp') . '" alt="" class="rounded-full size-10 object-cover">
                    <span>' . $user->user->name . '</span>
                    </div>';
                }

                return $img;
            })
            ->addColumn('email', function ($user) {
                return $user->user ? $user->user->email : 'N/A'; // Pengecekan null
            })
            ->addColumn('role', function ($user) {
                return '<span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-400 dark:text-blue-600">' . $user->role->name . '</span>';
            })
            ->addColumn('option', 'dashboard.dropdown-admin') // Pastikan view ini ada
            ->rawColumns(['name', 'email', 'role', 'option']) // Mengizinkan HTML di kolom ini
            ->make(true);
    }

    public function destroy($id)
    {
        // Temukan anggota berdasarkan ID dan hapus
        $anggota = ModelHasRole::findOrFail($id);
        $anggota->delete();

        return response()->json(['status' => 'success']);
    }

    public function user()
    {
        return view('dashboard.user');
    }
}
