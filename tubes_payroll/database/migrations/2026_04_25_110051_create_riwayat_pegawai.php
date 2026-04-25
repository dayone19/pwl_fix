<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel riwayat_pegawai
    public function up(): void
    {
        Schema::create('riwayat_pegawai', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->integer('pegawai_id')->nullable(); //FK
            $table->integer('departemen_id')->nullable(); //FK
            $table->integer('jabatan_id')->nullable(); //FK
            $table->enum('tipe_pegawai', ['Tetap', 'Kontrak', 'Magang', 'PKL'])->nullable();
            $table->decimal('gaji_pokok', 15, 2)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->enum('status_tugas', ['Aktif', 'Nonaktif'])->nullable();

            // relasi
            $table->foreign('pegawai_id')->references('id')->on('profil_pegawai');
            $table->foreign('departemen_id')->references('id')->on('divisi');
            $table->foreign('jabatan_id')->references('id')->on('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pegawai');
    }
};
