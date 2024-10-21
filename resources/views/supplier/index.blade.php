@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('supplier/create') }}">Tambah</a> --}}
            <button onclick="modalAction('{{ url('/supplier/import') }}')" class="btn btn-info">Import Supplier</button>
            <a href="{{ url('/supplier/export_excel') }}" class="btn btn-primary"><i class="fa fa-file- excel"></i> Export Supplier</a>
            <a href="{{ url('/supplier/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file- pdf"></i> Export Supplier (PDF)</a>
            <button onclick="modalAction('{{ url('supplier/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Data (Ajax)</button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Alamat Supplier</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
function modalAction(url = ''){
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
};

var dataSupplier;
$(document).ready(function() {
    dataSupplier = $('#table_supplier').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('supplier/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function (d) {
                d.filter_name = $('#filter_name').val();
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "supplier_kode",
                orderable: true,
                searchable: true
            },
            {
                data: "supplier_nama",
                orderable: true,
                searchable: true
            },
            {
                data: "supplier_alamat",
                orderable: true,
                searchable: true
            },
            {
                data: "aksi",
                orderable: false,
                searchable: false
            }
        ]
    });

    $('#filter_name').on('keyup change', function() {
        dataSupplier.ajax.reload();
    });
});
</script>
@endpush