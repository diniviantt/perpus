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
        Route::post('add-user', [RegisteredUserController::class, 'register'])->name('add-user');
    });

    Route::middleware(['role:user'])->group(function () {
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
    Route::resource('kategori', KategoriController::class)->names([
        'index' => 'kategori.index',
        'create' => 'kategori.create',
        'store' => 'kategori.store',
        'show' => 'kategori.show',
        'edit' => 'kategori.edit',
        'update' => 'kategori.update',
        'destroy' => 'kategori.destroy',
    ]);

    Route::resource('anggota', AnggotaController::class)->names([
        'index' => 'anggota.index',
        'create' => 'anggota.create',
        'store' => 'anggota.store',
        'show' => 'anggota.show',
        'edit' => 'anggota.edit',
        'update' => 'anggota.update',
        'destroy' => 'anggota.destroy',
    ]);

    Route::resource('peminjaman', RiwayatPinjamController::class)->names([
        'index' => 'peminjaman.index',
        'create' => 'peminjaman.create',
        'store' => 'peminjaman.store',
        'show' => 'peminjaman.show',
        'edit' => 'peminjaman.edit',
        'update' => 'peminjaman.update',
        'destroy' => 'peminjaman.destroy',
    ]);

    Route::get('/cetaklaporan', CetakLaporanController::class);

    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');

    Route::post('/pengembalian', [PengembalianController::class, 'pengembalian'])->name('pengembalian.create');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
