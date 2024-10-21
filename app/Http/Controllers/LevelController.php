<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    // Menampilkan halaman awal level
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level';   // set menu yang sedang aktif

        $level = LevelModel::all();     // ambil data level untuk filter level

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Ambil data level dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        // Filter data level berdasarkan level_id jika tersedia
        if ($request->level_id) {
            $levels->where('level_id', $request->level_id);
        }

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                // Tombol detail, edit, dan hapus dengan modal AJAX
                $btn = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah baru
    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    // Menyimpan data level baru melalui request AJAX
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100'
            ];

            // Validasi data
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            LevelModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // Menampilkan detail level
    public function show_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.show_ajax', ['level' => $level]);
    }

    // Menampilkan halaman form edit level dengan AJAX
    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.edit_ajax', ['level' => $level]);
    }

    // Update data level dengan AJAX
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $level = LevelModel::find($id);
            if ($level) {
                $level->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
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

    // Konfirmasi penghapusan level dengan AJAX
    public function confirm_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.confirm_ajax', ['level' => $level]);
    }

    // Menghapus data level melalui request AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
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
        return view('level.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // Validation rules: file must be xlsx, max 1MB
                'file_level' => ['required', 'mimes:xlsx', 'max:1024'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_level'); // Get the uploaded file

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
                            // 'level_id' is auto increment, no need to insert it manually
                            'level_kode' => $value['A'], // Assuming kode is in column A
                            'level_nama' => $value['B'], // Assuming nama is in column B
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Insert data into the database; ignore existing entries
                    LevelModel::insertOrIgnore($insert);
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
        // Get level data to export
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama')
            ->orderBy('level_id')
            ->get();

        // Load Excel library
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // Get active sheet

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Level ID');
        $sheet->setCellValue('C1', 'Level Kode');
        $sheet->setCellValue('D1', 'Level Nama');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true); // Bold header

        $no = 1; // Start number from 1
        $row = 2; // Data starts from row 2
        foreach ($level as $key => $value) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $value->level_id);
            $sheet->setCellValue('C' . $row, $value->level_kode);
            $sheet->setCellValue('D' . $row, $value->level_nama);
            $row++;
            $no++;
        }

        foreach (range('A', 'D') as $coloumID) {
            $sheet->getColumnDimension($coloumID)->setAutoSize(true); // Auto-size columns
        }

        $sheet->setTitle('Data Level'); // Set sheet title

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Level ' . date('Y-m-d H:i:s') . '.xlsx';

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
        // Get level data for PDF export
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama')
            ->orderBy('level_id')
            ->get();

        // Use Barryvdh\DomPDF\Facade\Pdf
        $pdf = Pdf::loadView('level.export_pdf', ['level' => $level]);
        $pdf->setPaper('a4', 'portrait'); // Set paper size and orientation
        $pdf->setOption("isRemoteEnabled", true); // Enable remote if images are from URL
        $pdf->render();

        return $pdf->stream('Data Level ' . date('Y-m-d H:i:s') . '.pdf');
    }
}