<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //tabel komponen_gaji
    public function up(): void
    {
        Schema::create('komponen_gaji', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nama_komponen', 100)->nullable();
            $table->enum('tipe', ['tunjangan', 'potongan'])->nullable();
            $table->tinyInteger('apakah_tetap')->nullalble();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_gaji');
    }
};
