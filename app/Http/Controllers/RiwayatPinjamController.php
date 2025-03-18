<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
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

        $masaPinjam = Peminjaman::with('buku')
            ->where('users_id', $iduser)
            ->where('status', 'Dipinjam') // Pastikan statusnya benar
            ->whereNull('tanggal_pengembalian') // Pastikan belum dikembalikan
            ->get();

        $notifikasi = [];

        foreach ($masaPinjam as $pinjam) {
            $judulBuku = $pinjam->buku->judul;
            $tanggalPengembalian = Carbon::parse($pinjam->tanggal_wajib_kembali)->endOfDay();
            $sisaHari = now()->diffInDays($tanggalPengembalian, false);

            $hariTerlambat = now()->endOfDay()->diffInDays($tanggalPengembalian, false);

            if ($hariTerlambat < 0) {
                $notifikasi[] = [
                    'pesan' => "❗ Masa peminjaman buku <u>{$judulBuku}</u> telah habis. <strong>Segera kembalikan!</strong>",

                ];
            } elseif ($hariTerlambat == 1) {
                $notifikasi[] = [
                    'pesan' => "⏳ Waktu peminjaman buku <strong>{$judulBuku}</strong> tinggal 
                                <span class='font-bold text-red-600'>1 hari lagi</span>! Perpanjang?
                                <a href='" . route('peminjaman.index') . "' class='text-blue-500 hover:underline'>Ya</a>",

                ];
            } elseif ($hariTerlambat == 2) {
                $notifikasi[] = [
                    'pesan' => "⚠️ Peminjaman buku <strong>{$judulBuku}</strong> tinggal 2 hari lagi!",

                ];
            } else {
                $notifikasi[] = [
                    'pesan' => "📚 Peminjaman buku <strong>{$judulBuku}</strong> masih berlangsung selama 
                                <span class='font-bold'>{$hariTerlambat} hari</span>.",

                ];
            }
        }


        return view('peminjaman.tampil', [
            'peminjam' => $peminjam,
            'pinjamanUser' => $pinjamanUser,
            'masaPinjam' => $masaPinjam,
            'notifikasi' => $notifikasi,
        ]);
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

    public function tableRiwayatPeminjaman(Request $request)
    {
        if ($request->ajax()) {
            $iduser = auth()->id();
            $user = auth()->user();

            $peminjam = Peminjaman::with(['user:id,name', 'buku:id,judul,kode_buku'])
                ->select(['id', 'users_id', 'buku_id', 'tanggal_pinjam', 'tanggal_wajib_kembali', 'tanggal_pengembalian', 'denda', 'status', 'updated_at'])
                ->where('status', 'Dikembalikan') // Menampilkan hanya yang statusnya "Dikembalikan"
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
                        'Dikembalikan' => ['label' => 'Dikembalikan', 'ring' => 'ring-green-400', 'bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>'],
                    ];

                    $currentStatus = $statuses['Dikembalikan'];

                    return '
                    <span id="badge-' . $row->id . '" class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded-full ring-1 ' . $currentStatus['ring'] . ' ' . $currentStatus['bg'] . ' ' . $currentStatus['text'] . ' whitespace-nowrap">
                        ' . $currentStatus['icon'] . '
                        ' . $currentStatus['label'] . '
                    </span>';
                })
                ->rawColumns(['status'])
                ->make(true);
        }
    }




    public function tablePeminjaman(Request $request)
    {
        if ($request->ajax()) {
            $iduser = auth()->id();
            $user = auth()->user();

            $peminjam = Peminjaman::with(['user:id,name', 'buku:id,judul,kode_buku'])
                ->select(['id', 'users_id', 'buku_id', 'tanggal_pinjam', 'tanggal_wajib_kembali', 'tanggal_pengembalian', 'denda', 'status', 'updated_at'])
                ->where('status', '!=', 'Dikembalikan') // Mengecualikan yang statusnya "Dikembalikan"
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
                        'Menunggu Konfirmasi' => [
                            'label' => 'Menunggu Konfirmasi',
                            'ring' => 'ring-orange-400',
                            'bg' => 'bg-orange-100',
                            'text' => 'text-orange-700',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>'
                        ],
                        'proses' => [
                            'label' => 'Proses',
                            'ring' => 'ring-yellow-400',
                            'bg' => 'bg-yellow-100',
                            'text' => 'text-yellow-700',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>'
                        ],
                        'Menunggu Pengambilan' => [
                            'label' => 'Menunggu Pengambilan',
                            'ring' => 'ring-blue-400',
                            'bg' => 'bg-blue-100',
                            'text' => 'text-blue-700',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'
                        ],
                        'Dipinjam' => [
                            'label' => 'Dipinjam',
                            'ring' => 'ring-purple-400',
                            'bg' => 'bg-purple-100',
                            'text' => 'text-purple-700',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5V6a2 2 0 0 1 2-2h9"/><path d="M16 2v4"/><path d="M16 10v4"/><path d="M10 16h6a2 2 0 0 1 2 2v1.5"/><path d="M2 19.5h20"/></svg>'
                        ],
                    ];

                    $currentStatus = $statuses[$row->status] ?? $statuses['Menunggu Konfirmasi'];

                    return '
                    <span id="badge-' . $row->id . '" class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded-full ring-1 ' . $currentStatus['ring'] . ' ' . $currentStatus['bg'] . ' ' . $currentStatus['text'] . ' whitespace-nowrap">
                        ' . $currentStatus['icon'] . '
                        ' . $currentStatus['label'] . '
                    </span>';
                })
                ->addColumn('option', 'peminjaman.status_option')
                ->rawColumns(['status', 'option'])
                ->make(true);
        }
    }


    public function tablePeminjam(Request $request)
    {
        if ($request->ajax()) {
            $iduser = auth()->id();
            $user = auth()->user();

            $peminjam = Peminjaman::with(['user:id,name', 'buku:id,judul,kode_buku'])
                ->select(['id', 'users_id', 'buku_id', 'tanggal_pinjam', 'tanggal_wajib_kembali', 'tanggal_pengembalian', 'denda', 'status', 'updated_at'])
                ->where('status', '!=', 'Dikembalikan') // Mengecualikan yang statusnya "Dikembalikan"
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
                        'Menunggu Konfirmasi' => [
                            'label' => 'Menunggu Konfirmasi',
                            'ring' => 'ring-orange-400',
                            'bg' => 'bg-orange-100',
                            'text' => 'text-orange-700',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>'
                        ],
                        'proses' => [
                            'label' => 'Proses',
                            'ring' => 'ring-yellow-400',
                            'bg' => 'bg-yellow-100',
                            'text' => 'text-yellow-700',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>'
                        ],
                        'Menunggu Pengambilan' => [
                            'label' => 'Menunggu Pengambilan',
                            'ring' => 'ring-blue-400',
                            'bg' => 'bg-blue-100',
                            'text' => 'text-blue-700',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'
                        ],
                        'Dipinjam' => [
                            'label' => 'Dipinjam',
                            'ring' => 'ring-purple-400',
                            'bg' => 'bg-purple-100',
                            'text' => 'text-purple-700',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5V6a2 2 0 0 1 2-2h9"/><path d="M16 2v4"/><path d="M16 10v4"/><path d="M10 16h6a2 2 0 0 1 2 2v1.5"/><path d="M2 19.5h20"/></svg>'
                        ],
                    ];

                    $currentStatus = $statuses[$row->status] ?? $statuses['Menunggu Konfirmasi'];

                    // Cek apakah peminjaman sudah diperpanjang sebelumnya
                    $pernahDiperpanjang = $row->pernah_diperpanjang; // Kolom ini harus ditambahkan ke database

                    // Hitung sisa hari sebelum jatuh tempo
                    $today = \Carbon\Carbon::today();
                    $dueDate = \Carbon\Carbon::parse($row->tanggal_wajib_kembali)->endOfDay();
                    $daysLeft = $today->diffInDays($dueDate, false);



                    // Menentukan apakah tombol perpanjang akan ditampilkan atau tidak
                    $perpanjangButton = '';
                    if ($row->status === 'Dipinjam' && $daysLeft === 1 && $pernahDiperpanjang !== 1) {
                        $perpanjangButton = '
    <button id="perpanjangBtn_' . $row->id . '" onclick="bukaModalPerpanjangan(' . $row->id . ')" class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full cursor-pointer hover:bg-green-200 focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
        title="Perpanjang Peminjaman"> 
        Perpanjang
    </button>';
                    }



                    $batalkanButton = '';
                    if (in_array($row->status, ['Menunggu Konfirmasi', 'proses'])) {
                        $batalkanButton = '
                            <button class="p-1 text-red-700 bg-red-100 rounded-full hover:bg-red-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                onclick="batalkanPeminjaman(' . $row->id . ')" title="Batalkan Peminjaman">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>';
                    }


                    return '
                        <div class="flex items-center space-x-2">
                            <span id="badge-' . $row->id . '" class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded-full ring-1 ' . $currentStatus['ring'] . ' ' . $currentStatus['bg'] . ' ' . $currentStatus['text'] . ' whitespace-nowrap">
                                ' . $currentStatus['icon'] . '
                                ' . $currentStatus['label'] . '
                            </span>
                            ' . $perpanjangButton . '
                            ' . $batalkanButton . '
                        </div>
                    ';
                })


                ->rawColumns(['status', 'option'])
                ->make(true);
        }
    }


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
        // Ambil data peminjaman berdasarkan ID
        $pinjam = Peminjaman::findOrFail($id);

        // Hitung keterlambatan
        $tanggal_jatuh_tempo = $pinjam->tanggal_wajib_kembali;
        $hariTerlambat = Carbon::parse($tanggal_jatuh_tempo)->diffInDays(now(), false);

        // Tentukan jumlah keterlambatan, jika lebih dari 0 maka denda dikenakan
        $keterlambatan = $hariTerlambat > 0 ? $hariTerlambat : 0;

        // Hitung denda (misalnya Rp1000 per hari keterlambatan)
        $denda = $keterlambatan * 1000;

        try {
            DB::beginTransaction();

            // Update status peminjaman
            $pinjam->update([
                'status' => 'Dikembalikan',  // Ubah status menjadi 'Dikembalikan'
                'tanggal_pengembalian' => now(),  // Menambahkan tanggal pengembalian
                'keterlambatan' => $keterlambatan,  // Menambahkan jumlah keterlambatan
                'denda' => $denda  // Menyimpan nilai denda pada peminjaman
            ]);

            // Update stok buku yang dikembalikan
            $buku = $pinjam->buku;  // Ambil data buku terkait peminjaman
            $buku->increment('stock');  // Tambah stok buku karena buku dikembalikan

            // Validasi: Buat data denda hanya jika denda tidak null atau lebih dari 0
            if (!is_null($denda) && $denda > 0) {
                Denda::create([
                    'peminjaman_id' => $pinjam->id,  // Relasi ke peminjaman
                    'nominal' => $denda,             // Nominal denda yang dihitung
                    'tanggal_bayar' => null,         // Denda belum dibayar
                    'status' => 'Belum Bayar',       // Status denda "Belum Lunas"
                    'keterangan' => 'Terlambat mengembalikan buku', // Keterangan denda
                ]);
            }

            DB::commit();

            // Response sukses
            return response()->json([
                'message' => 'Buku telah dikembalikan',
                'keterlambatan' => $keterlambatan,
                'denda' => $denda
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            // Tangani error jika terjadi masalah dalam transaksi
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public function batalkanPeminjaman($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // Periksa apakah status peminjaman adalah 'MenungguKonfirmasi'
        if ($pinjam->status !== 'Menunggu Konfirmasi') {
            return response()->json(['message' => 'Peminjaman tidak dapat dibatalkan, status bukan Menunggu Konfirmasi.'], 400);
        }

        // Proses untuk menghapus riwayat peminjaman
        $pinjam->delete();  // Menghapus peminjaman yang dibatalkan

        // Mengembalikan stok buku yang dipinjam
        $buku = $pinjam->buku;
        $buku->increment('stock');

        return response()->json(['message' => 'Peminjaman dibatalkan dan riwayat dihapus']);
    }



    public function getBuku(Request $request)
    {
        $buku = Buku::where('stock', '>', 0)->get();
        if ($buku->isEmpty()) {
            return response()->json(['message' => 'Stok buku habis']);
        }
        return response()->json($buku);
    }


    public function laporanPeminjaman()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->orderBy('updated_at', 'desc')->get();

        return response()->json($peminjaman);
    }

    public function riwayatPembayaranDenda()
    {
        $denda = Denda::with(['peminjaman.user', 'peminjaman.buku']) // Menyertakan relasi dengan peminjaman, user, dan buku
            ->select('id', 'peminjaman_id', 'nominal', 'tanggal_bayar', 'status', 'keterangan')
            ->get();

        return DataTables::of($denda)
            ->addIndexColumn()
            ->editColumn('nominal', function ($row) {
                return number_format($row->nominal, 2);
            })
            ->editColumn('tanggal_bayar', function ($row) {
                return !empty($row->tanggal_bayar)
                    ? \Carbon\Carbon::parse($row->tanggal_bayar)->format('d-m-Y | H:i')
                    : '-';
            })
            ->addColumn('user', function ($row) {
                return $row->peminjaman->user->name ?? '-';
            })
            ->addColumn('buku', function ($row) {
                return $row->peminjaman->buku->judul ?? '-'; // Menampilkan nama buku
            })
            ->addColumn('status', function ($row) {
                $status = $row->status == 'Lunas'
                    ? '<span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-0.5 rounded-lg">
                          <i class="fas fa-check-circle"></i> Lunas
                       </span>'
                    : '<span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-0.5 rounded-lg">
                          <i class="fas fa-times-circle"></i> Belum Bayar
                       </span>';
                return $status;
            })
            ->addColumn('action', function ($row) {
                if ($row->status != 'Lunas') {
                    return '<button onclick="konfirmasiBayarDenda(' . $row->id . ')" 
                                 class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded-lg hover:bg-blue-200 transition-all ease-in-out duration-200">
                                <i class="fas fa-credit-card"></i> Bayar
                            </button>';
                }
                return '-';
            })
            ->rawColumns(['status', 'action']) // Pastikan kolom status dan action dirender sebagai HTML
            ->make(true);
    }



    public function PembayaranDenda()
    {
        return view('pengembalian.riwayat_denda');
    }

    public function bayarDenda($id)
    {
        try {
            $denda = Denda::findOrFail($id);

            $denda->update([
                'status' => 'Lunas',
                'tanggal_bayar' => now(), // Mengisi tanggal bayar dengan waktu saat ini
            ]);

            return response()->json(['message' => 'Denda berhasil dibayar']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function perpanjang(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Pastikan peminjaman masih aktif dan belum diperpanjang sebelumnya
        if ($peminjaman->status !== 'Dipinjam' || $peminjaman->pernah_diperpanjang) {
            return response()->json([
                'success' => false,
                'message' => 'Perpanjangan tidak dapat dilakukan.',
                'already_extended' => $peminjaman->pernah_diperpanjang // Tanda bahwa sudah diperpanjang
            ]);
        }

        // Tambahkan waktu sesuai pilihan pengguna
        $durasi = (int) $request->durasi;
        $peminjaman->tanggal_wajib_kembali = Carbon::parse($peminjaman->tanggal_wajib_kembali)->addDays($durasi);

        // Tandai bahwa peminjaman sudah pernah diperpanjang
        $peminjaman->pernah_diperpanjang = true;
        $peminjaman->save();

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman diperpanjang hingga ' . $peminjaman->tanggal_wajib_kembali->format('d-m-Y'),
            'already_extended' => false // Belum diperpanjang
        ]);
    }
}
