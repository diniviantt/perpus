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
        $iduser = Auth::id(); // ID user yang sedang login

        // Ambil daftar buku yang sedang dipinjam oleh user tertentu
        $bukuDipinjam = Peminjaman::where('users_id', Auth::id())
            // Tambahkan filter status jika diperlukan
            ->with('buku') // Pastikan ada relasi ke model Buku
            ->get();

        // dd($bukuDipinjam);

        // Ambil user yang memiliki role "peminjam"
        $peminjam = User::role('peminjam')->get(); // Jika pakai Spatie

        return view('pengembalian.pengembalian', [
            'bukuDipinjam' => $bukuDipinjam,
            'peminjam' => $peminjam
        ]);
    }




    public function pengembalian(Request $request)
    {
        $pinjaman = Peminjaman::where('users_id', $request->users_id)
            ->where('buku_id', $request->buku_id)
            ->whereNull('tanggal_pengembalian'); // Pastikan hanya buku yang belum dikembalikan

        $dataPinjaman = $pinjaman->first();

        try {
            DB::beginTransaction();
            // Update tanggal pengembalian
            $dataPinjaman->tanggal_pengembalian = Carbon::now()->toDateString();
            $dataPinjaman->save();

            // Update stock buku (karena status diubah menjadi stock)
            $buku = $dataPinjaman->buku; // Ambil relasi buku dari peminjaman
            $buku->stock += 1; // Tambah stok karena buku dikembalikan
            $buku->save();

            DB::commit();
            Alert::success('Berhasil', 'Buku berhasil dikembalikan');
            return redirect('/dashboard/peminjaman');
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat pengembalian');
            return redirect('/dashboard/pengembalian');
        }
    }

    public function getBuku(Request $request)
    {
        $buku = Peminjaman::with('buku')->where('users_id', $request->id)->get();
        return response()->json($buku);
    }
}
