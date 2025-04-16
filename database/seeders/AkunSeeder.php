<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'email' => 'admin1@example.com',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
                'tingkat' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'admin2@example.com',
                'password' => Hash::make('adminpass'),
                'status' => 'aktif',
                'tingkat' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user1@example.com',
                'password' => Hash::make('user123'),
                'status' => 'aktif',
                'tingkat' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user2@example.com',
                'password' => Hash::make('user234'),
                'status' => 'nonaktif',
                'tingkat' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user3@example.com',
                'password' => Hash::make('user345'),
                'status' => 'aktif',
                'tingkat' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user4@example.com',
                'password' => Hash::make('user456'),
                'status' => 'aktif',
                'tingkat' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user5@example.com',
                'password' => Hash::make('user567'),
                'status' => 'nonaktif',
                'tingkat' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user6@example.com',
                'password' => Hash::make('user678'),
                'status' => 'aktif',
                'tingkat' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user7@example.com',
                'password' => Hash::make('user789'),
                'status' => 'aktif',
                'tingkat' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user8@example.com',
                'password' => Hash::make('user890'),
                'status' => 'aktif',
                'tingkat' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('akun')->insert($data);
    }
}
