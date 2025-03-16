<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

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
        $request->validate([
            'nama' => 'required|min:2',
        ], [
            'nama.required' => "Masukkan nama kategori",
            'nama.min' => "Minimal 2 karakter"
        ]);

        try {
            $kategori = Kategori::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'data' => $kategori
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan kategori!',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function show($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan!'
            ], 404);
        }

        return response()->json([
            'nama' => $kategori->nama,
            'deskripsi' => $kategori->deskripsi
        ]);
    }


    public function edit($id)
    {
        $kategori = Kategori::find($id);
        return view('kategori.edit', ['kategori' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        Log::info('Request update kategori:', $request->all());

        // Validasi request
        $request->validate([
            'nama' => 'required|min:2',
        ], [
            'nama.required' => "Masukkan nama kategori",
            'nama.min' => "Minimal 2 karakter"
        ]);

        $kategori = Kategori::find($id);

        if (!$kategori) {
            Log::error('Kategori tidak ditemukan: ' . $id);
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan!'
            ], 404);
        }

        try {
            $kategori->nama = $request->nama;
            $kategori->deskripsi = $request->deskripsi ?? $kategori->deskripsi;
            $kategori->save();

            Log::info('Kategori berhasil diperbarui:', ['id' => $id, 'nama' => $kategori->nama]);

            return response()->json([
                'status' => 'success',
                'message' => 'Kategori berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating kategori: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui kategori!'
            ], 500);
        }
    }




    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Kategori berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data!'
            ], 500);
        }
    }



    public function TabelKategori()
    {
        $kategori = Kategori::select(['id', 'nama', 'deskripsi']);

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('nama', function ($kategori) {
                return $kategori->nama ?? '-';
            })
            ->addColumn('deskripsi', function ($kategori) {
                return $kategori->deskripsi ?? '-';
            })
            ->addColumn('option', 'kategori.dropdown-kategori')
            ->rawColumns(['name', 'deskripsi', 'option']) // Memastikan HTML bisa dirender dengan benar
            ->make(true);
    }
}
