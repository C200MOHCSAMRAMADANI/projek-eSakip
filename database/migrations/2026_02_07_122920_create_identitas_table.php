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
        Schema::create('identitas', function (Blueprint $table) {
            $table->integer('id_identitas', true);
            $table->string('nama_website', 100);
            $table->string('alamat_website', 100);
            $table->string('meta_deskripsi', 250);
            $table->string('meta_keyword', 250);
            $table->string('favicon', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas');
    }
};
