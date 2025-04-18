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
                'id_akun' => 1, 
                'id_barang' => 3, 
                'jumlah_beli' => 2, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 2, 
                'id_barang' => 1, 
                'jumlah_beli' => 5, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 3, 
                'id_barang' => 4, 
                'jumlah_beli' => 1, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 1, 
                'id_barang' => 3, 
                'jumlah_beli' => 3, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 5, 
                'id_barang' => 5, 
                'jumlah_beli' => 2, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 6, 
                'id_barang' => 7, 
                'jumlah_beli' => 4, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 3, 
                'id_barang' => 4, 
                'jumlah_beli' => 2, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 4, 
                'id_barang' => 2, 
                'jumlah_beli' => 3, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 9, 
                'id_barang' => 9, 
                'jumlah_beli' => 2, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 10, 
                'id_barang' => 10, 
                'jumlah_beli' => 6, 
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('transaksi')->insert($data);

    }
}
