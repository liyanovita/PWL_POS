<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
             // Stok untuk barang di kategori 1 (Elektronik)
            [
                'stok_id' => 1,
                'barang_id' => 1, // ELK001
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 50,
            ],
            [
                'stok_id' => 2,
                'barang_id' => 2, // ELK002
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 40,
            ],
            [
                'stok_id' => 3,
                'barang_id' => 3, // ELK003
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 30,
            ],
            [
                'stok_id' => 4,
                'barang_id' => 4, // ELK004
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 70,
            ],
            [
                'stok_id' => 5,
                'barang_id' => 5, // ELK005
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 25,
            ],

            // Stok untuk barang di kategori 2 (Pakaian)
            [
                'stok_id' => 6,
                'barang_id' => 6, // PKN001
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 100,
            ],
            [
                'stok_id' => 7,
                'barang_id' => 7, // PKN002
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 150,
            ],
            [
                'stok_id' => 8,
                'barang_id' => 8, // PKN003
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 80,
            ],
            [
                'stok_id' => 9,
                'barang_id' => 9, // PKN004
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 50,
            ],
            [
                'stok_id' => 10,
                'barang_id' => 10, // PKN005
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 120,
            ],

            // Stok untuk barang di kategori 3 (Peralatan Rumah Tangga)
            [
                'stok_id' => 11,
                'barang_id' => 11, // PRT001
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 40,
            ],
            [
                'stok_id' => 12,
                'barang_id' => 12, // PRT002
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 60,
            ],
            [
                'stok_id' => 13,
                'barang_id' => 13, // PRT003
                'user_id' => 3,
                'stok_tanggal' => now(),
                'stok_jumlah' => 20,
            ],
            [
                'stok_id' => 14,
                'barang_id' => 14, // PRT004
                'user_id' => 1,
                'stok_tanggal' => now(),
                'stok_jumlah' => 90,
            ],
            [
                'stok_id' => 15,
                'barang_id' => 15, // PRT005
                'user_id' => 2,
                'stok_tanggal' => now(),
                'stok_jumlah' => 30,
            ],
        ];
        DB::table('t_stok')->insert($data);
    }
}
