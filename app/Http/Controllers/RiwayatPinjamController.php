<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\ModelHasRole;
use App\Models\Peminjaman;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RiwayatPinjamController extends Controller
{
    public function index()
    {
        $iduser = Auth::id();
        $peminjam = Peminjaman::with(['user', 'buku'])->orderBy('updated_at', 'desc')->get();
        $pinjamanUser = Peminjaman::where('users_id', $iduser)->get();
        return view('peminjaman.tampil', ['peminjam' => $peminjam, 'pinjamanUser' => $pinjamanUser]);
    }


    public function create()
    {
        $iduser = Auth::id();
        $buku = Buku::where('stock', '>', 0)->get();


        // Periksa apakah pengguna memiliki peran 'user'
        if (Auth::user()->hasRole('peminjam')) {
            // Ambil pengguna dengan peran 'user'
            $peminjam = User::whereHas('roles', function ($query) {
                $query->where('name', 'peminjam');
            })->get();
        } else {
            // Ambil pengguna dengan role_id > 1 dari ModelHasRole
            $peminjam = ModelHasRole::with('user')->where('role_id', '>', 1)->get();
        }
        // dd($peminjam);

        return view('peminjaman.tambah', ['buku' => $buku, 'peminjam' => $peminjam]);
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'users_id' => 'required',
                'buku_id' => 'required'
            ],
            [
                'users_id.required' => 'Harap Masukkan Nama Peminjam',
                'buku_id.required' => 'Masukkan Buku yang akan dipinjam'
            ]
        );

        $request['tanggal_pinjam'] = Carbon::now()->toDateString();
        $request['tanggal_wajib_kembali'] = Carbon::now()->addDay(7)->toDateString();

        $buku = Buku::findOrFail($request->buku_id);

        $count = Peminjaman::where('users_id', $request->users_id)
            ->where('tanggal_pengembalian', null)
            ->count();

        if ($count >= 3) {
            Alert::warning('Gagal', 'User telah mencapai limit untuk meminjam buku');
            return redirect()->route('peminjaman.create');
        }

        if ($buku->stock <= 0) {
            Alert::warning('Gagal', 'Stok buku habis, tidak bisa dipinjam');
            return redirect()->route('peminjaman.create');
        }

        try {
            DB::beginTransaction();

            // Proses insert ke tabel peminjaman
            Peminjaman::create($request->all());

            // Kurangi stok buku
            $buku->stock -= 1;
            $buku->save();

            DB::commit();

            Alert::success('Berhasil', 'Berhasil Meminjam Buku');
            return redirect()->route('peminjaman.index');
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat meminjam buku');
            return redirect()->route('peminjaman.create');
        }
    }
}
