<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PengembalianController extends Controller
{
    public function index()
    {
        $iduser = Auth::id();
        $buku = Buku::where('status', 'dipinjam')->get();
        $user = User::all();
        $peminjam = User::where('id', '>', '1')->get();

        return view('pengembalian.pengembalian', ['users' => $user, 'buku' => $buku, 'peminjam' => $peminjam]);
    }

    public function pengembalian(Request $request)
    {

        $pinjaman = Peminjaman::where('users_id', $request->users_id)->where('buku_id', $request->buku_id)
            ->where('tanggal_pengembalian', null);
        $dataPinjaman = $pinjaman->first();
        $count = $pinjaman->count();

        if ($count == 1) {
            try {
                DB::beginTransaction();
                //update data tanggal pengembalian
                $dataPinjaman->tanggal_pengembalian = Carbon::now()->toDateString();
                $dataPinjaman->save();
                //update status buku
                $buku = Buku::findOrFail($request->buku_id);
                $buku->status = 'In Stock';
                $buku->save();
                DB::commit();
                Alert::success('Berhasil', 'Berhasil Mengembalikan Buku');
                return redirect('/peminjaman');
            } catch (\Throwable $th) {
                DB::rollback();
            }
        } else {
            Alert::warning('Gagal', 'Buku yang pinjam salah atau tidak ada');
            return redirect('/pengembalian');
        }
    }
}
