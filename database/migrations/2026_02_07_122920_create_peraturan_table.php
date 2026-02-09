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
        Schema::create('peraturan', function (Blueprint $table) {
            $table->integer('id_peraturan', true);
            $table->string('id_opd', 60)->nullable();
            $table->string('judul', 100);
            $table->string('file_name', 100);
            $table->date('tgl_posting');
            $table->integer('tahun')->nullable();
            $table->integer('hits');
            $table->integer('verifikasi')->nullable()->default(0);
            $table->integer('status')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peraturan');
    }
};
