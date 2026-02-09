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
        Schema::create('file_evaluasi', function (Blueprint $table) {
            $table->integer('id_file_evaluasi', true);
            $table->string('id_opd', 60)->nullable();
            $table->float('nilai')->nullable();
            $table->string('predikat')->nullable();
            $table->string('judul', 100);
            $table->string('lhe_nama_file', 200);
            $table->string('judul_tindak_lanjut', 150)->nullable();
            $table->string('file_tindak_lanjut', 200)->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('status')->nullable();
            $table->date('tgl_posting');
            $table->integer('verifikasi')->nullable()->default(0);
            $table->date('tgl_verifikasi')->nullable();
            $table->integer('hits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_evaluasi');
    }
};
