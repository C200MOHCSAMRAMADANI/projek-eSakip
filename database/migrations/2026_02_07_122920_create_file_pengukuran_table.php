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
        Schema::create('file_pengukuran', function (Blueprint $table) {
            $table->id('id_file_pengukuran'); // Menggunakan BigInteger Auto Increment
            $table->string('id_opd', 60)->nullable();
            $table->string('judul', 100);
            $table->string('pengukuran_nama_file', 100);
            $table->string('analisis_nama_file')->nullable();
            $table->date('tgl_posting');
            $table->integer('tahun')->nullable();
            $table->integer('hits');
            $table->tinyInteger('verifikasi')->nullable()->default(1); // Lebih hemat memori untuk status
            $table->dateTime('tgl_verifikasi')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps(); // Helper standar Laravel untuk created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_pengukuran');
    }
};
