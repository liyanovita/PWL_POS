<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $activeMenu = 'barang';
        $breadcrumb = (object) [
            'title' => 'Data Barang',
            'list' => ['Home', 'Barang']
        ];

        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'kategori' => $kategori
        ]);
    }

    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
            ->with('kategori');

        $kategori_id = $request->input('filter_kategori');
        if (!empty($kategori_id)) {
            $barang->where('kategori_id', $kategori_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax')->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'],
                'barang_kode' => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode'],
                'barang_nama' => ['required', 'string', 'max:100'],
                'harga_beli' => ['required', 'numeric'],
                'harga_jual' => ['required', 'numeric'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            BarangModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

      // Show category details via AJAX
      public function show_ajax(string $id)
      {
          $barang = BarangModel::find($id);
          return view('barang.show_ajax', ['barang' => $barang]);
      }

      public function edit_ajax($id)
      {
          $barang = BarangModel::find($id);
          if (!$barang) {
              // Jika barang tidak ditemukan
              return response()->json([
                  'status' => false,
                  'message' => 'Data barang tidak ditemukan.'
              ]);
          }
          $kategori = KategoriModel::all();
          return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
      }
      
      
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'],
                'barang_kode' => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode,' . $id . ',barang_id'],
                'barang_nama' => ['required', 'string', 'max:100'],
                'harga_beli' => ['required', 'numeric'],
                'harga_jual' => ['required', 'numeric'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->update($request->all());
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

    public function confirm_ajax($id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
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
        return view('barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024'] // validasi file harus xlsx dan max 1MB
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang'); // ambil file dari request

            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif

            $data = $sheet->toArray(null, false, true, true); // ambil data excel

            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'kategori_id' => $value['A'],
                            'barang_kode' => $value['B'],
                            'barang_nama' => $value['C'],
                            'harga_beli' => $value['D'],
                            'harga_jual' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }
            }

            if (count($insert) > 0) {
                BarangModel::insertOrIgnore($insert); // insert data ke database
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimport'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }
    }
    public function export_excel()
{
    // Ambil data barang yang akan di-export
    $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
        ->orderBy('kategori_id')
        ->with('kategori') // untuk mengambil data kategori
        ->get();

    // Load library Excel
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif

    // Set header di baris pertama
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode Barang');
    $sheet->setCellValue('C1', 'Nama Barang');
    $sheet->setCellValue('D1', 'Harga Beli');
    $sheet->setCellValue('E1', 'Harga Jual');
    $sheet->setCellValue('F1', 'Kategori');

    // Membuat teks header menjadi bold
    $sheet->getStyle('A1:F1')->getFont()->setBold(true);

    $no = 1; // Nomor data dimulai dari 1
    $baris = 2; // Baris data dimulai dari baris ke-2, karena baris pertama untuk header

    foreach ($barang as $key => $value) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $value->barang_kode);
        $sheet->setCellValue('C' . $baris, $value->barang_nama);
        $sheet->setCellValue('D' . $baris, $value->harga_beli);
        $sheet->setCellValue('E' . $baris, $value->harga_jual);
        $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama); // Ambil nama kategori dari relasi kategori

        // Pindah ke baris selanjutnya
        $baris++;
        // Tambahkan nomor urut
        $no++;
    }

    // Set auto size untuk setiap kolom dari A hingga F
    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Set judul sheet
    $sheet->setTitle('Data Barang');

    // Membuat writer dengan format Xlsx
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

    // Nama file yang akan didownload
    $filename = 'Data Barang ' . date('Y-m-d H:i:s') . '.xlsx';

    // Header untuk response file Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0'); // Tidak ada cache untuk file yang di-download
    header('Cache-Control: max-age=1'); // Mendukung IE over SSL
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Tanggal kedaluwarsa yang lalu
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // Terakhir diubah sekarang
    header('Cache-Control: cache, must-revalidate'); // Harus menggunakan cache browser
    header('Pragma: public'); // Digunakan untuk kompatibilitas HTTP/1.0

    // Simpan file dan kirimkan ke output (download)
    $writer->save('php://output');
    exit; // Menghentikan eksekusi setelah file dikirimkan
    // end function export_excel
}

public function export_pdf()
{
    // Ambil data barang yang akan diexport
    $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
        ->orderBy('kategori_id')
        ->orderBy('barang_kode')
        ->with('kategori') // Mengambil relasi kategori
        ->get();

    // Menggunakan Barryvdh\DomPDF\Facade\Pdf untuk mengenerate PDF
    $pdf = Pdf::loadView('barang.export_pdf', ['barang' => $barang]);
    // Set ukuran kertas dan orientasi (portrait atau landscape)
    $pdf->setPaper('a4', 'portrait');
    // Jika PDF menampilkan gambar yang diambil dari URL, aktifkan opsi ini
    $pdf->setOption('isRemoteEnabled', true);
    // Render PDF
    $pdf->render();

    // Return dan tampilkan PDF melalui stream, dengan nama file dinamis
    return $pdf->stream('Data Barang ' . date('Y-m-d H:i:s') . '.pdf');
}


     }
        
