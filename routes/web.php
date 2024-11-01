<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu

    // Route untuk menampilkan profil
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');

    // Route untuk update profil (termasuk upload gambar)
    Route::post('/profile/upload', [UserController::class, 'uploadProfilePicture'])->name('profile.upload');

    // Route untuk update informasi pengguna
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    // Route untuk mengubah password
    Route::post('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.changePassword');

    Route::get('/', [WelcomeController::class, 'index']);

    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);           // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']);       // menampilkan data user dalam bentuk json untuk datatables
            Route::get('/create', [UserController::class, 'create']);    // menampilkan halaman form tambah user
            Route::post('/', [UserController::class, 'store']);          // menyimpan data user baru
            Route::get('/create_ajax', [UserController::class, 'create_ajax']);    // menampilkan halaman form tambah user Ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']);          // menyimpan data user baru Ajax
            Route::get('/{id}', [UserController::class, 'show']);        // menampilkan detail user
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);        // menampilkan detail user
            Route::get('/{id}/edit', [UserController::class, 'edit']);   // menampilkan halaman form edit user
            Route::put('/{id}', [UserController::class, 'update']);      // menyimpan perubahan data user
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);   // menampilkan halaman form edit user Ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);      // menyimpan perubahan data user Ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete user Ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  // untuk hapus data user Ajax
            Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data user
            Route::get('/import', [UserController::class, 'import']);      // ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']);       // ajax form import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']);       // ajax form export excel
            Route::get('/export_pdf', [UserController::class, 'export_pdf']);       // ajax form export pdf
        });
    });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);          // menampilkan halaman awal level
        Route::post('/level/list', [LevelController::class, 'list']);      // menampilkan data level dalam bentuk json untuk datatables
        Route::get('/level/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/level', [LevelController::class, 'store']);         // menyimpan data level baru
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']);        // menampilkan detail barang Ajax
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        Route::get('/level/{id}', [LevelController::class, 'show']);       // menampilkan detail level
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
        Route::put('/level/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); // menghapus data level
        Route::get('/level/import', [LevelController::class, 'import']);      // ajax form upload excel
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']);       // ajax form import excel
        Route::get('/level/export_excel', [LevelController::class, 'export_excel']);       // ajax form export excel
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']);       // ajax form export pdf
    });

    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']);           // menampilkan halaman awal kategori
            Route::post('/list', [KategoriController::class, 'list']);       // menampilkan data kategori dalam bentuk json untuk datatables
            Route::get('/create', [KategoriController::class, 'create']);    // menampilkan halaman form tambah kategori
            Route::post('/', [KategoriController::class, 'store']);          // menyimpan data kategori baru
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);    // menampilkan halaman form tambah kategori Ajax
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);          // menyimpan data kategori baru Ajax
            Route::get('/{id}', [KategoriController::class, 'show']);        // menampilkan detail kategori
            Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);        // menampilkan detail kategori Ajax
            Route::get('/{id}/edit', [KategoriController::class, 'edit']);   // menampilkan halaman form edit kategori
            Route::put('/{id}', [KategoriController::class, 'update']);      // menyimpan perubahan data kategori
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);   // menampilkan halaman form edit kategori Ajax
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);      // menyimpan perubahan data kategori Ajax
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete kategori Ajax
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  // untuk hapus data kategori Ajax
            Route::delete('/{id}', [KategoriController::class, 'destroy']);  // menghapus data kategori
            Route::get('/import', [KategoriController::class, 'import']);      // ajax form upload excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']);       // ajax form import excel
            Route::get('/export_excel', [KategoriController::class, 'export_excel']);       // ajax form export excel
            Route::get('/export_pdf', [KategoriController::class, 'export_pdf']);       // ajax form export pdf
        });
    });

    // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']);           // menampilkan halaman awal barang
            Route::post('/list', [BarangController::class, 'list']);       // menampilkan data barang dalam bentuk json untuk datatables
            Route::get('/create', [BarangController::class, 'create']);    // menampilkan halaman form tambah barang
            Route::post('/', [BarangController::class, 'store']);          // menyimpan data barang baru
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']);    // menampilkan halaman form tambah barang Ajax
            Route::post('/ajax', [BarangController::class, 'store_ajax']);          // menyimpan data barang baru Ajax
            Route::get('/{id}', [BarangController::class, 'show']);        // menampilkan detail barang
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);        // menampilkan detail barang Ajax
            Route::get('/{id}/edit', [BarangController::class, 'edit']);   // menampilkan halaman form edit barang
            Route::put('/{id}', [BarangController::class, 'update']);      // menyimpan perubahan data barang
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);   // menampilkan halaman form edit barang Ajax
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);      // menyimpan perubahan data barang Ajax
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete barang Ajax
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);  // untuk hapus data barang Ajax
            Route::get('/import', [BarangController::class, 'import']);      // ajax form upload excel
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']);       // ajax form import excel
            Route::get('/export_excel', [BarangController::class, 'export_excel']);       // ajax form export excel
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']);       // ajax form export pdf
            Route::delete('/{id}', [BarangController::class, 'destroy']);  // menghapus data barang
        });
    });

    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index']);           // menampilkan halaman awal supplier
            Route::post('/list', [SupplierController::class, 'list']);       // menampilkan data supplier dalam bentuk json untuk datatables
            Route::get('/create', [SupplierController::class, 'create']);    // menampilkan halaman form tambah supplier
            Route::post('/', [SupplierController::class, 'store']);          // menyimpan data supplier baru
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);    // menampilkan halaman form tambah supplier Ajax
            Route::post('/ajax', [SupplierController::class, 'store_ajax']);          // menyimpan data supplier baru Ajax
            Route::get('/{id}', [SupplierController::class, 'show']);        // menampilkan detail supplier
            Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);        // menampilkan detail supplier Ajax
            Route::get('/{id}/edit', [SupplierController::class, 'edit']);   // menampilkan halaman form edit supplier
            Route::put('/{id}', [SupplierController::class, 'update']);      // menyimpan perubahan data supplier
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);   // menampilkan halaman form edit supplier Ajax
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);      // menyimpan perubahan data supplier Ajax
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete supplier Ajax
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);  // untuk hapus data supplier Ajax
            Route::delete('/{id}', [SupplierController::class, 'destroy']);  // menghapus data supplier
            Route::get('/import', [SupplierController::class, 'import']);      // ajax form upload excel
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax']);       // ajax form import excel
            Route::get('/export_excel', [SupplierController::class, 'export_excel']);       // ajax form export excel
            Route::get('/export_pdf', [SupplierController::class, 'export_pdf']);       // ajax form export pdf
        });
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'stok'], function () {
            Route::get('/', [StokController::class, 'index']);           // menampilkan halaman awal stok
            Route::post('/list', [StokController::class, 'list']);       // menampilkan data stok dalam bentuk json untuk datatables
            Route::get('/create_ajax', [StokController::class, 'create_ajax']);    // menampilkan halaman form tambah stok Ajax
            Route::post('/ajax', [StokController::class, 'store_ajax']);          // menyimpan data stok baru Ajax
            Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);        // menampilkan detail stok Ajax
            Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);   // menampilkan halaman form edit stok Ajax
            Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);      // menyimpan perubahan data stok Ajax
            Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete stok Ajax
            Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);  // untuk hapus data stok Ajax
            Route::get('/import', [StokController::class, 'import']);
            Route::post('/import_ajax', [StokController::class, 'import_ajax']);       // ajax form import excel untuk stok
            Route::get('/export_excel', [StokController::class, 'export_excel']);       // ajax form export excel untuk stok
            Route::get('/export_pdf', [StokController::class, 'export_pdf']);       // ajax form export pdf untuk stok
        });
    });
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/penjualan', [PenjualanController::class, 'index']);
        Route::post('/penjualan/list', [PenjualanController::class, 'list'])->name('penjualan.list');
        Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']);
        Route::post('/penjualan/ajax', [PenjualanController::class, 'store_ajax']);
        Route::get('/penjualan/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
        Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
        Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
        Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
        Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
        Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);
        Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']);
        Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']);
        Route::get('/penjualan/{id}/detail', [PenjualanController::class, 'detail'])->name('penjualan.detail');
        Route::post('/penjualan/{id}/detail/store', [PenjualanController::class, 'storeDetail'])->name('penjualan.detail.store');
    });

    Route::group(['prefix' =>'profile'],function(){
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::patch('/{id}', [ProfileController::class, 'update'])->name('profile.update');
    
});

});

    










// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);