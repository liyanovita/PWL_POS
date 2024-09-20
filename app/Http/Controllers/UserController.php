<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // tambah data user dengan Eloquent Model
        $user = UserModel::where('username', 'manager9')->firstOrFail();
        return view('user', ['data' => $user]);

        $data = [
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345'),
            'level_id' => 2

        ];
        UserModel::create($data); // tambahkan data ke tabel m_user

        //coba akses mode UserModel
        $user = UserModel::all(); //ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
    }
}
