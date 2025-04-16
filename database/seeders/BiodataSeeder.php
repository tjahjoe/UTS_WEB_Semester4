<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BiodataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_akun' => 1,
                'nama' => 'Ahmad Fauzi',
                'umur' => 28,
                'alamat' => 'Jl. Merdeka No.10, Jakarta',
                'gender' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 2,
                'nama' => 'Siti Nurhaliza',
                'umur' => 32,
                'alamat' => 'Jl. Diponegoro No.5, Bandung',
                'gender' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 3,
                'nama' => 'Budi Santoso',
                'umur' => 24,
                'alamat' => 'Jl. Sudirman No.3, Surabaya',
                'gender' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 4,
                'nama' => 'Dewi Anggraini',
                'umur' => 27,
                'alamat' => 'Jl. Cendana No.8, Yogyakarta',
                'gender' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 5,
                'nama' => 'Rizky Hidayat',
                'umur' => 30,
                'alamat' => 'Jl. Siliwangi No.20, Bogor',
                'gender' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 6,
                'nama' => 'Lestari Wulandari',
                'umur' => 26,
                'alamat' => 'Jl. Mawar No.15, Semarang',
                'gender' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 7,
                'nama' => 'Andi Wijaya',
                'umur' => 29,
                'alamat' => 'Jl. Melati No.3, Medan',
                'gender' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 8,
                'nama' => 'Citra Ayu',
                'umur' => 25,
                'alamat' => 'Jl. Kenanga No.9, Malang',
                'gender' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 9,
                'nama' => 'Fajar Nugroho',
                'umur' => 31,
                'alamat' => 'Jl. Anggrek No.14, Makassar',
                'gender' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 10,
                'nama' => 'Putri Kartika',
                'umur' => 22,
                'alamat' => 'Jl. Teratai No.7, Padang',
                'gender' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('biodata')->insert($data);
    }
}
