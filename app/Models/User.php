<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Nama tabel default Laravel

    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'role',
        'no_hp',
        'tanggal_daftar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke tabel sewa (user bisa menyewa beberapa mobil)
     */
    public function sewas()
    {
        return $this->hasMany(Sewa::class, 'id_user', 'id');
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah anggota biasa
     */
    public function isAnggota()
    {
        return $this->role === 'anggota';
    }
}
