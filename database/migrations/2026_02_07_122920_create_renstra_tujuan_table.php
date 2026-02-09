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
        Schema::create('renstra_tujuan', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('tahun')->nullable();
            $table->string('unitkey', 5)->nullable();
            $table->string('visi', 1000)->nullable();
            $table->string('misi', 1000)->nullable();
            $table->string('kebijakan', 1000)->nullable();
            $table->string('tujuan', 1000)->nullable();
            $table->string('sasaran', 1000)->nullable();
            $table->string('indikator', 1000)->nullable();
            $table->string('satuan', 1000)->nullable();
            $table->string('target', 1000)->nullable();
            $table->string('kodeunit', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renstra_tujuan');
    }
};
