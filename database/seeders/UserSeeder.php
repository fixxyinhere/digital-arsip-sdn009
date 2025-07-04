<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $operator = User::create([
            'name' => 'Admin Operator',
            'email' => 'operator@sdn009.sch.id',
            'employee_id' => 'OP001',
            'phone' => '081234567890',
            'position' => 'operator',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $operator->assignRole('operator');

        $kepsek = User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@sdn009.sch.id',
            'employee_id' => 'KS001',
            'phone' => '081234567891',
            'position' => 'kepala_sekolah',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $kepsek->assignRole('kepala_sekolah');

        $guru = User::create([
            'name' => 'Guru Contoh',
            'email' => 'guru@sdn009.sch.id',
            'employee_id' => 'GR001',
            'phone' => '081234567892',
            'position' => 'guru',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $guru->assignRole('guru');
    }
}
