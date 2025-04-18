@empty($barang)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>

                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>

                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">ID:</th>
                        <td class="col-9">{{$barang->id_bunga }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama:</th>
                        <td class="col-9">{{$barang->nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Harga:</th>
                        <td class="col-9">{{$barang->harga }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Stok:</th>
                        <td class="col-9">{{$barang->stok }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Deskripsi:</th>
                        <td class="col-9">{{$barang->deskripsi }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endempty