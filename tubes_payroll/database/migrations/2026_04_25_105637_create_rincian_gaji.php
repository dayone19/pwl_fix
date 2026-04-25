<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel rincian_gaji
    public function up(): void
    {
        Schema::create('rincian_gaji', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->integer('penggajian_id')->nullable(); //FK
            $table->integer('komponen_id')->nullable(); //FK
            $table->decimal('jumlah', 15, 2);

            // relasi
            $table->foreign('penggajian_id')->references('id')->on('penggajian');
            $table->foreign('komponen_id')->references('id')->on('komponen_gaji');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_gaji');
    }
};
