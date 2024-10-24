<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use Barryvdh\DomPDF\Facade\Pdf;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok Barang',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok barang'
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang,'supplier' => $supplier, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
{
    // Ambil data stok beserta relasinya
    $stok = StokModel::select('stok_id', 'barang_id', 'user_id', 'supplier_id', 'stok_tanggal', 'stok_jumlah')
        ->with(['barang', 'user', 'supplier']); // Pastikan relasi 'supplier' di-load

    // Filter data stok berdasarkan barang_id jika ada
    if ($request->barang_id) {
        $stok->where('barang_id', $request->barang_id);
    }

    // Return data ke DataTables
    return DataTables::of($stok)
        ->addIndexColumn() // Menambahkan kolom nomor urut
        ->addColumn('aksi', function ($stok) {
            $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->addColumn('supplier_nama', function ($stok) {
            return $stok->supplier ? $stok->supplier->supplier_nama : 'N/A'; // Mendapatkan nama supplier
        }) // Tambahkan kolom nama supplier
        ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi berisi HTML
        ->make(true);
}


    public function create_ajax()
    {
        $user = UserModel::select('user_id', 'username')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        return view('stok.create_ajax')
            ->with('user', $user)
            ->with('barang', $barang)
            ->with('supplier', $supplier);
    }
    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa ajax atau ingin JSON
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer',
                'supplier_id' => 'requireed|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer'
            ];

            // Gunakan Validator dari Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
            // Simpan data user
            StokModel::create($request->all());

            // Jika berhasil
            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan',
            ]);
        }
        // Redirect jika bukan request Ajax
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $stok = StokModel::find($id);
        $user = UserModel::select('user_id', 'username')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();

        return view('stok.edit_ajax', ['stok' => $stok, 'user' => $user, 'barang' => $barang,  'supplier' => $supplier]);
    }

    public function import()
    {
        return view('stok.import');
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer',
                'supplier_id' => 'requireed|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = StokModel::find($id);
            if ($check) {
                $check->update($request->all());
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

    public function confirm_ajax(string $id)
    {
        $stok = StokModel::find($id);

        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
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
    public function export_excel()
    {
        $stok = StokModel::select('stok_id', 'barang_id','supplier_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with('barang', 'user', 'supplier')
            ->get();
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Nama Barang');
            $sheet->setCellValue('C1', 'Nama Supplier');
            $sheet->setCellValue('D1', 'Nama Pengguna');
            $sheet->setCellValue('E1', 'Tanggal Stok');
            $sheet->setCellValue('F1', 'Jumlah Stok');

            $sheet->getStyle('A1:F1')->getFont()->setBold(true);

            $no = 1;
            // nomor data dimulai dari 1
            $baris = 2;
            // baris data dimulai dari baris ke 2
            foreach ($stok as $key => $value) {
                $sheet->setCellValue('A'.$baris, $no);
                $sheet->setCellValue('B'.$baris, $value->barang->barang_nama);
                $sheet->setCellValue('C'.$baris, $value->supplier->supplier_nama);
                $sheet->setCellValue('D'.$baris, $value->user->nama);
                $sheet->setCellValue('E'.$baris, $value->stok_tanggal);
                $sheet->setCellValue('F'.$baris, $value->stok_jumlah);
                $baris++;
                $no++;
            }
            foreach (range('A', 'F') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            $sheet->setTitle('Data Stok'); 
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = 'Data Stok '.date('Y-m-d H:i:s').'.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');
            $writer->save('php://output');
            exit;
    } 
    public function export_pdf()
    {
        $stok = StokModel::select('stok_id', 'barang_id','supplier_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with('barang', 'user', 'supplier')
            ->get();

        $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stok]);
        $pdf->setPaper ('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream ('Data Stok '.date('Y-m-d H:i:s').'.pdf');
    }
    public function show_ajax(string $stok_id)
    {
        $stok = StokModel::find($stok_id);
        return view('stok.show_ajax', ['stok' => $stok]);
    }
}
