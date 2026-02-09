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
        Schema::create('pengukuran_sasaran', function (Blueprint $table) {
            $table->integer('id_pengukuran_sasaran')->primary();
            $table->string('id_opd', 5);
            $table->string('sasaran')->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('tahundata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukuran_sasaran');
    }
};
