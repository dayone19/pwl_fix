<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel statistik_tabel
    public function up(): void
    {
        Schema::create('statistik_bulanan', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->integer('bulan')->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('total_pegawai')->nullable();
            $table->decimal('total_pengeluaran_gaji', 18,2)->nullable();
            $table->integer('jumlah_pegawai_baru')->nullable();
            $table->integer('jumlah_pegawai_keluar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistik_bulanan');
    }
};
