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
                <a href="{{ url('/admin/pembelian') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/admin/pembelian/' . $pembelian->id_pembelian . '/edit_data') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>

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
                                            <td colspan="2" class="text-right"><strong>Total :</strong></td>
                                            <td><strong>{{ $pembelian->total }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <label>Status Pembelian</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">- Pilih Status -</option>
                            @foreach($option['status'] as $opt)
                                <option {{ ($opt == $pembelian->status) ? 'selected' : '' }} value="{{ $opt }}">
                                    {{ $opt }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-tingkat" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <script>$(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    status: { required: true }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataPembelian.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty