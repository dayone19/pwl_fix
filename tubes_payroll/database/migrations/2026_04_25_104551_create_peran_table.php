<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel peran
    public function up(): void
    {
        Schema::create('peran', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nama_peran')->nullable();
            $table->text('deskripsi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peran');
    }
};
