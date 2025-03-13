<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\ModelHasRole;
use App\Models\Peminjaman;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RiwayatPinjamController extends Controller
{
    public function index()
    {
        $iduser = Auth::id();
        $peminjam = User::role('peminjam')->orderBy('updated_at', 'desc')->get();
        $pinjamanUser = Peminjaman::where('users_id', $iduser)->get();
        return view('peminjaman.tampil', ['peminjam' => $peminjam, 'pinjamanUser' => $pinjamanUser]);
    }


    public function create()
    {
        $iduser = Auth::id();
        $buku = Buku::where('stock', '>', 0)->get();


        // Periksa apakah pengguna memiliki peran 'user'
        if (Auth::user()->hasRole('peminjam')) {
            // Ambil pengguna dengan peran 'user'
            $peminjam = User::whereHas('roles', function ($query) {
                $query->where('name', 'peminjam');
            })->get();
        } else {
            // Ambil pengguna dengan role_id > 1 dari ModelHasRole
            $peminjam = ModelHasRole::with('user')->where('role_id', '>', 1)->get();
        }
        // dd($peminjam);

        return view('peminjaman.tambah', ['buku' => $buku, 'peminjam' => $peminjam]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'users_id' => 'required',
            'buku_id' => 'required', // Sesuaikan dengan nama tabel di database
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Cek limit peminjaman
        $count = Peminjaman::where('users_id', $request->users_id)
            ->whereNull('tanggal_pengembalian')
            ->count();

        if ($count >= 3) {
            Alert::warning('Gagal', 'User telah mencapai limit untuk meminjam buku');
            return back();
        }

        // Pastikan stok buku masih tersedia
        if ($buku->stock <= 0) {
            Alert::warning('Gagal', 'Stok buku habis, tidak bisa dipinjam');
            return back();
        }

        try {
            DB::beginTransaction();

            // Atur tanggal otomatis
            $tanggalPinjam = Carbon::now()->toDateString();
            $tanggalWajibKembali = Carbon::now()->addDays(7)->toDateString();

            $peminjaman = Peminjaman::create([
                'users_id' => $request->users_id,
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_wajib_kembali' => $tanggalWajibKembali, // Sesuai dengan ENUM di database
            ]);

            if (!$peminjaman) {
                throw new \Exception("Gagal menyimpan data peminjaman");
            }

            // Kurangi stok buku
            $buku->decrement('stock');

            DB::commit();

            Alert::success('Berhasil', 'Berhasil Meminjam Buku');
            return redirect()->route('peminjaman.index');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error' => $th->getMessage()]); // Menampilkan error ke user
        }
    }





    public function tablePeminjaman(Request $request)
    {
        if ($request->ajax()) {
            $iduser = auth()->id();
            $user = auth()->user();

            $peminjam = Peminjaman::with(['user:id,name', 'buku:id,judul,kode_buku'])
                ->select(['id', 'users_id', 'buku_id', 'tanggal_pinjam', 'tanggal_wajib_kembali', 'tanggal_pengembalian', 'denda', 'status', 'updated_at'])
                ->when(!$user->hasRole('admin'), function ($query) use ($iduser) {
                    return $query->where('users_id', $iduser);
                })
                ->orderBy('updated_at', 'desc');

            return DataTables::of($peminjam)
                ->addIndexColumn()
                ->addColumn('nama', fn($row) => $row->user->name ?? '-')
                ->addColumn('judul_buku', fn($row) => $row->buku->judul ?? '-')
                ->addColumn('kode_buku', fn($row) => $row->buku->kode_buku ?? '-')
                ->addColumn('tanggal_pinjam', fn($row) => $row->tanggal_pinjam ? \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d-m-Y') : '-')
                ->addColumn('tanggal_wajib_kembali', fn($row) => $row->tanggal_wajib_kembali ? \Carbon\Carbon::parse($row->tanggal_wajib_kembali)->format('d-m-Y') : '-')
                ->addColumn('tanggal_pengembalian', fn($row) => $row->tanggal_pengembalian ? \Carbon\Carbon::parse($row->tanggal_pengembalian)->format('d-m-Y') : '-')
                ->addColumn('denda', fn($row) => $row->denda ? 'Rp ' . number_format($row->denda, 0, ',', '.') : '-')
                ->addColumn('status', function ($row) {
                    $statuses = [
                        'Menunggu Konfirmasi' => ['label' => 'Menunggu Konfirmasi', 'ring' => 'ring-orange-400', 'bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>'],
                        'proses' => ['label' => 'Proses', 'ring' => 'ring-yellow-400', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>'],
                        'Menunggu Pengambilan' => ['label' => 'Menunggu Pengambilan', 'ring' => 'ring-blue-400', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'],
                        'Dipinjam' => ['label' => 'Dipinjam', 'ring' => 'ring-purple-400', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5V6a2 2 0 0 1 2-2h9"/><path d="M16 2v4"/><path d="M16 10v4"/><path d="M10 16h6a2 2 0 0 1 2 2v1.5"/><path d="M2 19.5h20"/></svg>'],
                        'Dikembalikan' => ['label' => 'Dikembalikan', 'ring' => 'ring-green-400', 'bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>'],
                    ];

                    // Jika status tidak ditemukan, gunakan default "Menunggu Konfirmasi"
                    $currentStatus = $statuses[$row->status] ?? $statuses['menunggu_konfirmasi'];

                    return '
                    <span id="badge-' . $row->id . '" class="px-3 py-0.5 text-xs rounded-full ring-1 ' . $currentStatus['ring'] . ' ' . $currentStatus['bg'] . ' ' . $currentStatus['text'] . ' flex items-center gap-1">
                        ' . $currentStatus['icon'] . '
                        ' . $currentStatus['label'] . '
                    </span>';
                })

                ->addColumn('option', 'peminjaman.status_option')
                ->rawColumns(['status', 'option'])
                ->make(true);
        }
    }




    // 2️⃣ Admin mengonfirmasi peminjaman
    public function konfirmasiPinjam($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->update(['status' => 'Menunggu Pengambilan']);

        return response()->json(['message' => 'Peminjaman dikonfirmasi, menunggu pengambilan']);
    }

    // 3️⃣ User mengambil buku
    public function ambilBuku($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->update(['status' => 'Dipinjam']);

        return response()->json(['message' => 'Buku telah diambil']);
    }

    // 4️⃣ User mengembalikan buku + hitung keterlambatan & denda
    public function kembalikanBuku($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // Hitung keterlambatan
        $tanggal_jatuh_tempo = $pinjam->tanggal_wajib_kembali;
        $hariTerlambat = Carbon::parse($tanggal_jatuh_tempo)->diffInDays(now(), false);

        $keterlambatan = $hariTerlambat > 0 ? $hariTerlambat : 0;

        // Hitung denda (misal Rp1000 per hari)
        $denda = $keterlambatan * 1000;

        try {
            DB::beginTransaction();

            // Update status peminjaman
            $pinjam->update([
                'status' => 'Dikembalikan',
                'tanggal_pengembalian' => now(),
                'keterlambatan' => $keterlambatan,
                'denda' => $denda
            ]);

            // Update stok buku
            $buku = $pinjam->buku; // Ambil relasi buku dari peminjaman
            $buku->increment('stock'); // Tambah stok karena buku dikembalikan

            DB::commit();

            return response()->json([
                'message' => 'Buku telah dikembalikan',
                'keterlambatan' => $keterlambatan,
                'denda' => $denda
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getBuku(Request $request)
    {
        $buku = Buku::where('stock', '>', 0)->get();
        if ($buku->isEmpty()) {
            return response()->json(['message' => 'Stok buku habis']);
        }
        return response()->json($buku);
    }
}
