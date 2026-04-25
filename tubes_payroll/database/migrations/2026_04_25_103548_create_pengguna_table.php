<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel pengguna
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nama', 250)->nullable();
            $table->string('nip', 20)->nullable(); //FK
            $table->string('role', 20)->nullable(); //FK
            $table->string('email', 100)->nullable(); //FK
            $table->string('foto', 255)->nullable();
            $table->tinyInteger('apakah_aktif')->default(1);

            // relasi
            $table->foreign('nip')->references('nip')->on('profil_pegawai');
            $table->foreign('role')->references('role')->on('peran');
            $table->foreign('email')->references('email')->on('profil_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
