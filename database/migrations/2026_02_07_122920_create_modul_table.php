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
        Schema::create('modul', function (Blueprint $table) {
            $table->integer('id_modul', true);
            $table->string('nama_modul', 50);
            $table->string('link', 100);
            $table->text('static_content');
            $table->string('gambar', 100);
            $table->enum('publish', ['Y', 'N'])->default('Y');
            $table->enum('status', ['user', 'admin']);
            $table->enum('aktif', ['Y', 'N'])->default('Y');
            $table->integer('urutan');
            $table->string('link_seo', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul');
    }
};
