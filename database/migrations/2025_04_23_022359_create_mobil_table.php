<?php
// database/migrations/xxxx_xx_xx_create_mobil_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilTable extends Migration
{
    public function up()
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id('id_mobil'); // primary key
            $table->string('plat_nomor')->unique();
            $table->string('merk');
            $table->string('tipe');
            $table->integer('tahun');
            $table->decimal('harga_sewa', 10, 2);
            $table->enum('status', ['Tersedia', 'Disewa', 'Servis'])->default('Tersedia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobil');
    }
}
