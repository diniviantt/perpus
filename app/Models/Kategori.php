<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = "kategori";
    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    public function kategori_buku()
    {
        return $this->belongsToMany(Buku::class, 'kategori_buku', 'kategori_id', 'buku_id');
    }
}
