<?php

namespace App\Http\Controllers;

use App\Exports\BukuExport;
use App\Imports\BukuImport;
use App\Models\Buku;
use App\Models\Koleksi;
use App\Models\Profile;
use App\Models\Kategori;
use App\Models\KategoriBuku;
use App\Models\MasterDenda;
use App\Models\Peminjaman;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $kategori = Kategori::all(); // Ambil semua kategori

        // Ambil semua buku atau filter berdasarkan kategori jika ada
        $buku = Buku::with('kategori_buku')
            ->when(!$user->hasRole('admin'), function ($query) {
                // Jika bukan admin, hanya tampilkan buku yang aktif
                $query->where('status', 'Aktif');
            })
            ->when($request->kategori, function ($query, $kategoriId) {
                $query->whereHas('kategori_buku', function ($q) use ($kategoriId) {
                    $q->where('kategori_id', $kategoriId);
                });
            })
            ->when($request->search, function ($query) {
                $query->where('judul', 'like', '%' . request('search') . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->appends(request()->query());

        // Ambil daftar koleksi buku milik user
        $koleksi = Koleksi::where('users_id', $user->id)->with('buku')->get();
        $koleksiBukuIds = $koleksi->pluck('buku_id')->toArray();

        // Ambil daftar buku yang sedang dipinjam oleh user
        $bukuDipinjam = Peminjaman::where('users_id', $user->id)
            ->whereNull('tanggal_pengembalian') // Hanya buku yang belum dikembalikan
            ->with('buku') // Mengambil detail buku terkait
            ->get();

        $bukuDipinjamIds = $bukuDipinjam->pluck('buku_id')->toArray();

        $bukuTerpopuler = Peminjaman::select('buku_id', DB::raw('COUNT(buku_id) as total_peminjaman'))
            ->where('status', 'Dikembalikan')
            ->groupBy('buku_id')
            ->orderByDesc('total_peminjaman')
            ->with(['buku' => function ($query) use ($request, $user) {
                if (!$user->hasRole('admin')) {
                    $query->where('status', 'Aktif');
                }
                if ($request->kategori) {
                    $query->whereHas('kategori_buku', function ($q) use ($request) {
                        $q->where('kategori_id', $request->kategori);
                    });
                }
                if ($request->search) {
                    $query->where('judul', 'like', '%' . $request->search . '%');
                }
                $query->with('kategori_buku');
            }])
            ->take(6)
            ->get()
            ->filter(function ($item) {
                return $item->buku !== null; // Pastikan hanya data yang memiliki buku
            })
            ->map(function ($item) {
                return $item->buku;
            });

        // dd($bukuTerpopuler);

        return view('buku.tampil', compact('buku', 'kategori', 'koleksiBukuIds', 'koleksi', 'bukuDipinjam', 'bukuTerpopuler'));
    }


    // Cek stok buku berdasarkan ID
    public function cekStok($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['success' => false, 'message' => 'Buku tidak ditemukan'], 404);
        }
        return response()->json(['stok' => $buku->stock]);
    }

    // Proses peminjaman buku
    public function pinjamBuku(Request $request, $id)
    {
        $user = auth()->user();
        $buku = Buku::findOrFail($id);

        // Cek apakah user sudah meminjam buku ini
        if (Peminjaman::where('users_id', $user->id)
            ->where('buku_id', $buku->id)
            ->whereNull('tanggal_pengembalian')
            ->exists()
        ) {
            return response()->json(['success' => false, 'message' => 'Anda sudah meminjam buku ini']);
        }

        // Cek batas maksimal peminjaman (misal: 3 buku)
        if (Peminjaman::where('users_id', $user->id)->whereNull('tanggal_pengembalian')->count() >= 3) {
            return response()->json(['success' => false, 'message' => 'Anda telah mencapai batas peminjaman']);
        }

        // Cek stok buku
        if ($buku->stock <= 0) {
            return response()->json(['success' => false, 'message' => 'Stok habis']);
        }

        // Gunakan transaksi database
        DB::beginTransaction();
        try {
            // Buat peminjaman
            $peminjaman = Peminjaman::create([
                'users_id' => $user->id,
                'buku_id' => $buku->id,
                'tanggal_pinjam' => now(),
                'tanggal_wajib_kembali' => now()->addDays(7),
            ]);

            // Kurangi stok buku
            $buku->decrement('stock');

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Berhasil meminjam']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan, silakan coba lagi']);
        }
    }



    public function create()
    {
        $kategori = Kategori::all();

        return view('buku.tambah', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'kode_buku' => 'required|string|max:50|unique:buku',
            'kategori_buku' => 'required|array',
            'kategori_buku.*' => 'exists:kategori,id',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|min:1900|max:' . date('Y'),
            'stock' => 'required|numeric|min:1',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
            'tarif_denda' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except('kategori_buku');

            if ($request->hasFile('gambar')) {
                $nama_gambar = time() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('images'), $nama_gambar);
                $data['gambar'] = $nama_gambar;
            }

            $buku = Buku::create($data);

            MasterDenda::create([
                'buku_id' => $buku->id,
                'tarif_denda' => $request->tarif_denda,
            ]);

            if ($request->has('kategori_buku') && method_exists($buku, 'kategori_buku')) {
                $buku->kategori_buku()->sync($request->kategori_buku);
            }

            DB::commit();

            return response()->json([
                'success' => true,  // Tambahkan ini agar jQuery bisa membaca respons sukses
                'message' => 'Buku berhasil ditambahkan.',
                'data' => $buku
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        $bukuDipinjam = Peminjaman::where('users_id', auth()->id())
            ->where('buku_id', $buku->id)
            ->whereNull('tanggal_pengembalian') // Belum dikembalikan
            ->exists();
        $ketBuku = KategoriBuku::with('buku')->where('buku_id', $id)->get();
        $reviews = Ulasan::with('buku', 'user')->where('buku_id', $id)->latest()->get();


        return view('buku.detail', compact(
            'buku',
            'ketBuku',
            'bukuDipinjam',
            'reviews'
        ));
    }

    public function edit($id)
    {
        $kategori = Kategori::all();
        $buku = Buku::with('kategori_buku')->findOrFail($id);

        // Ambil tarif denda jika ada
        $tarif_denda = MasterDenda::where('buku_id', $buku->id)->value('tarif_denda');

        // Ambil ID kategori yang dimiliki buku
        $kategori_terpilih = $buku->kategori_buku->pluck('id')->toArray();

        return view('buku.edit', compact('buku', 'kategori', 'tarif_denda', 'kategori_terpilih'));
    }


    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required|integer|min:1',
            'tarif_denda' => 'required|numeric|min:0',
        ], [
            'judul.required' => 'Judul tidak boleh kosong',
            'pengarang.required' => 'Pengarang tidak boleh kosong',
            'penerbit.required' => 'Penerbit tidak boleh kosong',
            'tahun_terbit.required' => 'Harap isi tahun terbit',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka',
            'tahun_terbit.min' => 'Tahun terbit tidak boleh kurang dari 1900',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh lebih dari tahun saat ini',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'gambar.mimes' => 'Gambar harus berupa jpg, jpeg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB',
            'stock.required' => 'Stock tidak boleh kosong',
            'tarif_denda.required' => 'Tarif denda tidak boleh kosong',
            'tarif_denda.numeric' => 'Tarif denda harus berupa angka',
            'tarif_denda.min' => 'Tarif denda tidak boleh kurang dari 0',
        ]);

        try {
            DB::beginTransaction();

            // Ambil data kecuali kategori_buku
            $data = $request->except('kategori_buku');

            // Cek apakah ada gambar baru yang diunggah
            if ($request->hasFile('gambar')) {
                if ($buku->gambar) {
                    File::delete(public_path('images/' . $buku->gambar));
                }

                $nama_gambar = time() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('images'), $nama_gambar);
                $data['gambar'] = $nama_gambar;
            }

            // Update data buku
            $buku->update($data);

            // Update tarif denda di tabel master_dendas
            MasterDenda::updateOrCreate(
                ['buku_id' => $buku->id],
                ['tarif_denda' => $request->tarif_denda]
            );

            // Sinkronisasi kategori buku jika tersedia
            if ($request->has('kategori_buku')) {
                $buku->kategori_buku()->sync($request->kategori_buku);
            }

            DB::commit();

            Alert::success('Berhasil', 'Update Berhasil');
            return redirect()->route('buku.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('buku.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->gambar) {
            File::delete(public_path('images/' . $buku->gambar));
        }

        $buku->delete();

        // Mengirim respons JSON yang memberitahu bahwa penghapusan berhasil
        return response()->json([
            'status' => 'success',
            'message' => 'Buku berhasil terhapus!'
        ]);
    }

    public function export()
    {
        return Excel::download(new BukuExport, 'buku.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import' => 'required|mimes:xlsx,xls',
        ]);

        // Mengimpor data dari file Excel
        Excel::import(new BukuImport($request->file('import')->getRealPath()), $request->file('import'));

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diimpor!');
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
            ->addColumn('option', 'buku.dropdown-buku') // Pastikan view ini ada
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

    public function toggleStatus($id)
    {
        try {
            // Ambil buku berdasarkan ID
            $buku = Buku::findOrFail($id);

            Log::info("Mengubah status buku ID: " . $buku->id);

            // Ubah status "Aktif" menjadi "Non Aktif" dan sebaliknya
            $buku->status = $buku->status === "Aktif" ? "Non Aktif" : "Aktif";
            $buku->save();

            Log::info("Status buku sekarang: " . $buku->status);

            return response()->json([
                'message' => $buku->status === "Aktif" ? "Buku berhasil diaktifkan!" : "Buku berhasil dinonaktifkan!",
                'status' => $buku->status
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error saat update status buku: " . $e->getMessage());

            return response()->json([
                'message' => 'Terjadi kesalahan!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
