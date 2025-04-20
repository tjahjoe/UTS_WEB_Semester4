@empty($akun)
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
                <a href="{{ url('/admin/akun') }}" class="btn btn-warning">Kembali</a>
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
                        <th class="text-right col-3">Level Pengguna :</th>
                        <td class="col-9">{{$akun->tingkat }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Status:</th>
                        <td class="col-9">{{$akun->status }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Email :</th>
                        <td class="col-9">{{$akun->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama :</th>
                        <td class="col-9">{{$akun->biodata->nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Umur :</th>
                        <td class="col-9">{{$akun->biodata->umur }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Alamat :</th>
                        <td class="col-9">{{$akun->biodata->alamat }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Gender :</th>
                        <td class="col-9">{{$akun->biodata->gender }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endempty