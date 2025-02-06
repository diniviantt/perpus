<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Profile;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

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
        ]);

        $data = $request->only(['judul', 'kode_buku', 'pengarang', 'penerbit', 'tahun_terbit', 'deskripsi']);

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

        return view('buku.detail', compact('buku'));
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
        ], [
            'judul.required' => 'Judul tidak boleh kosong',
            'pengarang.required' => 'Pengarang tidak boleh kosong',
            'penerbit.required' => 'Penerbit tidak boleh kosong',
            'tahun_terbit.required' => 'Harap isi tahun terbit',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'gambar.mimes' => 'Gambar harus berupa jpg, jpeg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB',
        ]);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar) {
                File::delete(public_path('images/' . $buku->gambar));
            }

            $nama_gambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images'), $nama_gambar);
            $buku->gambar = $nama_gambar;
        }

        $buku->update($request->only(['judul', 'pengarang', 'penerbit', 'tahun_terbit', 'deskripsi']));

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
  
}
