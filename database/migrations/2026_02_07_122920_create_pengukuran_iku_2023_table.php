<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengukuran_iku_2023', function (Blueprint $table) {
            $table->id(); // Menggunakan Auto Increment ID
            $table->string('nama_indikator', 100)->nullable();
            $table->string('target', 100)->nullable();
            $table->string('realisasi', 100)->nullable();
            $table->string('capaian', 100)->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('triwulan')->nullable(); // Menambahkan kolom triwulan (1, 2, 3, 4)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukuran_iku_2023');
    }
};
