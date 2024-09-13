<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
             // Transaksi Penjualan 1
             [
                'detail_id' => 1,
                'penjualan_id' => 1,
                'barang_id' => 1, // Televisi LED 32"
                'harga' => 3500000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 2,
                'penjualan_id' => 1,
                'barang_id' => 2, // Kulkas 2 Pintu
                'harga' => 5500000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 3,
                'penjualan_id' => 1,
                'barang_id' => 3, // Mesin Cuci Front Load
                'harga' => 4500000,
                'jumlah' => 1,
            ],

            // Transaksi Penjualan 2
            [
                'detail_id' => 4,
                'penjualan_id' => 2,
                'barang_id' => 4, // Laptop Gaming
                'harga' => 11000000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 5,
                'penjualan_id' => 2,
                'barang_id' => 5, // Speaker Bluetooth
                'harga' => 750000,
                'jumlah' => 2,
            ],
            [
                'detail_id' => 6,
                'penjualan_id' => 2,
                'barang_id' => 6, // Kemeja Formal Pria
                'harga' => 450000,
                'jumlah' => 3,
            ],

            // Transaksi Penjualan 3
            [
                'detail_id' => 7,
                'penjualan_id' => 3,
                'barang_id' => 7, // Dress Wanita
                'harga' => 600000,
                'jumlah' => 2,
            ],
            [
                'detail_id' => 8,
                'penjualan_id' => 3,
                'barang_id' => 8, // Celana Jeans
                'harga' => 350000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 9,
                'penjualan_id' => 3,
                'barang_id' => 9, // Jaket Bomber
                'harga' => 700000,
                'jumlah' => 1,
            ],

            // Transaksi Penjualan 4
            [
                'detail_id' => 10,
                'penjualan_id' => 4,
                'barang_id' => 10, // Kaos Polos
                'harga' => 150000,
                'jumlah' => 4,
            ],
            [
                'detail_id' => 11,
                'penjualan_id' => 4,
                'barang_id' => 11, // Meja Makan Kayu
                'harga' => 2000000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 12,
                'penjualan_id' => 4,
                'barang_id' => 12, // Kursi Kantor Ergonomis
                'harga' => 1700000,
                'jumlah' => 2,
            ],

            // Transaksi Penjualan 5
            [
                'detail_id' => 13,
                'penjualan_id' => 5,
                'barang_id' => 13, // Lemari Pakaian 3 Pintu
                'harga' => 3500000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 14,
                'penjualan_id' => 5,
                'barang_id' => 14, // Rak Buku
                'harga' => 1200000,
                'jumlah' => 2,
            ],
            [
                'detail_id' => 15,
                'penjualan_id' => 5,
                'barang_id' => 15, // Kasur Spring Bed
                'harga' => 3000000,
                'jumlah' => 1,
            ],

            // Transaksi Penjualan 6
            [
                'detail_id' => 16,
                'penjualan_id' => 6,
                'barang_id' => 1, // Televisi LED 32"
                'harga' => 3500000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 17,
                'penjualan_id' => 6,
                'barang_id' => 6, // Kemeja Formal Pria
                'harga' => 450000,
                'jumlah' => 2,
            ],
            [
                'detail_id' => 18,
                'penjualan_id' => 6,
                'barang_id' => 7, // Dress Wanita
                'harga' => 600000,
                'jumlah' => 1,
            ],

            // Transaksi Penjualan 7
            [
                'detail_id' => 19,
                'penjualan_id' => 7,
                'barang_id' => 2, // Kulkas 2 Pintu
                'harga' => 5500000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 20,
                'penjualan_id' => 7,
                'barang_id' => 8, // Celana Jeans
                'harga' => 350000,
                'jumlah' => 3,
            ],
            [
                'detail_id' => 21,
                'penjualan_id' => 7,
                'barang_id' => 12, // Kursi Kantor Ergonomis
                'harga' => 1700000,
                'jumlah' => 2,
            ],

            // Transaksi Penjualan 8
            [
                'detail_id' => 22,
                'penjualan_id' => 8,
                'barang_id' => 4, // Laptop Gaming
                'harga' => 11000000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 23,
                'penjualan_id' => 8,
                'barang_id' => 5, // Speaker Bluetooth
                'harga' => 750000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 24,
                'penjualan_id' => 8,
                'barang_id' => 13, // Lemari Pakaian 3 Pintu
                'harga' => 3500000,
                'jumlah' => 1,
            ],

            // Transaksi Penjualan 9
            [
                'detail_id' => 25,
                'penjualan_id' => 9,
                'barang_id' => 10, // Kaos Polos
                'harga' => 150000,
                'jumlah' => 5,
            ],
            [
                'detail_id' => 26,
                'penjualan_id' => 9,
                'barang_id' => 14, // Rak Buku
                'harga' => 1200000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 27,
                'penjualan_id' => 9,
                'barang_id' => 15, // Kasur Spring Bed
                'harga' => 3000000,
                'jumlah' => 1,
            ],

            // Transaksi Penjualan 10
            [
                'detail_id' => 28,
                'penjualan_id' => 10,
                'barang_id' => 3, // Mesin Cuci Front Load
                'harga' => 4500000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 29,
                'penjualan_id' => 10,
                'barang_id' => 6, // Kemeja Formal Pria
                'harga' => 450000,
                'jumlah' => 2,
            ],
            [
                'detail_id' => 30,
                'penjualan_id' => 10,
                'barang_id' => 8, // Celana Jeans
                'harga' => 350000,
                'jumlah' => 1,
            ],
        ];
        DB::table('t_penjualan_detail')->insert($data);
}
}
