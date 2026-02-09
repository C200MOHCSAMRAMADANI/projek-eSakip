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
        Schema::create('gallery', function (Blueprint $table) {
            $table->integer('id_gallery', true);
            $table->integer('id_album');
            $table->string('jdl_gallery', 100);
            $table->string('gallery_seo', 100);
            $table->text('keterangan');
            $table->string('gbr_gallery', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};
