@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('akun/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('akun/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_akun">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Tingkat</th>
                        <th>Status</th>
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
        var dataAkun;
        $(document).ready(function () {
            dataAkun = $('#table_akun').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('akun/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d){
                        d.id_akun = $('#id_akun').val()
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "akun.email",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "akun.tingkat",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "akun.status",
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
            $('#id_akun').on('change', function(){
                dataAkun.ajax.reload();
            });
        });
    </script>
@endpush