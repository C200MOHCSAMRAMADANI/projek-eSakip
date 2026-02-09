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
        Schema::create('iku', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tahun')->nullable()->default(2018);
            $table->integer('unitkey')->nullable();
            $table->integer('no')->nullable()->default(1);
            $table->string('sasaran_strategis', 1000)->nullable();
            $table->string('indikator_kinerja', 1000)->nullable();
            $table->integer('img_form')->nullable()->default(0);
            $table->string('formulasi', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iku');
    }
};
