@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($akun)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $akun->akun->id_akun }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $akun->akun->emai }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $akun->nama }}</td>
                    </tr>
                    <tr>
                        <th>Tingkat</th>
                        <td>{{ $akun->akun->tingkat }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $akun->akun->status }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('akun') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush