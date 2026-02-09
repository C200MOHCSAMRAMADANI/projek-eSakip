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
        Schema::create('submenu', function (Blueprint $table) {
            $table->integer('id_sub', true);
            $table->string('nama_sub', 50)->nullable();
            $table->string('link_sub', 100)->nullable();
            $table->integer('id_main');
            $table->integer('id_submain');
            $table->enum('aktif', ['Y', 'N'])->default('Y');
            $table->enum('adminsubmenu', ['Y', 'N']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submenu');
    }
};
