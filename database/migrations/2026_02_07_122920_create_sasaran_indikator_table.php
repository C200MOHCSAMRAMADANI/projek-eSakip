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
        Schema::create('sasaran_indikator', function (Blueprint $table) {
            $table->integer('id_sasaran_indikator', true);
            $table->integer('id_pengukuran_sasaran')->nullable();
            $table->binary('id_opd')->nullable();
            $table->string('nama_indikator', 200)->nullable();
            $table->string('target', 50)->nullable();
            $table->string('realisasi', 50)->nullable();
            $table->string('presentase', 50)->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('tahundata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sasaran_indikator');
    }
};
