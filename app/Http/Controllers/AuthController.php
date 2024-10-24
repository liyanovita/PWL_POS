<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; // Untuk hashing password

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home 
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    //register
    public function register()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('auth.register')
            ->with('level', $level);
    }

    public function store(Request $request)
{
    // cek apakah request berupa ajax
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id'  => 'required|integer',
            'username'  => 'required|string|min:3|unique:m_user,username',
            'nama'      => 'required|string|max:100',
            'password'  => 'required|min:5'
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false, // response status, false: error/gagal, true: berhasil
                'message'   => 'Validasi Gagal',
                'msgField'  => $validator->errors(), // pesan error validasi
            ]);
        }

        // Buat user baru, hash password terlebih dahulu
        UserModel::create([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => Hash::make($request->password), // Hash password
            'level_id'  => $request->level_id,
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Data user berhasil disimpan',
            'redirect'  => url('login')
        ]);
    }
    return redirect('login');
}
}