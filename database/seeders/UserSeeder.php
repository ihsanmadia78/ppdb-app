<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@ppdb.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@ppdb.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );

        // Create keuangan user
        User::updateOrCreate(
            ['email' => 'keuangan@ppdb.com'],
            [
                'name' => 'Petugas Keuangan',
                'email' => 'keuangan@ppdb.com',
                'password' => Hash::make('password'),
                'role' => 'keuangan'
            ]
        );

        // Create verifikator user
        User::updateOrCreate(
            ['email' => 'verifikator@ppdb.com'],
            [
                'name' => 'Petugas Verifikator',
                'email' => 'verifikator@ppdb.com',
                'password' => Hash::make('password'),
                'role' => 'verifikator'
            ]
        );

        // Create eksekutif user
        User::updateOrCreate(
            ['email' => 'eksekutif@ppdb.com'],
            [
                'name' => 'Eksekutif',
                'email' => 'eksekutif@ppdb.com',
                'password' => Hash::make('password'),
                'role' => 'eksekutif'
            ]
        );
    }
}