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
        Schema::create('mainmenu', function (Blueprint $table) {
            $table->integer('id_main', true);
            $table->string('nama_menu', 50)->nullable();
            $table->string('link', 100)->nullable();
            $table->enum('aktif', ['Y', 'N'])->default('Y');
            $table->enum('adminmenu', ['Y', 'N']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mainmenu');
    }
};
