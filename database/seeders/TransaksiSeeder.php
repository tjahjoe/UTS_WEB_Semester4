<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_pembelian' => 1, 
                'id_barang' => 3, 
                'harga' => 18000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 1, 
                'id_barang' => 1, 
                'harga' => 15000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 2, 
                'id_barang' => 4, 
                'harga' => 25000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 2, 
                'id_barang' => 3, 
                'harga' => 18000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 3, 
                'id_barang' => 5, 
                'harga' => 12000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 3, 
                'id_barang' => 7, 
                'harga' => 13000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 4, 
                'id_barang' => 4, 
                'harga' => 25000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 4, 
                'id_barang' => 2, 
                'harga' => 20000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 5, 
                'id_barang' => 9, 
                'harga' => 14000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pembelian' => 5, 
                'id_barang' => 10, 
                'harga' => 30000,
                'jumlah_beli' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('transaksi')->insert($data);

    }
}
