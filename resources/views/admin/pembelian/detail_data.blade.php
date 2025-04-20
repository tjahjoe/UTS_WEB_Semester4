@empty($pembelian)
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
                <a href="{{ url('/pembelian') }}" class="btn btn-warning">Kembali</a>
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
                        <th class="text-right col-3">ID Pembelian :</th>
                        <td class="col-9">{{ $pembelian->id_pembelian }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Status :</th>
                        <td class="col-9">{{ $pembelian->status }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Email :</th>
                        <td class="col-9">{{ $pembelian->akun->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3 align-top" rowspan="{{ count($pembelian->transaksi) + 2 }}">Barang :
                        </th>
                        <td class="col-9 p-0">
                            <table class="table table-sm table-bordered table-striped">
                                <thead style="background-color: silver;">
                                    <tr>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelian->transaksi as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->id_barang }}</td>
                                            <td>{{ $transaksi->barang->nama ?? '-' }}</td>
                                            <td>{{ $transaksi->jumlah_beli }}</td>
                                            <td>{{ $transaksi->harga }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total :</strong></td>
                                        <td><strong>{{ $pembelian->total }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endempty