<?php
// database/migrations/xxxx_xx_xx_create_sewa_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsewaTable extends Migration
{
    public function up()
    {
        Schema::create('dsewa', function (Blueprint $table) {
            $table->id('id_sewa'); 
            $table->decimal('diskon', 10, 2);
            $table->decimal('harga', 10, 2);
            $table->decimal('total', 10, 2);
         $table->date('tgl_ambil');
            $table->date('tgl_pulang');
        
           

            // Foreign keys
            $table->foreign('id_sewa')->references('id_sewa')->on('sewa')->onDelete('cascade');
          
        });
    }

    public function down()
    {
        Schema::dropIfExists('sewa');
    }
}
