<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\SupplierModel;
use Illuminate\Support\Facades\Route;
use Monolog\Level;

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

// Route::get('/', [WelcomeController::class, 'index']);

// Route::group(['prefix' => 'user'], function () {
//     Route::get('/', [UserController::class, 'index']);           // menampilkan halaman awal user
//     Route::post('/list', [UserController::class, 'list']);       // menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [UserController::class, 'create']);    // menampilkan halaman form tambah user
//     Route::post('/', [UserController::class, 'store']);          // menyimpan data user baru
//     Route::get('/create_ajax', [UserController::class, 'create_ajax']);    // menampilkan halaman form tambah user Ajax
//     Route::post('/ajax', [UserController::class, 'store_ajax']);          // menyimpan data user baru Ajax
//     Route::get('/{id}', [UserController::class, 'show']);        // menampilkan detail user
//     Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);        // menampilkan detail user
//     Route::get('/{id}/edit', [UserController::class, 'edit']);   // menampilkan halaman form edit user
//     Route::put('/{id}', [UserController::class, 'update']);      // menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);   // menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);      // menyimpan perubahan data user Ajax
//     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete user Ajax
//     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  // untuk hapus data user Ajax
//     Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data user
// });

// Route::group(['prefix' => 'level'], function () {
//     Route::get('/', [LevelController::class, 'index']);           // menampilkan halaman awal level
//     Route::post('/list', [LevelController::class, 'list']);       // menampilkan data level dalam bentuk json untuk datatables
//     Route::get('/create', [LevelController::class, 'create']);    // menampilkan halaman form tambah level
//     Route::post('/', [LevelController::class, 'store']);          // menyimpan data level baru
//     Route::get('/create_ajax', [LevelController::class, 'create_ajax']);    // menampilkan halaman form tambah level Ajax
//     Route::post('/ajax', [LevelController::class, 'store_ajax']);          // menyimpan data level baru Ajax
//     Route::get('/{id}', [LevelController::class, 'show']);        // menampilkan detail level
//     Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);        // menampilkan detail level Ajax
//     Route::get('/{id}/edit', [LevelController::class, 'edit']);   // menampilkan halaman form edit level
//     Route::put('/{id}', [LevelController::class, 'update']);      // menyimpan perubahan data level
//     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);   // menampilkan halaman form edit level Ajax
//     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);      // menyimpan perubahan data level Ajax
//     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);  // untuk tampilkan form konfirmasi hapus level Ajax
//     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);  // untuk hapus data level Ajax
//     Route::delete('/{id}', [LevelController::class, 'destroy']);  // menghapus data level
// });


// Route::group(['prefix' => 'kategori'], function () {
//     Route::get('/', [KategoriController::class, 'index']);           // menampilkan halaman awal kategori
//     Route::post('/list', [KategoriController::class, 'list']);       // menampilkan data kategori dalam bentuk json untuk datatables
//     Route::get('/create', [KategoriController::class, 'create']);    // menampilkan halaman form tambah kategori
//     Route::post('/', [KategoriController::class, 'store']);          // menyimpan data kategori baru
//     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);    // menampilkan halaman form tambah kategori Ajax
//     Route::post('/ajax', [KategoriController::class, 'store_ajax']);          // menyimpan data kategori baru Ajax
//     Route::get('/{id}', [KategoriController::class, 'show']);        // menampilkan detail kategori
//     Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);        // menampilkan detail kategori Ajax
//     Route::get('/{id}/edit', [KategoriController::class, 'edit']);   // menampilkan halaman form edit kategori
//     Route::put('/{id}', [KategoriController::class, 'update']);      // menyimpan perubahan data kategori
//     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);   // menampilkan halaman form edit kategori Ajax
//     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);      // menyimpan perubahan data kategori Ajax
//     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete kategori Ajax
//     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  // untuk hapus data kategori Ajax
//     Route::delete('/{id}', [KategoriController::class, 'destroy']);  // menghapus data kategori
// });

