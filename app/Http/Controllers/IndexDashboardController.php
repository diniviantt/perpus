<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class IndexDashboardController extends Controller
{
    public function HomeViewBook(Request $request){
        $kategori = Kategori::all();

        // Ambil hanya 4 data terbaru
        $buku = $request->has('search')
            ? Buku::with(['kategori_buku'])
                ->where('judul', 'like', '%' . $request->search . '%')
                ->orderBy('created_at', 'desc')
                ->limit(5) // Batasi hanya 4 buku
                ->get()
            : Buku::orderBy('created_at', 'desc')
                ->limit(5) // Batasi hanya 4 buku
                ->get();
        

        return view('user.home', compact('buku', 'kategori'));
    }

 
}
