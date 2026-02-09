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
        Schema::create('file', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('id_opd', 60)->nullable();
            $table->text('renstra')->nullable();
            $table->text('lkjip')->nullable();
            $table->text('renja')->nullable();
            $table->text('rencana_aksi')->nullable();
            $table->text('sk_iku')->nullable();
            $table->text('iku')->nullable();
            $table->date('create_at')->nullable();
            $table->date('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file');
    }
};
