<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tabel divisi
    public function up(): void
    {
        Schema::create('divisi', function (Blueprint $table) {
            $table->increments('id'); //PK
            $table->string('nama_divisi', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisi');
    }
};
