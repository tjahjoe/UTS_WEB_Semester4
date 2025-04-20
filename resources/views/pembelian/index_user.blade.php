@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-body">
            <!-- @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif -->
            <table class="table table-bordered table-striped table-hover table-sm" id="table_pembelian">
                <thead>
                    <tr>
                        <th>ID Pembelian</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Total</th>
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
        var dataPembelian;
        $(document).ready(function () {
            dataPembelian = $('#table_pembelian').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('/user/pembelian/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d){
                        d.id_pembelian = $('#id_pembelian').val()
                    }
                },
                columns: [
                    {
                        data: "id_pembelian",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "akun.email",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "status",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "total",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#id_pembelian').on('change', function(){
                dataPembelian.ajax.reload();
            });
            @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
            @endif
        });
    </script>
@endpush