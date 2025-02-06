<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CetakLaporanController extends Controller
{
    public function __invoke(Request $request)
    {
        $riwayat_peminjaman = Peminjaman::with('user', 'buku')->get();

        $pdf = Pdf::loadView('peminjaman.laporan_pdf', ['riwayat_peminjaman' => $riwayat_peminjaman]);

        return $pdf->download('laporan_peminjaman.pdf');
    }
}
