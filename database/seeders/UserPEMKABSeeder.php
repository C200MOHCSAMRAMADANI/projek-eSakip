<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserPEMKABSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists
        $existingUser = DB::table('user')->where('username', 'client_opd')->first();
        
        if (!$existingUser) {
            // Insert user PEMKAB
            DB::table('user')->insert([
                'username' => 'client_opd',
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
            
            echo "User PEMKAB berhasil dibuat!\n";
            echo "Username: client_opd\n";
            echo "Password: password123\n";
        } else {
            echo "User client_opd sudah ada!\n";
        }
    }
}
