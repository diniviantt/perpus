<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    use HasFactory;

    protected $table = 'koleksi_buku';
    protected $fillable = ['users_id', 'buku_id'];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    // Model Koleksi
    public static function isInCollection($bukuId, $userId)
    {
        return self::where('buku_id', $bukuId)->where('users_id', $userId)->exists();
    }
}
