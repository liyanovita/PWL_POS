<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Carbon\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::all();
        return view('user', ['data'=> $user]);
    }
    public function tambah(): Factory|View
    {
        return view(view: 'user_tambah');
    }

    public function tambah_simpan(Request $request): Redirector|RedirectResponse
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password), // Hapus tanda kutip di sekitar $request->password
            'level_id' => $request->level_id
    ]);

    return redirect('/user');
}

    public function ubah($id): Factory|View
    {
        $user = UserModel::find($id);
        return view(view: 'user_ubah', data: ['data' => $user]);
    }
    
    public function ubah_simpan($id, Request $request): Redirector|RedirectResponse
    {
        $user = UserModel::find (id: $id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make(value: $request->password); // Tanpa tanda kutip
        $user->level_id = $request->level_id;

        $user->save();

        return redirect(to: '/user');
    }

    public function hapus($id): Redirector|RedirectResponse
     {
        $user = UserModel::find(id: $id);
        $user->delete();

        return redirect(to: '/user');
     }
    }


        // tambah data user dengan Eloquent Model
        // $user = UserModel::create( [
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);  
        // $user->username = 'manager12';
            
        // $user->save();
            
        // $user->wasChanged(); // true
        // $user->wasChanged('username'); // true
        // $user->wasChanged(['username', 'level_id']); // true
        // $user->wasChanged('nama'); // false
        // dd($user->wasChanged(['nama', 'username'])); // true

        // $userCount = UserModel::where('level_id', 2)->count();
        //return view('user', ['userCount' => $userCount]); prak 2.3

        // $data = [
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2

        // ];
        // UserModel::create($data); // tambahkan data ke tabel m_user

        //coba akses mode UserModel
        // $user = UserModel::all(); //ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);