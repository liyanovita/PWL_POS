<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Data untuk Supplier 1: Elektronik
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'ELEC001', 'barang_nama' => 'Televisi LED 32"', 'harga_beli' => 2500000, 'harga_jual' => 3500000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'ELEC002', 'barang_nama' => 'Kulkas 2 Pintu', 'harga_beli' => 4000000, 'harga_jual' => 5500000],
            ['barang_id' => 3, 'kategori_id' => 1, 'barang_kode' => 'ELEC003', 'barang_nama' => 'Mesin Cuci Front Load', 'harga_beli' => 3000000, 'harga_jual' => 4500000],
            ['barang_id' => 4, 'kategori_id' => 1, 'barang_kode' => 'ELEC004', 'barang_nama' => 'Laptop Gaming', 'harga_beli' => 8000000, 'harga_jual' => 11000000],
            ['barang_id' => 5, 'kategori_id' => 1, 'barang_kode' => 'ELEC005', 'barang_nama' => 'Speaker Bluetooth', 'harga_beli' => 500000, 'harga_jual' => 750000],
            // Data untuk Supplier 2: Pakaian
            ['barang_id' => 6, 'kategori_id' => 2, 'barang_kode' => 'PAK001', 'barang_nama' => 'Kemeja Formal Pria', 'harga_beli' => 300000, 'harga_jual' => 450000],
            ['barang_id' => 7, 'kategori_id' => 2, 'barang_kode' => 'PAK002', 'barang_nama' => 'Dress Wanita', 'harga_beli' => 400000, 'harga_jual' => 600000],
            ['barang_id' => 8, 'kategori_id' => 2, 'barang_kode' => 'PAK003', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 250000, 'harga_jual' => 350000],
            ['barang_id' => 9, 'kategori_id' => 2, 'barang_kode' => 'PAK004', 'barang_nama' => 'Jaket Bomber', 'harga_beli' => 500000, 'harga_jual' => 700000],
            ['barang_id' => 10, 'kategori_id' => 2, 'barang_kode' => 'PAK005', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 100000, 'harga_jual' => 150000],
            // Data untuk Supplier 3: Peralatan Rumah Tangga
            ['barang_id' => 11, 'kategori_id' => 3, 'barang_kode' => 'PER001', 'barang_nama' => 'Meja Makan Kayu', 'harga_beli' => 1500000, 'harga_jual' => 2000000],
            ['barang_id' => 12, 'kategori_id' => 3, 'barang_kode' => 'PER002', 'barang_nama' => 'Kursi Kantor Ergonomis', 'harga_beli' => 1200000, 'harga_jual' => 1700000],
            ['barang_id' => 13, 'kategori_id' => 3, 'barang_kode' => 'PER003', 'barang_nama' => 'Lemari Pakaian 3 Pintu', 'harga_beli' => 2500000, 'harga_jual' => 3500000],
            ['barang_id' => 14, 'kategori_id' => 3, 'barang_kode' => 'PER004', 'barang_nama' => 'Rak Buku', 'harga_beli' => 800000, 'harga_jual' => 1200000],
            ['barang_id' => 15, 'kategori_id' => 3, 'barang_kode' => 'PER005', 'barang_nama' => 'Kasur Spring Bed', 'harga_beli' => 2000000, 'harga_jual' => 3000000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
