@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Detail Profil</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered" id="dataAkun" style="width: 100%">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Data</th>
                </tr>
            </thead>
        </table>

        <div class="mt-3">
            <button onclick="modalAction('{{ url('/edit_profil') }}')" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"></div>
    </div>
</div>

@endsection

@push('js')
<script>
    let dataAkun;

    $(document).ready(function () {
        dataAkun = $('#dataAkun').DataTable({
            ajax: '{{ url( "/list_data_profil") }}',
            columns: [
                { data: 'Field' },
                { data: 'Data' }
            ],
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            responsive: true,
            language: {
                emptyTable: "Tidak ada data tersedia"
            }
        });
    });

    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }
</script>
@endpush
