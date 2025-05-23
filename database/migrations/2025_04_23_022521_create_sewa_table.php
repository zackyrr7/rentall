<?php
// database/migrations/xxxx_xx_xx_create_sewa_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSewaTable extends Migration
{
    public function up()
    {
        Schema::create('sewa', function (Blueprint $table) {
            $table->id('id_sewa'); // primary key
            $table->unsignedBigInteger('id_mobil');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('status');
            $table->string('penyewa');
           

            // Foreign keys
            $table->foreign('id_mobil')->references('id_mobil')->on('mobil')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sewa');
    }
}
