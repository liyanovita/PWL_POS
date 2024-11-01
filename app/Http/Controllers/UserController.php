<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Monolog\Level;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use App\Http\Controllers\DataTables;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    // Menampilkan halaman awal user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';   // set menu yang sedang aktif

        $level = LevelModel::all();     // ambil data level untuk filter level

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk JSON untuk datatables
    public function list(Request $request)
    {
        // Ambil data user dengan level terkait
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id jika tersedia
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // Menambahkan kolom aksi
                // Tombol detail, edit, dan hapus dengan modal AJAX
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }

    // public function list(Request $request)
    // {
    //     $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
    //         ->with('level');

    //     // Filter data user berdasarkan level_id
    //     if ($request->level_id) {
    //         $users->where('level_id', $request->level_id);
    //     }

    //     return DataTables::of($users)
    //         // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
    //             $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
    //                 . csrf_field() . method_field('DELETE') .
    //                 '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';

    //             return $btn;
    //         })
    //         ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah HTML
    //         ->make(true);
    // }

    // Menampilkan halaman form tambah baru
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user';   // set menu yang sedang aktif

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama'     => 'required|string|max:100',    // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'required|min:5',    // password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer',    // level harus diisi dan berupa angka
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),  // password dienkripsi sebelum disimpan
            'level_id' => $request->level_id,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';   // set menu yang sedang aktif

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id)
    {
        $user = UserModel::find($id);
        return view('user.show_ajax', ['user' => $user]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';   // set menu yang sedang aktif

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit user ajax
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
            'username' => 'required|string|min:3|unique:m_user,username, ' . $id . ' ,user_id',
            'nama'     => 'required|string|max:100',    // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'nullable|min:5',    // password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer',    // level harus diisi dan berupa angka
        ]);

        $user = UserModel::find($id);

        $user->update([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => $request->password ? bcrypt($request->password) : $user->password,  // password dienkripsi sebelum disimpan
            'level_id'  => $request->level_id,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama'     => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false, // respon json, true: berhasil, false: gagal
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                // jika password tidak diisi, maka hapus dari request
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }

                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }


    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);  // Hapus data level

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Check if the request is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function import()
    {
        return view('user.import'); // Ensure you have a corresponding import view
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_user' => ['required', 'mimes:xlsx', 'max:1024'], // Validate uploaded file
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_user'); // Get the uploaded file

            $reader = IOFactory::createReader('Xlsx'); // Load the Excel reader
            $reader->setReadDataOnly(true); // Only read data
            $spreadsheet = $reader->load($file->getRealPath()); // Load the Excel file
            $sheet = $spreadsheet->getActiveSheet(); // Get the active sheet

            $data = $sheet->toArray(null, false, true, true); // Get data from Excel

            $insert = [];

            if (count($data) > 1) { // Check if data has more than one row
                foreach ($data as $row => $value) {
                    if ($row > 1) { // Skip the first row (header)
                        $insert[] = [
                            'level_id' => $value['A'],
                            'username' => $value['B'],
                            'nama' => $value['C'],
                            'password' => bcrypt($value['D']), // Hash the password
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Insert data into the database; ignore existing entries
                    UserModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport',
                ]);
            }
        }

        return redirect('/');
    }

    public function export_excel()
    {
        // Get user data to export
        $users = UserModel::select('level_id', 'username', 'nama', 'password')
            ->orderBy('level_id')
            ->get();

        // Load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // Get the active sheet

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Level ID');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Nama');
        $sheet->setCellValue('E1', 'Password');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // Bold header

        $no = 1; // Data number starts from 1
        $baris = 2; // Data row starts from row 2
        foreach ($users as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->level_id);
            $sheet->setCellValue('C' . $baris, $value->username);
            $sheet->setCellValue('D' . $baris, $value->nama);
            $sheet->setCellValue('E' . $baris, $value->password); // Export password directly, consider hashing in a real application
            $baris++;
            $no++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // Auto size columns
        }

        $sheet->setTitle('Data User'); // Set sheet title

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $users = UserModel::select('user_id', 'level_id', 'username', 'nama', 'password')
            ->with('level') // Ensure this relationship is defined in UserModel
            ->orderBy('user_id')
            ->get();

        // Load the PDF view
        $pdf = Pdf::loadView('user.export_pdf', ['users' => $users]);
        $pdf->setPaper('a4', 'portrait'); // Set paper size and orientation
        $pdf->setOption("isRemoteEnabled", true); // Enable remote images if needed
        $pdf->render();

        return $pdf->stream('Data User ' . date('Y-m-d H:i:s') . '.pdf');
    }
// public function showProfile()
//     {
//         $user = Auth::user(); // Mendapatkan user yang sedang login
//         $activeMenu = 'profile'; // Set active menu untuk halaman profile
//         $breadcrumb = (object) [
//             'title' => 'Profile',
//             'list' => ['Home']
//         ];
//         return view('profile.profile', compact('user', 'activeMenu', 'breadcrumb'));
//     }
//     public function uploadProfilePicture(Request $request)
//     {
//         $request->validate([
//             'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//         ]);
        
//         $user = Auth::user();

//         // Delete old avatar if exists
//         if ($user->avatar) {
//             Storage::delete($user->avatar);
//         }

//         $path = $request->file('avatar')->store('avatar');

//         // Update path in the database
//         $user->avatar = $path;
//         $user->save();
        
//         return redirect()->route('profile')->with('success', 'Profile picture updated successfully.');
//     }

//     public function updateProfile(Request $request)
//     {
//         $request->validate([
//             'username' => 'required|string|min:3|unique:m_user,username,' . Auth::id() . ',user_id',
//             'nama'     => 'required|string|max:100',
//         ]);

//         $user = Auth::user();
//         $user->update([
//             'username' => $request->username,
//             'nama'     => $request->nama,
//         ]);

//         return redirect()->route('profile')->with('success', 'Profile updated successfully.');
//     }

//     // Change user password
//     public function changePassword(Request $request)
//     {
//         $request->validate([
//             'password' => 'required|confirmed|min:6',
//         ]);

//         $user = Auth::user();
//         $user->update([
//             'password' => bcrypt($request->password),
//         ]);

//         return redirect()->route('profile')->with('success', 'Password changed successfully.');
//     }
}
    