@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('barang/tambah_data') }}')" class="btn btn-sm btn-success mt-1">Tambah Data</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" 
    role="dialog" data-backdrop="static" data-keyboard="false" 
    data-width="75%" aria-hidden="true" ></div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url=''){
            $('#myModal').load(url, function(){
                $('#myModal').modal('show');
            });
        }
        var dataBarang;
        $(document).ready(function () {
            dataBarang = $('#table_barang').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('barang/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d){
                        d.id_bunga = $('#id_bunga').val()
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "harga",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "stok",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "deskripsi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#id_bunga').on('change', function(){
                dataBarang.ajax.reload();
            });
        });
    </script>
@endpush