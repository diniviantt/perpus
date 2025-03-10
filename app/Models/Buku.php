<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = "buku";
    protected $fillable = [
        'judul',
        'kode_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'deskripsi',
        'gambar',
        'stock',
    ];

    public function kategori_buku()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_buku', 'buku_id', 'kategori_id');
    }
}
