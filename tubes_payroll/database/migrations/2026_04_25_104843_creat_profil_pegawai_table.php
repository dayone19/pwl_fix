<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel profil_pegawai
    public function up(): void
    {
        Schema::create('profil_pegawai', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nip', 20)->nullable();
            $table->string('nama_lengkap', 150)->nullable();
            $table->string('nik', 10)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('tempat_tanggal_lahir', 100)->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->tinyInteger('apakah_digaji')->default(1)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->string('jabatan', 50)->nullable();
            $table->string('departemen', 100)->nullable();
            $table->string('pendidikan', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_pegawai');
    }
};
