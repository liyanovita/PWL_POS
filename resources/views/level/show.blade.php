@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @if(!$level)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $level->level_id }}</td>
                </tr>
                <tr>
                    <th>Level Kode</th>
                    <td>{{ $level->level_kode }}</td>
                </tr>
                <tr>
                    <th>Level Nama</th>
                    <td>{{ $level->level_nama }}</td>
                </tr>
            </table>
        @endif
        

@push('css')
@endpush
@push('js')
@endpush