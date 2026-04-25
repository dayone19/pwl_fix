<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel absensi
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nip', 20)->nullable(); //FK
            $table->date('tanggal')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Sakit', 'Alpa'])->nullable();
            $table->integer('Menit_terlambat')->default(0);

            // RELASI
            $table->foreign('nip')->references('nip')->on('profil_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
