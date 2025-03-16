<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pinjam';

    protected $fillable = [
        'users_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_wajib_kembali',
        'tanggal_pengembalian',
        'keterlambatan',
        'denda',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }
    public function denda()
    {
        return $this->hasMany(Denda::class, 'peminjaman_id', 'id');
    }
}