// Route::group(['prefix' => 'supplier'], function () {
//     Route::get('/', [SupplierController::class, 'index']);           // menampilkan halaman awal supplier
//     Route::post('/list', [SupplierController::class, 'list']);       // menampilkan data supplier dalam bentuk json untuk datatables
//     Route::get('/create', [SupplierController::class, 'create']);    // menampilkan halaman form tambah supplier
//     Route::post('/', [SupplierController::class, 'store']);          // menyimpan data supplier baru
//     Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);    // menampilkan halaman form tambah supplier Ajax
//     Route::post('/ajax', [SupplierController::class, 'store_ajax']);          // menyimpan data supplier baru Ajax
//     Route::get('/{id}', [SupplierController::class, 'show']);        // menampilkan detail supplier
//     Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);        // menampilkan detail supplier Ajax
//     Route::get('/{id}/edit', [SupplierController::class, 'edit']);   // menampilkan halaman form edit supplier
//     Route::put('/{id}', [SupplierController::class, 'update']);      // menyimpan perubahan data supplier
//     Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);   // menampilkan halaman form edit supplier Ajax
//     Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);      // menyimpan perubahan data supplier Ajax
//     Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete supplier Ajax
//     Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);  // untuk hapus data supplier Ajax
//     Route::delete('/{id}', [SupplierController::class, 'destroy']);  // menghapus data supplier
// });

// // Routing untuk Barang
// Route::group(['prefix' => 'barang'], function () {
//     Route::get('/', [BarangController::class, 'index']);           // menampilkan halaman awal barang
//     Route::post('/list', [BarangController::class, 'list']);       // menampilkan data barang dalam bentuk json untuk datatables
//     Route::get('/create', [BarangController::class, 'create']);    // menampilkan halaman form tambah barang
//     Route::post('/', [BarangController::class, 'store']);          // menyimpan data barang baru
//     Route::get('/create_ajax', [BarangController::class, 'create_ajax']);    // menampilkan halaman form tambah barang Ajax
//     Route::post('/ajax', [BarangController::class, 'store_ajax']);          // menyimpan data barang baru Ajax
//     Route::get('/{id}', [BarangController::class, 'show']);        // menampilkan detail barang
//     Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);        // menampilkan detail barang Ajax
//     Route::get('/{id}/edit', [BarangController::class, 'edit']);   // menampilkan halaman form edit barang
//     Route::put('/{id}', [BarangController::class, 'update']);      // menyimpan perubahan data barang
//     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);   // menampilkan halaman form edit barang Ajax
//     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);      // menyimpan perubahan data barang Ajax
//     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);  // untuk tampilkan form confirm delete barang Ajax
//     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);  // untuk hapus data barang Ajax
//     Route::delete('/{id}', [BarangController::class, 'destroy']);  // menghapus data barang
// });

