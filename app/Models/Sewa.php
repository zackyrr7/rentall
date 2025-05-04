<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $table = 'sewa'; // Nama tabel di database
    protected $primaryKey = 'id_sewa'; // Primary key

    public $timestamps = false; // Jika tidak pakai created_at dan updated_at

    protected $fillable = [
        'id_sewa',
        'id_mobil',
        'id_user',
        'status',
        'penyewa',
    ];

    /**
     * Relasi ke tabel mobil (satu penyewaan berkaitan dengan satu mobil)
     */
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'id_mobil', 'id_mobil');
    }

    /**
     * Relasi ke tabel user (anggota yang menyewa mobil)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
