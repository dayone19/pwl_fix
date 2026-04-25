<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel jabatan
    public function up(): void
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nama_jabatan', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
