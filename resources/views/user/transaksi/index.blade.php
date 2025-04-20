@extends('layouts.template')

@section('content')
    <form action="{{ url('/user/tes') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Daftar Bunga</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" id="tabel-bunga">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($barang as $key => $bunga)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $bunga['nama'] }}</td>
                                <td>Rp {{ number_format($bunga['harga'], 0, ',', '.') }}</td>
                                <td>{{ $bunga['stok'] }}</td>
                                <td>
                                    <input type="number" name="jumlah[{{ $key }}]" class="form-control" min="0"
                                        max="{{ $bunga['stok'] }}" value="0">
                                    <input type="hidden" name="id_barang[{{ $key }}]" value="{{ $bunga['id_barang'] }}">
                                    <input type="hidden" name="nama[{{ $key }}]" value="{{ $bunga['nama'] }}">
                                    <input type="hidden" name="harga[{{ $key }}]" value="{{ $bunga['harga'] }}">
                                </td>
                                <td>
                                    <button type="button"
                                        onclick="modalAction('{{ url('/barang/' . $bunga['id_barang'] . '/detail_data') }}')"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-shopping-cart"></i> Beli
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true">
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush
