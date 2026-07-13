<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Pastikan model User dipanggil

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat akun Admin
        User::create([
            'name' => 'Admin HRD',
            'nik_sap' => '1001001', // Contoh NIK SAP Admin
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Membuat akun User (Peserta)
        User::create([
            'name' => 'Peserta Ujian',
            'nik_sap' => '2002002', // Contoh NIK SAP Peserta
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}
