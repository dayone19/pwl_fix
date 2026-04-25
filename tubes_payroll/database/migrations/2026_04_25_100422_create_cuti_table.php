<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel cuti
    public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nip', 20); //FK
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('alasan')->nullable();
            $table->enum('status_persetujuan', ['Menunggu', 'Disetujui', 'Ditolak'])->nullable();
            $table->integer('disetuji_oleh_id')->nullable();

            //relasi
            $table->foreign('nip')->references('nip')->on('profil_pegawai');
            $table->foreign('disetuji_oleh_id')->references('disetuji_oleh_id')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
