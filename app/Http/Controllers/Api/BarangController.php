<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
         return BarangModel::all();    
     }

     public function store(Request $request)
     {
         // Validasi data
         $request->validate([
             'kategori_id' => 'required',
             'barang_nama' => 'required',
             'barang_kode' => 'required',
             'harga_beli' => 'required|numeric',
             'harga_jual' => 'required|numeric',
             'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);
     
        //  // Proses upload gambar
        //  if ($request->hasFile('image')) {
        //      $imageName = $request->file('image')->store('images', 'public');
        //  }
     
         // Buat data baru di database
         $barang = BarangModel::create([
             'kategori_id' => $request->kategori_id,
             'barang_nama' => $request->barang_nama,
             'barang_kode' => $request->barang_kode,
             'harga_beli' => $request->harga_beli,
             'harga_jual' => $request->harga_jual,
             'image' => $request->image->hashName(),
         ]);
     
         // Cek apakah data berhasil dibuat
         if ($barang) {
             return response()->json([
                 'success' => true,
                 'message' => 'Barang berhasil ditambahkan',
                 'data' => $barang,
             ], 201);
         }
     
         // Jika gagal, kembalikan response error
         return response()->json([
             'success' => false,
             'message' => 'Gagal menambahkan barang',
         ], 409);
     }
    }
