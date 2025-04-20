<?php

namespace App\Http\Controllers;

use App\Models\AkunModel;
use App\Models\BiodataModel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AkunController extends Controller
{
    public function index()
    {
        // Menyiapkan data breadcrumb untuk navigasi di tampilan
        $breadcrumb = (object) [
            'title' => 'Daftar Akun',              // Judul utama breadcrumb
            'list' => ['Home', 'Akun']             // Jejak navigasi: Home > Akun
        ];

        // Menyiapkan data halaman (judul konten utama)
        $page = (object) [
            'title' => 'Daftar Akun yang terdaftar dalam sistem' // Judul halaman yang ditampilkan di UI
        ];

        // Menandai menu yang sedang aktif di sidebar/nav
        $activeMenu = 'akun';

        // Mengembalikan view 'akun.index' dan mengirimkan semua data ke tampilan
        return view('akun.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }


    public function list(Request $request)
    {
        // Ambil data user yang sedang login, untuk keperluan filter (misal tidak menampilkan akun yang sedang login)
        $user = Auth::user();

        // Query untuk mengambil data akun selain akun yang sedang login
        $query = AkunModel::with('biodata:id_akun,nama')  // Relasi dengan biodata untuk mengambil 'nama'
            ->select('akun.id_akun', 'email', 'tingkat', 'status')  // Pilih kolom yang ingin ditampilkan
            ->where('akun.id_akun', '!=', $user->id_akun);  // Pastikan akun yang sedang login tidak ikut tampil

        // Jika ada parameter 'id_akun' pada request, filter berdasarkan id akun tersebut
        if ($request->id_akun) {
            $query->where('id_akun', $request->id_akun);
        }

        // Menggunakan DataTables untuk mempermudah render data dalam bentuk tabel interaktif
        return DataTables::of($query)
            ->addIndexColumn()  // Menambahkan kolom index untuk urutan
            ->addColumn('aksi', function ($akun) {  // Menambahkan kolom aksi (tombol untuk detail, edit, hapus)
                $btn = '<button onclick="modalAction(\'' . url('/admin/akun/' . $akun->id_akun . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/akun/' . $akun->id_akun . '/edit_data') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/akun/' . $akun->id_akun . '/hapus_data') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;  // Mengembalikan tombol aksi yang telah dibuat
            })
            ->rawColumns(['aksi'])  // Pastikan kolom 'aksi' dapat menerima HTML untuk tombol
            ->make(true);  // Mengembalikan hasil dalam format DataTables
    }


    public function get_profil()
    {
        // Menyiapkan data breadcrumb untuk navigasi di tampilan profil
        $breadcrumb = (object) [
            'title' => 'Profil',              // Judul utama breadcrumb
            'list' => ['Home', 'Profil']      // Jejak navigasi: Home > Profil
        ];

        // Menyiapkan data halaman (judul konten utama)
        $page = (object) [
            'title' => 'Data diri anda'      // Judul halaman yang ditampilkan di UI
        ];

        // Menandai menu yang sedang aktif di sidebar/nav
        $activeMenu = 'profil';

        // Mengembalikan view 'profil.index' dan mengirimkan semua data ke tampilan
        return view('profil.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }


    public function list_data_profil()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Query untuk mengambil data akun dan biodata pengguna berdasarkan akun yang sedang login
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')  // Relasi dengan biodata untuk mendapatkan informasi nama, umur, alamat, dan gender
            ->select('akun.id_akun', 'email', 'tingkat', 'status')  // Memilih kolom yang akan ditampilkan
            ->where('akun.id_akun', $user->id_akun)  // Pastikan hanya data akun yang sesuai dengan id_akun pengguna yang sedang login
            ->first();  // Ambil satu hasil karena hanya untuk pengguna yang sedang login

        // Menyiapkan data dalam format array yang akan dikirim ke frontend
        $data = [
            ['Field' => 'Email', 'Data' => $query->email],  // Menampilkan email pengguna
            ['Field' => 'Tingkat', 'Data' => ucfirst($query->tingkat)],  // Menampilkan tingkat (dengan format kapital pertama)
            ['Field' => 'Status', 'Data' => ucfirst($query->status)],  // Menampilkan status (dengan format kapital pertama)
            ['Field' => 'Nama', 'Data' => $query->biodata->nama ?? '-'],  // Menampilkan nama, jika tidak ada maka tampilkan '-'
            ['Field' => 'Umur', 'Data' => ($query->biodata->umur ?? '-') . ' tahun'],  // Menampilkan umur, jika tidak ada tampilkan '-' dan tambahkan 'tahun'
            ['Field' => 'Alamat', 'Data' => $query->biodata->alamat ?? '-'],  // Menampilkan alamat, jika tidak ada tampilkan '-'
            ['Field' => 'Gender', 'Data' => $query->biodata->gender == 'L' ? 'Laki-laki' : ($query->biodata->gender == 'P' ? 'Perempuan' : '-')],  // Menampilkan gender, jika tidak ada tampilkan '-'
        ];

        // Mengembalikan data dalam format JSON untuk digunakan di frontend
        return response()->json(['data' => $data]);
    }


    public function get_edit_profil()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Query untuk mengambil data akun dan biodata pengguna berdasarkan akun yang sedang login
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')  // Relasi dengan biodata untuk mendapatkan informasi nama, umur, alamat, dan gender
            ->select('akun.id_akun', 'email', 'tingkat', 'status')  // Memilih kolom yang akan ditampilkan dari tabel akun
            ->where('akun.id_akun', $user->id_akun)  // Pastikan hanya data akun yang sesuai dengan id_akun pengguna yang sedang login
            ->first();  // Ambil satu hasil karena hanya untuk pengguna yang sedang login

        // Menyiapkan opsi yang akan ditampilkan di form edit (untuk dropdown atau select)
        $option = [
            'tingkat' => ['admin', 'user'],  // Opsi tingkat pengguna
            'status' => ['aktif', 'nonaktif'],  // Opsi status akun
            'gender' => ['L', 'P'],  // Opsi gender
        ];

        // Mengembalikan tampilan edit_data dengan membawa data akun yang diambil dan opsi yang telah disiapkan
        return view('profil.edit_data', ['akun' => $query, 'option' => $option]);
    }


    public function put_edit_profil(Request $request)
    {
        // Mendapatkan data user yang sedang login
        $user = Auth::user();

        // Mengecek apakah request berupa AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {

            // Mendefinisikan aturan validasi untuk data yang dikirimkan
            $rules = [
                'email' => 'required|email|max:100|unique:akun,email,' . $user->id_akun . ',id_akun',  // Validasi email, harus unik kecuali untuk email user yang sedang login
                'password' => 'nullable|min:6|max:255',  // Password bersifat opsional, jika ada harus memiliki panjang antara 6 dan 255 karakter
                'nama' => 'required|max:100',  // Nama harus diisi dengan panjang maksimal 100 karakter
                'umur' => 'required|integer|min:1|max:150',  // Umur harus integer antara 1 hingga 150 tahun
                'alamat' => 'required',  // Alamat harus diisi
                'gender' => 'required|in:L,P',  // Gender harus L (Laki-laki) atau P (Perempuan)
            ];

            // Melakukan validasi terhadap data yang dikirimkan
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                \Log::error('Validator gagal:', $validator->errors()->toArray()); // Menyimpan error di log
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgfield' => $validator->errors()  // Mengirimkan pesan error ke client
                ]);
            }

            // Mencari akun berdasarkan id_akun user yang sedang login
            $akun = AkunModel::find($user->id_akun);

            // Jika akun ditemukan, lakukan update
            if ($akun) {

                // Jika password diubah, update password akun
                if ($request->filled('password')) {
                    $plainPassword = $request->input('password');  // Mengambil password dari input
                    $request->request->remove('password');  // Menghapus password dari data request agar tidak disertakan lagi
                    $akun->update([
                        'password' => Hash::make($plainPassword),  // Meng-hash password dan menyimpannya
                    ]);
                }

                // Mengupdate email akun
                $akun->update([
                    'email' => $request['email'],
                ]);

                // Mengupdate data biodata (nama, umur, alamat, gender)
                BiodataModel::where('id_akun', $user->id_akun)->update([
                    'id_akun' => $akun->id_akun,  // Pastikan id_akun tetap konsisten
                    'nama' => $request['nama'],
                    'umur' => $request['umur'],
                    'alamat' => $request['alamat'],
                    'gender' => $request['gender'],
                ]);

                // Mengirimkan respons sukses jika update berhasil
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                // Jika akun tidak ditemukan, kembalikan respons error
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        // Jika request bukan berupa AJAX atau JSON, arahkan ke halaman utama
        return redirect('/');
    }


    public function get_tambah_data()
    {
        // Menyiapkan pilihan untuk level tingkat pengguna dan jenis kelamin yang akan ditampilkan di form tambah data
        $option = [
            'tingkat' => ['admin', 'user'],  // Pilihan untuk tingkat pengguna, bisa 'admin' atau 'user'
            'gender' => ['L', 'P'],          // Pilihan untuk gender, bisa 'L' (Laki-laki) atau 'P' (Perempuan)
        ];

        // Mengembalikan view 'akun.tambah_data' dengan membawa data 'option' sebagai parameter
        return view('akun.tambah_data')->with('option', $option);
    }

    public function post_tambah_data(Request $request)
    {
        // Melakukan validasi terhadap input yang diterima
        $validated = $request->validate([
            'email' => 'required|email|max:100|unique:akun,email', // Validasi email, harus unik dan sesuai format
            'password' => 'required|min:6|max:255', // Validasi password, minimal 6 karakter
            'tingkat' => 'required|in:admin,user', // Validasi tingkat, harus berupa 'admin' atau 'user'
            'nama' => 'required|max:100', // Validasi nama, maksimal 100 karakter
            'umur' => 'required|integer|min:1|max:150', // Validasi umur, integer antara 1 hingga 150
            'alamat' => 'required', // Validasi alamat, harus diisi
            'gender' => 'required|in:L,P', // Validasi gender, hanya 'L' atau 'P'
        ]);

        // Membuat akun baru di tabel AkunModel
        $akun = AkunModel::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Menyimpan password yang telah di-hash
            'tingkat' => $validated['tingkat'],
            'status' => 'aktif', // Status akun di-set sebagai 'aktif' secara default
        ]);

        // Membuat biodata baru di tabel BiodataModel dengan mengaitkan akun yang baru dibuat
        BiodataModel::create([
            'id_akun' => $akun->id_akun, // ID akun yang baru dibuat
            'nama' => $validated['nama'],
            'umur' => $validated['umur'],
            'alamat' => $validated['alamat'],
            'gender' => $validated['gender'],
        ]);

        // Mengembalikan response JSON yang menginformasikan bahwa data telah berhasil disimpan
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }


    public function get_edit_data(string $id)
    {
        // Mengambil data akun beserta biodatanya berdasarkan ID akun yang diberikan
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')
            ->select('akun.id_akun', 'email', 'tingkat', 'status')  // Memilih kolom yang akan ditampilkan dari tabel akun
            ->where('akun.id_akun', $id)  // Menyaring data akun berdasarkan ID yang diberikan
            ->first();  // Mengambil data akun pertama yang ditemukan

        // Menyediakan opsi untuk tingkat, status, dan gender
        $option = [
            'tingkat' => ['admin', 'user'],  // Opsi tingkat akun
            'status' => ['aktif', 'nonaktif'],  // Opsi status akun
            'gender' => ['L', 'P'],  // Opsi gender (Laki-laki atau Perempuan)
        ];

        // Mengarahkan ke tampilan edit data akun dengan membawa data akun dan opsi untuk level, status, dan gender
        return view('akun.edit_data', ['akun' => $query, 'option' => $option]);
    }


    public function put_edit_data(Request $request, $id)
    {
        // Memastikan bahwa request yang diterima adalah AJAX atau permintaan JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Mendefinisikan aturan validasi untuk input data
            $rules = [
                'email' => 'required|email|max:100|unique:akun,email,' . $id . ',id_akun', // Validasi email harus unik kecuali untuk akun yang sedang diedit
                'password' => 'nullable|min:6|max:255', // Password bersifat opsional, tetapi jika ada, harus lebih dari 6 karakter
                'tingkat' => 'required|in:admin,user', // Validasi tingkat harus salah satu dari admin atau user
                'status' => 'required|in:aktif,nonaktif', // Validasi status akun harus aktif atau nonaktif
                'nama' => 'required|min:2|max:100', // Nama harus diisi dengan panjang minimal 2 karakter
                'umur' => 'required|integer|min:1|max:150', // Umur harus berupa angka antara 1 dan 150
                'alamat' => 'required', // Alamat harus diisi
                'gender' => 'required|in:L,P', // Gender harus berupa L (Laki-laki) atau P (Perempuan)
            ];

            // Melakukan validasi terhadap data yang dikirimkan
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                \Log::error('Validator gagal:', $validator->errors()->toArray()); // Mencatat error validasi dalam log
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgfield' => $validator->errors() // Menampilkan error validasi yang terjadi
                ]);
            }

            // Mencari akun yang ingin diupdate berdasarkan ID
            $akun = AkunModel::find($id);
            if ($akun) {
                // Jika password diisi, lakukan hash pada password dan update
                if ($request->filled('password')) {
                    $plainPassword = $request->input('password');
                    $request->request->remove('password'); // Menghapus password agar tidak ikut dalam update akun
                    $akun->update([
                        'password' => Hash::make($plainPassword), // Mengupdate password yang di-hash
                    ]);
                }
                // Update data akun
                $akun->update([
                    'email' => $request['email'],
                    'tingkat' => $request['tingkat'],
                    'status' => $request['status'],
                ]);

                // Update data biodata yang terkait dengan akun
                BiodataModel::where('id_akun', $id)->update([
                    'id_akun' => $akun->id_akun,
                    'nama' => $request['nama'],
                    'umur' => $request['umur'],
                    'alamat' => $request['alamat'],
                    'gender' => $request['gender'],
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate' // Mengembalikan respons sukses
                ]);
            } else {
                // Jika akun tidak ditemukan
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/'); // Jika bukan request AJAX, redirect ke halaman utama
    }



    public function get_detail_data(string $id)
    {
        // Menampilkan data yang diambil dari database
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender') // Mengambil data akun dan biodata terkait
            ->select('akun.id_akun', 'email', 'tingkat', 'status') // Mengambil kolom id_akun, email, tingkat, dan status dari tabel akun
            ->where('akun.id_akun', $id) // Menyaring data berdasarkan id_akun yang diterima sebagai parameter
            ->first(); // Mengambil hanya satu baris data (karena ID unik)

        // Mengirimkan data ke view 'akun.detail_data'
        return view('akun.detail_data', ['akun' => $query]);
    }


    public function get_hapus_data(string $id)
    {
        // Menampilkan data dari database yang digunakan untuk konfirmasi penghapusan data
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender') // Mengambil data akun dan biodata terkait
            ->select('akun.id_akun', 'email', 'tingkat', 'status') // Mengambil kolom id_akun, email, tingkat, dan status dari tabel akun
            ->where('akun.id_akun', $id) // Menyaring data berdasarkan id_akun yang diterima sebagai parameter
            ->first(); // Mengambil hanya satu baris data (karena ID unik)

        // Mengirimkan data ke view 'akun.hapus_data' untuk konfirmasi penghapusan
        return view('akun.hapus_data', ['akun' => $query]);
    }


    public function delete_hapus_data(Request $request, $id)
    {
        // Menghapus data
        if ($request->ajax() || $request->wantsJson()) {
            // Mencari akun berdasarkan id_akun
            $akun = AkunModel::find($id);
            if ($akun) {
                // Menghapus data biodata yang terkait dengan akun tersebut
                BiodataModel::where('id_akun', $id)->delete();

                // Menghapus data akun
                $akun->delete();

                // Mengembalikan response JSON sukses
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
        } else {
            // Jika akun tidak ditemukan
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        // Mengarahkan ke halaman utama jika bukan request AJAX
        return redirect('/');
    }
}