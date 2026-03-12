<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Check and create user OPD (client_baru)
        $existingOPD = DB::table('user')->where('username', 'client_baru')->first();
        
        if (!$existingOPD) {
            DB::table('user')->insert([
                'username' => 'client_baru',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Admin OPD',
                'level' => 'client',
                'id_opd' => '01_', // ID khusus untuk OPD
                'kd_unit_kerja' => '01',
                'nama_satker' => 'PERANGKAT DAERAH',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "User OPD berhasil dibuat! (client_baru / password123)\n";
        } else {
            echo "User client_baru sudah ada!\n";
        }

        // 2. Check and create user PEMKAB (client_pemkab)
        $existingPEMKAB = DB::table('user')->where('username', 'client_pemkab')->first();
        
        if (!$existingPEMKAB) {
            DB::table('user')->insert([
                'username' => 'client_pemkab',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Admin PEMKAB',
                'level' => 'client',
                'id_opd' => '00_', // ID khusus untuk PEMKAB
                'kd_unit_kerja' => '00',
                'nama_satker' => 'PEMERINTAH KABUPATEN',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "User PEMKAB berhasil dibuat! (client_pemkab / password123)\n";
        } else {
            echo "User client_pemkab sudah ada!\n";
        }
    }
}
