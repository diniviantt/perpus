<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'data',
        'nik',
        'ktp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'data' => 'array', // Memastikan data JSON dikonversi ke array
    ];

    /**
     * Accessor untuk avatar, memastikan URL yang benar.
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($avatar) => $avatar ? asset('/storage/' . $avatar) : null,
        );
    }

    /**
     * Mengambil path mentah dari avatar tanpa URL lengkap.
     */
    public function rawAvatar()
    {
        return $this->avatar ? 'avatar/' . basename(parse_url($this->avatar, PHP_URL_PATH)) : null;
    }


    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }
}
