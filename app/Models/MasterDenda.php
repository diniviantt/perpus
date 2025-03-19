<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDenda extends Model
{
    use HasFactory;
    protected $table = 'master_dendas';
    protected $fillable = ['buku_id', 'tarif_denda'];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }
}
