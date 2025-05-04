<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dsewa extends Model
{
    use HasFactory;

    protected $table = 'dsewa'; // nama tabel di database

  

    public $timestamps = false; // kalau tidak pakai created_at dan updated_at

    protected $fillable = [
        'id_sewa',
        'diskon',
        'harga',
        'total',
        'tgl_ambil',
        'tgl_',
        
    ];

    /**
     * Relasi ke tabel sewa 
     */
    public function sewa()
    {
        return $this->belongsTo(Sewa::class, 'id_sewa', 'id_sewa');
    }
}
