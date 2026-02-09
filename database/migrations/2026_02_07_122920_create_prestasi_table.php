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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->integer('id_prestasi', true);
            $table->integer('id_kategori');
            $table->string('id_opd', 30);
            $table->string('nama', 250);
            $table->string('nama_seo', 250);
            $table->enum('headline', ['Y', 'N'])->default('Y');
            $table->enum('publish', ['N', 'Y'])->nullable()->default('Y');
            $table->text('deskripsi');
            $table->string('hari', 20);
            $table->date('tanggal_penghargaan');
            $table->time('jam');
            $table->string('gambar', 100);
            $table->integer('dibaca')->default(1);
            $table->string('tag', 100);
            $table->string('file_name')->nullable();
            $table->string('pemberi_penghargaan')->nullable();
            $table->dateTime('tanggal_posting')->nullable();
            $table->integer('verifikasi')->nullable()->default(0);
            $table->integer('status')->nullable();
            $table->string('tahun', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
