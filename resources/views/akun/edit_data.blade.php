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
                <a href="{{ url('/akun') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/akun/' . $akun->id_akun . '/edit_data') }}" method="POST" id="form-edit">
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
                    <div class="form-group">
                        <label>Tingkat Pengguna</label>
                        <select name="tingkat" id="tingkat" class="form-control" required>
                            <option value="">- Pilih Tingkat -</option>
                            @foreach($option['tingkat'] as $opt)
                                <option {{ ($opt == $akun->tingkat) ? 'selected' : '' }} value="{{ $opt }}">
                                    {{ $opt }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-tingkat" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">- Pilih Status -</option>
                            @foreach($option['status'] as $opt)
                                <option {{ ($opt == $akun->status) ? 'selected' : '' }} value="{{ $opt }}">
                                    {{ $opt }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-status" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input value="{{ $akun->email }}" type="email" name="email" id="email" class="form-control" required>
                        <small id="error-email" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input value="" type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah password</small>
                        <small id="error-password" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input value="{{ $akun->biodata->nama }}" type="text" name="nama" id="nama" class="form-control" required>
                        <small id="error-nama" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Umur</label>
                        <input value="{{ $akun->biodata->umur }}" type="text" name="umur" id="umur" class="form-control" required>
                        <small id="error-umur" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input value="{{ $akun->biodata->alamat }}" type="text" name="alamat" id="alamat" class="form-control" required>
                        <small id="error-alamat" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Gender Pengguna</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="">- Pilih Gender -</option>
                            @foreach($option['gender'] as $opt)
                                <option {{ ($opt == $akun->biodata->gender) ? 'selected' : '' }} value="{{ $opt }}">
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
                    tingkat: { required: true },
                    status: { required: true },
                    email: { required: true, email: true, maxlength: 100 },
                    nama: { required: true, minlength: 2, maxlength: 100 },
                    umur: { required: true, number: true, min: 1, max: 150 },
                    alamat: { required: true, minlength: 5 },
                    gender: { required: true }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            console.log(response.msgfield);
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataAkun.ajax.reload();
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