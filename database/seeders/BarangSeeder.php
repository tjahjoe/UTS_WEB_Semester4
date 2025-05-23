<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Mawar Merah',
                'harga' => 15000,
                'stok' => 50,
                'deskripsi' => 'Melambangkan cinta dan kasih sayang.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Lili Putih',
                'harga' => 20000,
                'stok' => 30,
                'deskripsi' => 'Simbol kemurnian dan keanggunan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Tulip Kuning',
                'harga' => 18000,
                'stok' => 40,
                'deskripsi' => 'Bunga musim semi dengan warna ceria.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Anggrek Ungu',
                'harga' => 25000,
                'stok' => 25,
                'deskripsi' => 'Melambangkan keindahan dan kemewahan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kamboja Merah',
                'harga' => 12000,
                'stok' => 60,
                'deskripsi' => 'Sering ditemukan di daerah tropis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Melati Putih',
                'harga' => 10000,
                'stok' => 70,
                'deskripsi' => 'Simbol kesucian dan ketulusan hati.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Daisy Pink',
                'harga' => 13000,
                'stok' => 35,
                'deskripsi' => 'Cocok untuk hadiah ulang tahun.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Lavender',
                'harga' => 22000,
                'stok' => 20,
                'deskripsi' => 'Dikenal karena aroma menenangkannya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Krisan Kuning',
                'harga' => 14000,
                'stok' => 45,
                'deskripsi' => 'Bunga tahan lama dan cerah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Teratai Putih',
                'harga' => 30000,
                'stok' => 15,
                'deskripsi' => 'Melambangkan kedamaian dan spiritualitas.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('barang')->insert($data);
        
    }
}