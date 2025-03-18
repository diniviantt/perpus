<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\CetakLaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexDashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatPinjamController;
use App\Http\Controllers\UlasanController;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('home')->group(function () {
    Route::get('/', [IndexDashboardController::class, 'HomeViewBook'])->name('home');
});


Route::prefix('/dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::get('/usermanage-table', [DashboardController::class, 'TableUserManage'])->name('dashboard.table');
        Route::delete('/delete-user/{id}', [DashboardController::class, 'destroy'])->name('delete-user');
        Route::patch('/rolesupdate/{id}', [DashboardController::class, 'update'])->name('roles.update');
        Route::get('/get-user/{id}', [DashboardController::class, 'getUser'])->name('dashboard.get-user');
        Route::post('add-user', [DashboardController::class, 'register'])->name('add-user');
        Route::get('get-roles', [DashboardController::class, 'getRoles'])->name('get-roles');
        Route::get('tempt-export', [DashboardController::class, 'export'])->name('tempt-export');
        Route::post('import-user', [DashboardController::class, 'import'])->name('import-user');
    });

    Route::middleware(['role:peminjam'])->group(function () {
        Route::get('/user', [DashboardController::class, 'user'])->name('dashboard.user');
    });

    Route::resource('buku', BukuController::class)->names([
        'index' => 'buku.index',
        'create' => 'buku.create',
        'store' => 'buku.store',
        'show' => 'buku.show',
        'edit' => 'buku.edit',
        'update' => 'buku.update',
        'destroy' => 'buku.destroy',
    ]);

    Route::middleware('auth')->group(function () {
        Route::get('buku-export', [BukuController::class, 'export'])->name('buku-export');
        Route::post('import-buku', [BukuController::class, 'import'])->name('import-buku');
        Route::get('list-buku', [BukuController::class, 'listBuku'])->name('list-buku');
        Route::get('table-buku', [BukuController::class, 'tableBuku'])->name('table-buku');
        Route::patch('/buku/{id}/ubah-status', [BukuController::class, 'toggleStatus'])->name('buku-toggleStatus');

        Route::get('koleksi-buku', [BukuController::class, 'koleksiBuku'])->name('koleksi-buku');
        Route::delete('koleksi-buku/{id}', [BukuController::class, 'hapusKoleksi'])->name('hapus-koleksi');

        Route::post('koleksi-buku', [BukuController::class, 'tambahKoleksi'])->name('tambah-koleksi');
    });

    Route::resource('kategori', KategoriController::class)->names([
        'index' => 'kategori.index',
        'create' => 'kategori.create',
        'store' => 'kategori.store',
        'show' => 'kategori.show',
        'edit' => 'kategori.edit',
        'update' => 'kategori.update',
        'destroy' => 'kategori.destroy',
    ]);
    Route::get('kategori-table', [KategoriController::class, 'TabelKategori'])->name('tabel-kategori');

    Route::resource('anggota', AnggotaController::class)->names([
        'index' => 'anggota.index',
        'create' => 'anggota.create',
        'store' => 'anggota.store',
        'show' => 'anggota.show',
        'edit' => 'anggota.edit',
        'update' => 'anggota.update',
        'destroy' => 'anggota.destroy',
    ]);
    Route::get('peminjam-table', [AnggotaController::class, 'TabelPeminjam'])->name('tabel-peminjam');
    Route::get('petugas-table', [AnggotaController::class, 'TabelPetugas'])->name('tabel-petugas');
    Route::get('admin-table', [AnggotaController::class, 'TabelAdmin'])->name('tabel-admin');

    Route::resource('peminjaman', RiwayatPinjamController::class)->names([
        'index' => 'peminjaman.index',
        'create' => 'peminjaman.create',
        'store' => 'peminjaman.store',
        'show' => 'peminjaman.show',
        'edit' => 'peminjaman.edit',
        'update' => 'peminjaman.update',
        'destroy' => 'peminjaman.destroy',
    ]);


    Route::middleware(['auth'])->group(function () {
        Route::get('/table-peminjaman', [RiwayatPinjamController::class, 'tablePeminjaman'])->name('table-peminjaman');
        Route::get('/table-peminjam', [RiwayatPinjamController::class, 'tablePeminjam'])->name('table-peminjam');
        Route::get('/table-riwayat', [RiwayatPinjamController::class, 'tableRiwayatPeminjaman'])->name('table-riwayat');
        Route::get('/laporan-peminjaman', [RiwayatPinjamController::class, 'laporanPeminjaman'])->name('laporan.peminjaman');
        Route::get('/cek-stok/{id}', [BukuController::class, 'cekStok']);
        Route::post('/pinjam-buku/{id}', [BukuController::class, 'pinjamBuku']);

        // Admin mengonfirmasi peminjaman (status: "Menunggu Pengambilan")
        Route::put('/pinjam/{id}/konfirmasi', [RiwayatPinjamController::class, 'konfirmasiPinjam'])->name('pinjam.konfirmasi');

        // User mengambil buku (status: "Dipinjam")
        Route::put('/pinjam/{id}/ambil', [RiwayatPinjamController::class, 'ambilBuku'])->name('pinjam.ambil');

        // User mengembalikan buku (status: "Dikembalikan", hitung keterlambatan & denda)
        Route::put('/pinjam/{id}/kembalikan', [RiwayatPinjamController::class, 'kembalikanBuku'])->name('pinjam.kembalikan');
        Route::delete('/pinjam/{id}/batalkan', [RiwayatPinjamController::class, 'batalkanPeminjaman'])->name('pinjam.batalkan');
        Route::post('/pinjam/perpanjang/{id}', [RiwayatPinjamController::class, 'perpanjang'])->name('pinjam.perpanjang');

        Route::get('/get-buku-pinjam', [RiwayatPinjamController::class, 'getBuku'])->name('pinjam.getbuku');

        Route::get('/halaman-denda', [RiwayatPinjamController::class, 'PembayaranDenda'])->name('halaman-riwayat');
        Route::get('/riwayat-denda', [RiwayatPinjamController::class, 'riwayatPembayaranDenda'])->name('peminjaman-riwayat');
        Route::post('/peminjaman-bayar-denda/{id}', [RiwayatPinjamController::class, 'bayarDenda'])->name('peminjaman-bayar-denda');
        Route::get('/data-peminjam', [DashboardController::class, 'DataPeminjam'])->name('data-peminjam');
        Route::post('/reviews', [UlasanController::class, 'Ulasan'])->name('ulasan-buku');
        Route::put('/ulasan/{id}/edit', [UlasanController::class, 'update'])->name('ulasan-edit');
        Route::delete('/ulasan-hapus/{id}', [UlasanController::class, 'destroy'])->name('ulasan-hapus');
    });


    Route::get('/cetaklaporan', CetakLaporanController::class);

    Route::middleware(['auth'])->group(function () {
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');

        Route::post('/pengembalian', [PengembalianController::class, 'pengembalian'])->name('pengembalian.create');
        Route::get('/get-buku/{id}', [PengembalianController::class, 'getBuku'])->name('pengembalian.getbuku');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
