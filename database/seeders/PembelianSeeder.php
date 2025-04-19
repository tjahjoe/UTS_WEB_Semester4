<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
                [
                    'id_akun' => 1,
                    'total' => 33000,
                    'status' => 'menunggu',
                    'tanggal_pembelian' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_akun' => 2,
                    'total' => 43000,
                    'status' => 'diproses',
                    'tanggal_pembelian' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_akun' => 1,
                    'total' => 25000,
                    'status' => 'selesai',
                    'tanggal_pembelian' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_akun' => 3,
                    'total' => 45000,
                    'status' => 'gagal',
                    'tanggal_pembelian' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_akun' => 4,
                    'total' => 44000,
                    'status' => 'menunggu',
                    'tanggal_pembelian' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            
        ];

        DB::table('pembelian')->insert($data);
    }
}
