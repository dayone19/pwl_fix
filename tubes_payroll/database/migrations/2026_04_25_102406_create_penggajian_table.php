<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel penggajian
    public function up(): void
    {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nip', 20)->nullable(); //FK
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();
            $table->decimal('total_tunjangan', 15, 2)->nullable();
            $table->decimal('total_potongan', 15, 2)->nullable();
            $table->decimal('gaji_bersih', 15, 2)->nullable();
            $table->enum('status_bayar', ['Draft', 'Terbit', 'Dibayar'])->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();

            // relasi
            $table->foreign('nip')->references('nip')->on('profil_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};
