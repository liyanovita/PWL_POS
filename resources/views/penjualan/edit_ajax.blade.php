@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary btn-sm mt-1">
                    <i class="fa fa-file-excel"></i>
                    <span> Export Penjualan</span>
                </a>
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning btn-sm mt-1">
                    <i class="fa fa-file-pdf"></i>
                    <span> Export Penjualan</span>
                </a>
                <button onclick="modalAction('{{ url('penjualan/create_ajax') }}')" class="btn btn-success btn-sm mt-1">
                    <i class="fa fa-plus"></i>
                    <span> Tambah Penjualan (Ajax)</span>
                </button>
            </div>
            
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama User</th>
                        <th>Pembeli</th>
                        <th>Kode Penjualan</th>
                        <th>Tanggal Penjualan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataPenjualan;
        $(document).ready(function() {
            dataPenjualan = $('#table_penjualan').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST"
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "user.nama",
                        className: "",
                        orderable: false,
                        searchable: true
                    }, {
                        data: "pembeli",
                        className: "",
                        orderable: false,
                        searchable: true
                    }, {
                        data: "penjualan_kode",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "penjualan_tanggal",
                        className: "",
                        orderable: true,
                        searchable: false
                    }, {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush