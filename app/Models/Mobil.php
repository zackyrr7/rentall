<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil'; // nama tabel di database

    protected $primaryKey = 'id_mobil'; // primary key

    public $timestamps = false; // kalau tidak pakai created_at dan updated_at

    protected $fillable = [
        'plat_nomor',
        'merk',
        'tipe',
        'tahun',
        'harga_sewa',
        'status',
    ];

    /**
     * Relasi ke tabel sewa (satu mobil bisa punya banyak penyewaan)
     */
    public function sewas()
    {
        return $this->hasMany(Sewa::class, 'id_mobil', 'id_mobil');
    }
}
