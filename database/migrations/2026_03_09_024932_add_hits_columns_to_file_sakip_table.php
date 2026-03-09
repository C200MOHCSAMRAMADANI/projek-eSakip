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
        Schema::table('file_sakip', function (Blueprint $table) {
            // Menambahkan kolom hits spesifik di file_sakip
            if (!Schema::hasColumn('file_sakip', 'hits_renstra')) {
                $table->integer('hits_renstra')->default(0);
                $table->integer('hits_renja')->default(0);
                $table->integer('hits_rencana_aksi')->default(0);
                $table->integer('hits_sk_iku')->default(0);
                $table->integer('hits_iku')->default(0);
                $table->integer('hits_perjanjian_kinerja')->default(0);
                $table->integer('hits_cascading')->default(0);
                $table->integer('hits_kak')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_sakip', function (Blueprint $table) {
            $table->dropColumn([
                'hits_renstra',
                'hits_renja',
                'hits_rencana_aksi',
                'hits_sk_iku',
                'hits_iku',
                'hits_perjanjian_kinerja',
                'hits_cascading',
                'hits_kak'
            ]);
        });
    }
};