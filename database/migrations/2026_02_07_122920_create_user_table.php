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
        Schema::create('user', function (Blueprint $table) {
            $table->integer('id', true)->index('idxuser');
            $table->string('username', 50)->nullable();
            $table->string('password', 225)->nullable();
            $table->string('nama_lengkap', 100)->nullable();
            $table->enum('level', ['admin', 'moderator', 'client'])->nullable();
            $table->string('id_opd', 50)->nullable();
            $table->string('kd_unit_kerja', 20)->nullable();
            $table->string('nama_satker', 100)->nullable();
            $table->enum('status', ['aktif', 'tidak aktif'])->nullable()->default('aktif');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
