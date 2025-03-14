<?php

namespace App\Http\Controllers;

use App\Exports\BukuExport;
use App\Imports\BukuImport;
use App\Models\Buku;
use App\Models\Koleksi;
use App\Models\Profile;
use App\Models\Kategori;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $kategori = Kategori::all();

        // Ambil daftar buku berdasarkan pencarian jika ada
        $buku = Buku::with('kategori_buku')
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('judul', 'like', '%' . $request->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        // Ambil daftar koleksi buku milik user
        $koleksi = Koleksi::where('users_id', $user->id)
            ->with('buku')
            ->get();

        $koleksiBukuIds = $koleksi->pluck('buku_id')->toArray();

        return view('buku.tampil', compact('buku', 'kategori', 'koleksiBukuIds', 'koleksi'));
    }


    public function create()
    {
        $kategori = Kategori::all();

        return view('buku.tambah', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kode_buku' => 'required|unique:buku',
            'kategori_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required',
        ], [
            'judul.required' => 'Judul tidak boleh kosong',
            'kode_buku.required' => 'Kode Buku Tidak Boleh Kosong',
            'kode_buku.unique' => 'Kode Buku Telah Tersedia',
            'kategori_buku.required' => 'Harap masukan kategori',
            'pengarang.required' => 'Pengarang tidak boleh kosong',
            'penerbit.required' => 'Penerbit tidak boleh kosong',
            'tahun_terbit.required' => 'Harap isi tahun terbit',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'gambar.mimes' => 'Gambar harus berupa jpg, jpeg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB',
            'stock.required' => 'Stock tidak boleh kosong',
        ]);

        $data = $request->only(['judul', 'kode_buku', 'pengarang', 'penerbit', 'tahun_terbit', 'deskripsi', 'stock']);

        if ($request->hasFile('gambar')) {
            $nama_gambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images'), $nama_gambar);
            $data['gambar'] = $nama_gambar;
        }

        $buku = Buku::create($data);

        if ($request->has('kategori_buku')) {
            $buku->kategori_buku()->sync($request->kategori_buku);
        }

        Alert::success('Berhasil', 'Berhasil Menambahkan Data Buku');
        return redirect()->route('buku.index');
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        $ketBuku = KategoriBuku::with('buku')->where('buku_id', $id)->get();

        return view('buku.detail', compact(
            'buku',
            'ketBuku'
        ));
    }

    public function edit($id)
    {
        $kategori = Kategori::all();
        $buku = Buku::findOrFail($id);

        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required',
        ], [
            'judul.required' => 'Judul tidak boleh kosong',
            'pengarang.required' => 'Pengarang tidak boleh kosong',
            'penerbit.required' => 'Penerbit tidak boleh kosong',
            'tahun_terbit.required' => 'Harap isi tahun terbit',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'gambar.mimes' => 'Gambar harus berupa jpg, jpeg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB',
            'stock.required' => 'Stock tidak boleh kosong',

        ]);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar) {
                File::delete(public_path('images/' . $buku->gambar));
            }

            $nama_gambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images'), $nama_gambar);
            $buku->gambar = $nama_gambar;
        }

        $buku->update($request->only(['judul', 'pengarang', 'penerbit', 'tahun_terbit', 'deskripsi', 'stock']));

        if ($request->has('kategori_buku')) {
            $buku->kategori_buku()->sync($request->kategori_buku);
        }

        Alert::success('Berhasil', 'Update Berhasil');
        return redirect()->route('buku.index');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->gambar) {
            File::delete(public_path('images/' . $buku->gambar));
        }

        $buku->delete();

        Alert::success('Berhasil', 'Buku Berhasil Terhapus');
        return redirect()->route('buku.index');
    }

    public function export()
    {
        return Excel::download(new BukuExport, 'buku.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $file = $request->file('file');
        $nama_file = time() . '.' . $file->extension();
        $file->move(public_path('import'), $nama_file);

        Excel::import(new BukuImport, public_path('import/' . $nama_file));

        Alert::success('Berhasil', 'Data Buku Berhasil Diimport');
        return redirect()->route('buku.index');
    }

    public function listBuku()
    {
        $buku = Buku::all();

        return view('buku.list', compact('buku'));
    }

    public function tableBuku()
    {
        $buku = Buku::all();

        return DataTables::of($buku)
            ->addIndexColumn()
            ->addColumn('gambar', function ($buku) {
                if (isset($buku->gambar)) {
                    $img = '<div class="flex flex-row items-center">
                   <img src="' . asset('images/' . $buku->gambar) . '" alt="" class="object-cover">
    </div>';
                } else {
                    $img = '<div class="flex flex-row items-center gap-x-3">
                    <img src="' . asset('images/noImage.jpg') . '" alt="" class="object-cover rounded-full size-10">
                    </div>';
                }

                return $img;
            })
            ->addColumn('judul', function ($buku) {
                return $buku ? $buku->judul : 'N/A'; // Pengecekan null
            })
            ->addColumn('kode_buku', function ($buku) {
                return $buku ? $buku->kode_buku : 'N/A'; // Pengecekan null  
            })
            ->addColumn('pengarang', function ($buku) {
                return $buku ? $buku->pengarang : 'N/A';
            })
            ->addColumn('penerbit', function ($buku) {
                return $buku ? $buku->penerbit : 'N/A';
            })
            ->addColumn('tahun_terbit', function ($buku) {
                return $buku ? $buku->tahun_terbit : 'N/A';
            })
            ->addColumn('deskripsi', function ($buku) {
                return $buku ? $buku->deskripsi : 'N/A';
            })
            ->addColumn('stock', function ($buku) {
                return $buku ? $buku->stock : 'N/A';
            })
            ->addColumn('option', 'buku.dropdown') // Pastikan view ini ada
            ->rawColumns(['gambar', 'judul', 'kode_buku', 'pengarang', 'penerbit', 'tahun_terbit', 'deskripsi', 'stock', 'option']) // Mengizinkan HTML di kolom ini
            ->make(true);
    }

    public function koleksiBuku(Request $request)
    {
        $user = auth()->user();

        // Ambil koleksi buku user dengan relasi buku dan kategorinya
        $koleksi = Koleksi::where('users_id', $user->id)
            ->with('buku.kategori_buku')
            ->get();

        // Ambil semua kategori
        $kategori = Kategori::all();

        // Ambil daftar buku berdasarkan pencarian jika ada, dengan pagination
        $buku = Buku::with('kategori_buku')
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->where('judul', 'like', '%' . $request->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        // Buat daftar ID buku yang ada di koleksi user
        $koleksiBukuIds = $koleksi->pluck('buku_id')->toArray();

        // Tambahkan properti isInCollection ke setiap buku
        $buku->getCollection()->transform(function ($b) use ($koleksiBukuIds) {
            $b->isInCollection = in_array($b->id, $koleksiBukuIds);
            return $b;
        });

        return view('buku.koleksi', compact('koleksi', 'buku', 'kategori'));
    }


    public function tambahKoleksi(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        $bukuId = $request->buku_id;

        // Cek apakah buku sudah ada di koleksi user
        $exists = Koleksi::where('users_id', $user->id)
            ->where('buku_id', $bukuId)
            ->exists();

        if ($exists) {
            return response()->json(['status' => 'exists', 'message' => 'Buku sudah ada di koleksi Anda.']);
        }

        // Simpan ke koleksi
        Koleksi::create([
            'users_id' => $user->id,
            'buku_id' => $bukuId
        ]);

        return response()->json(['status' => 'success']);
    }

    public function hapusKoleksi($id)
    {
        $koleksi = Koleksi::where('id', $id)->where('users_id', Auth::id())->first();

        if ($koleksi) {
            $koleksi->delete();
            return response()->json(['status' => 'deleted', 'message' => 'Buku berhasil dihapus dari koleksi']);
        }

        return response()->json(['status' => 'error', 'message' => 'Buku tidak ditemukan di koleksi user']);
    }
}