// Route::get('/', [WelcomeController::class, 'index']);

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
    // masukkan semua route yang perlu autentikasi di sini

    // Route untuk menampilkan profil
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');

    // Route untuk update profil (termasuk upload gambar)
    Route::post('/profile/upload', [UserController::class, 'uploadProfilePicture'])->name('profile.upload');
    Route::get('/', [WelcomeController::class, 'index']);

    Route::group(['prefix' => 'user'], function ()  {
        Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);   // menampilkan halaman form tambah user
        Route::post('/ajax', [UserController::class, 'store_ajax']);         // menyimpan data user baru
        Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
        Route::get('/user/{id}/show_ajax', [UserController::class, 'show_ajax']);  
        Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
        Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  // menampilkan halaman form edit user
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);     // menyimpan perubahan data user
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);     // menyimpan perubahan data user
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // menghapus data user
        Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
        Route::get('/import', [UserController::class, 'import']);      // ajax form upload excel
        Route::post('/import_ajax', [UserController::class, 'import_ajax']);       // ajax form import excel
        Route::get('/export_excel', [UserController::class, 'export_excel']);       // ajax form export excel
        Route::get('/export_pdf', [UserController::class, 'export_pdf']);       // ajax form export pdf
        
    });
    
    
     //artinya semua route di dalam group ini harus punya role ADM (Administrator)
        Route::middleware(['authorize:ADM'])->group(function () {
            Route::get('/level', [LevelController::class, 'index']);          // menampilkan halaman awal level
            Route::post('/level/list', [LevelController::class, 'list']);      // menampilkan data level dalam bentuk json untuk datatables
            Route::get('/level/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
            Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
            Route::post('/level', [LevelController::class, 'store']);         // menyimpan data level baru
            Route::post('/level/ajax', [LevelController::class, 'store_ajax']);
            Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
            Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);
            Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
            Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
            Route::get('/level/{id}', [LevelController::class, 'show']);       // menampilkan detail level
            Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']);  
            Route::get('/level/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
            Route::put('/level/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
            Route::delete('/level/{id}', [LevelController::class, 'destroy']); // menghapus data level
            Route::get('/level/import', [LevelController::class, 'import']); // ajax form upload excel
            Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel 
            Route::get('/level/export_excel', [LevelController::class, 'export_excel']); // export excel
            Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']); // export pdf
        });
    
        // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG(Manager)
        Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/kategori', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
            Route::post('/kategori/list', [KategoriController::class, 'list']);      // menampilkan data kategori dalam bentuk json untuk datatables
            Route::get('/kategori/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah kategori
            Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']);
            Route::post('/kategori/ajax', [KategoriController::class, 'store_ajax']);
            Route::post('/kategori', [KategoriController::class, 'store']);         // menyimpan data kategori baru
            Route::get('/kategori/{id}', [KategoriController::class, 'show']);
            Route::get('/kategori/{id}/show_ajax', [KategoriController::class, 'show_ajax']);        // menampilkan detail kategori
            Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit']);  // menampilkan halaman form edit kategori
            Route::put('/kategori/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data kategori
            Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
            Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
            Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
            Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
            Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
            Route::get('/kategori/import', [KategoriController::class, 'import']); // ajax form upload excel
            Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel 
            Route::get('/kategori/export_excel', [KategoriController::class, 'export_excel']); // export excel
            Route::get('/kategori/export_pdf', [KategoriController::class, 'export_pdf']); // export pdf
        });
    
        // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG(Manager)
        Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/barang', [BarangController::class, 'index']);          // menampilkan halaman awal barang
            Route::post('/barang/list', [BarangController::class, 'list']);      // menampilkan data barang dalam bentuk json untuk datatables
            Route::get('/barang/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
            Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']);
            Route::post('/barang', [BarangController::class, 'store']);         // menyimpan data barang baru
            Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);
            Route::get('/barang/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
            Route::get('/barang/{id}/show_ajax', [BarangController::class, 'show_ajax']);  
            Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
            Route::put('/barang/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
            Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
            Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']);
            Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
            Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
            Route::delete('/barang/{id}', [BarangController::class, 'destroy']); // menghapus data barang
            Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
            Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel 
            Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // export excel
            Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']); // export pdf
        });
    
        // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG(Manager)
        Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/supplier', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
            Route::post('/supplier/list', [SupplierController::class, 'list']);      // menampilkan data supplier dalam bentuk json untuk datatables
            Route::get('/supplier/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
            Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']);
            Route::post('/supplier', [SupplierController::class, 'store']);         // menyimpan data supplier baru
            Route::post('/supplier/ajax', [SupplierController::class, 'store_ajax']);
            Route::get('/supplier/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
            Route::get('/supplier/{id}/show_ajax', [SupplierController::class, 'show_ajax']);  
            Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit supplier
            Route::put('/supplier/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
            Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
            Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
            Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
            Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
            Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
            Route::get('/supplier/import', [SupplierController::class, 'import']); // ajax form upload excel
            Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel 
            Route::get('/supplier/export_excel', [SupplierController::class, 'export_excel']); // export excel
            Route::get('/supplier/export_pdf', [SupplierController::class, 'export_pdf']); // export pdf
        });

        Route::group(['prefix' => 'penjualan', 'middleware' => 'authorize:ADM,MNG,STF'], function() {
            Route::get('/', [PenjualanController::class, 'index']); // Menampilkan laman awal penjualan
            Route::post('/list', [PenjualanController::class, 'list']); // Menampilkan data penjualan dalam bentuk json untuk datatables.
            Route::get('/create', [PenjualanController::class, 'create']); // Membuat data penjualan
            Route::post('/', [PenjualanController::class, 'store']); // Menyimpan data yang telah dibuat
        
            Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']); // Menambah data penjualan dengan ajax
            Route::post('/ajax', [PenjualanController::class, 'store_ajax']); // Menyimpan data penjualan yang telah dibuat dengan ajax
        
            Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']); // Menampilkan detail data penjualan
            Route::get('/{id}/edit', [PenjualanController::class, 'edit']); // Edit data penjualan tertentu
            Route::put('/{id}', [PenjualanController::class, 'update']); // Menyimpan perubahan data penjualan
        
            Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']); // Edit data penjualan dengan ajax
            Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']); // Menyimpan perubahan data penjualan dengan ajax
        
            Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']); // Munculkan pop up konfirmasi delete dengan ajax
            Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); // Menghapus data penjualan dengan ajax
        
            Route::get('/import', [PenjualanController::class, 'import']); // Import excel
            Route::post('/import_ajax', [PenjualanController::class, 'import_ajax']); // Import excel dengan ajax
        
            Route::get('/export_excel', [PenjualanController::class, 'export_excel']); // Export excel
            Route::get('/export_pdf', [PenjualanController::class, 'export_pdf']); // Export pdf
        
            Route::delete('/{id}', [PenjualanController::class, 'destroy']); // Menghapus data penjualan
        });
            // Artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
            Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/stok', [StokController::class, 'index']);          // menampilkan halaman awal stok
            Route::post('/stok/list', [StokController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
            Route::get('/stok/create', [StokController::class, 'create']);   // menampilkan halaman form tambah stok
            Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']);
            Route::post('/stok/ajax', [StokController::class, 'store_ajax']);
            Route::post('/stok', [StokController::class, 'store']);         // menyimpan data stok baru
            Route::get('/stok/{id}', [StokController::class, 'show']);
            Route::get('/stok/{id}/show_ajax', [StokController::class, 'show_ajax']);        // menampilkan detail stok
            Route::get('/stok/{id}/edit', [StokController::class, 'edit']);  // menampilkan halaman form edit stok
            Route::put('/stok/{id}', [StokController::class, 'update']);     // menyimpan perubahan data stok
            Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
            Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']);
            Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
            Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
            Route::delete('/stok/{id}', [StokController::class, 'destroy']); // menghapus data stok
            Route::get('/stok/import', [StokController::class, 'import']); // ajax form upload excel
            Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']); // ajax import excel 
            Route::get('/stok/export_excel', [StokController::class, 'export_excel']); // export excel
            Route::get('/stok/export_pdf', [StokController::class, 'export_pdf']); // export pdf
});

            Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
                Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); // Name the route here
                Route::post('/profile/update_profile', [ProfileController::class, 'update_profile'])->name('profile.update_profile');
                Route::put('/profile/update_pengguna/{id}', [ProfileController::class, 'update_pengguna'])->name('profile.update_pengguna');
                Route::put('/profile/update_password/{id}', [ProfileController::class, 'update_password'])->name('profile.update_password');
            });

            Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
                Route::get('/penjualan', [PenjualanController::class, 'index']);
                Route::post('/penjualan/list', [PenjualanController::class, 'list'])->name('penjualan.list');
                Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']);
                Route::post('/penjualan/store_ajax', [PenjualanController::class, 'store_ajax']);
                Route::get('/penjualan/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
                Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
                Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
                Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
                Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
                Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);
                Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']);
                Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']);
            });
        

    // // Route::group(['prefix' => 'penjualan'], function () {
    //     Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    //         Route::get('/penjualan', [PenjualanController::class, 'index']);          // menampilkan halaman awal stok
    //         Route::post('/penjualan/list', [PenjualanController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
    //         Route::get('/penjualan/create', [PenjualanController::class, 'create']);   // menampilkan halaman form tambah stok
    //         Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']);
    //         Route::post('/penjualan/ajax', [PenjualanController::class, 'store_ajax']);
    //         Route::post('/penjualan', [PenjualanController::class, 'store']);         // menyimpan data stok baru
    //         Route::get('/penjualan/import', [PenjualanController::class, 'import']);
    //         Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);
    //         Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']); // export excel
    //         Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']); // export pdf
    //         Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);       // menampilkan detail stok
    //         Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit']);  // menampilkan halaman form edit stok
    //         Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);     // menyimpan perubahan data stok
    //         Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
    //         Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
    //         Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
    //         Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
    //         Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy']); // menghapus data stok
    //     });
});



    // // Route::group(['prefix' => 'stok'], function () {
    // Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    //     Route::get('/stok', [StokController::class, 'index']);          // menampilkan halaman awal stok
    //     Route::post('/stok/list', [StokController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
    //     Route::get('/stok/create', [StokController::class, 'create']);   // menampilkan halaman form tambah stok
    //     Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']);
    //     Route::post('/stok/ajax', [StokController::class, 'store_ajax']);
    //     Route::post('/stok', [StokController::class, 'store']);         // menyimpan data stok baru
    //     Route::get('/stok/{id}', [StokController::class, 'show']);       // menampilkan detail stok
    //     Route::get('/stok/{id}/edit', [StokController::class, 'edit']);  // menampilkan halaman form edit stok
    //     Route::put('/stok/{id}', [StokController::class, 'update']);     // menyimpan perubahan data stok
    //     Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
    //     Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']);
    //     Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
    //     Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
    //     Route::delete('/stok/{id}', [StokController::class, 'destroy']); // menghapus data stok
    // });



// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);