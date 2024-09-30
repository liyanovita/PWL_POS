<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\UserModel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);

Route::get(uri:'/user/tambah', action: [UserController::class, 'tambah']);
Route::post(uri:'/user/tambah_simpan', action: [UserController::class, 'tambah_simpan']);

Route::get(uri: '/user/ubah/{id}', action: [UserController::class, 'ubah']);
Route::put(uri: '/user/ubah_simpan/{id}', action: [UserController::class, 'ubah_simpan']);

Route::get(uri: '/user/hapus/{id}', action: [UserController::class, 'hapus']);

Route::get('/', [WelcomeController::class,'index']);

