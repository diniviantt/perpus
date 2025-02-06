<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.tampil', ['kategori' => $kategori]);
    }


    public function create()
    {
        $iduser = Auth::id();
        $kategori = Kategori::all();
        return view('kategori.tambah', ['kategori' => $kategori]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|min:2',
            ],
            [
                'nama.required' => "Masukkan nama kategori",
                'nama.min' => "Minimal 2 karakter"
            ]
        );

        $kategori = Kategori::create($request->all());

        Alert::success('Berhasil', 'Berhasil Menambahkan Kategori');
        return redirect()->route('kategori.index');
    }


    public function show($id)
    {
        $kategori = Kategori::find($id);
        $buku = Buku::all();
        return view('kategori.detail', ['kategori' => $kategori, 'buku' => $buku]);
    }


    public function edit($id)
    {
        $kategori = Kategori::find($id);
        return view('kategori.edit', ['kategori' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama' => 'required|min:2',
            ],
            [
                'nama.required' => "Masukkan nama kategori",
                'nama.min' => "Minimal 2 karakter"
            ]
        );

        $kategori = new Kategori;
        $kategori = Kategori::find($id);

        $kategori->nama = $request->nama;
        $kategori->deskripsi = $request->deskripsi;

        $kategori->save();

        Alert::success('Berhasil', 'Update Success');
        return redirect()->route('kategori.index');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        $kategori->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus Kategori');
        return redirect()->route('kategori.index');
    }
}
