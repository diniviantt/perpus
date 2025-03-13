<?php

namespace App\Http\Controllers;

use App\Exports\BukuExport;
use App\Imports\BukuImport;
use App\Models\Buku;
use App\Models\Profile;
use App\Models\Kategori;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        $buku = $request->has('search')
            ? Buku::with(['kategori_buku'])->where('judul', 'like', '%' . $request->search . '%')->orderBy('created_at', 'desc')->paginate(8)
            : Buku::orderBy('created_at', 'desc')->paginate(8);


        return view('buku.tampil', compact('buku', 'kategori'));
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
}
