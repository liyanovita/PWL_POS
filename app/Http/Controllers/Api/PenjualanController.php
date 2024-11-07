<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
         return PenjualanModel::all();    
     }

     public function store(Request $request)
     {
        $request->validate([
            'user_id' => 'required',
            'pembeli' => 'required',
            'penjualan_kode' => 'required',
            'penjualan_tanggal' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $penjualan = PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image' => $request->image->hashName(),
        ]);

        if ($penjualan) {
            return response()->json([
                'success' => true,
                'message' => 'Penjualan berhasil ditambahkan',
                'data' => $penjualan,
            ], 201);
        }

        // Return JSON if process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    
     }
     public function show(PenjualanModel $penjualan)
    {
         return response()->json($penjualan);
     }
}




