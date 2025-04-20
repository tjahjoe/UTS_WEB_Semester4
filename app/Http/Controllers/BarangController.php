<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        // Menyiapkan breadcrumb (jalur navigasi) untuk halaman barang
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',  // Judul halaman
            'list' => ['Home', 'Barang'] // Jalur navigasi dari Home ke Daftar Barang
        ];

        // Menyiapkan data untuk halaman seperti judul halaman
        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem' // Judul halaman yang akan ditampilkan
        ];

        // Menandakan menu yang aktif, di sini 'barang' adalah menu yang aktif
        $activeMenu = 'barang';

        // Mengembalikan tampilan (view) 'barang.index' dengan data breadcrumb, page, dan activeMenu
        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Mengambil data barang dari model BarangModel
        $query = BarangModel::get();

        // Jika parameter id_barang ada dalam request, tambahkan filter pada query
        if ($request->id_barang) {
            $query->where('id_barang', $request->id_barang);
        }

        // Menampilkan data dalam format DataTables
        return DataTables::of($query)
            ->addIndexColumn() // Menambahkan kolom index otomatis (nomor urut)
            ->addColumn('aksi', function ($barang) {
                // Menambahkan tombol aksi untuk setiap barang
                $btn = '<button onclick="modalAction(\'' . url('/admin/barang/' . $barang->id_barang . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/barang/' . $barang->id_barang . '/edit_data') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/barang/' . $barang->id_barang . '/hapus_data') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn; // Mengembalikan tombol aksi
            })
            ->rawColumns(['aksi']) // Menandai kolom 'aksi' sebagai kolom yang berisi HTML mentah
            ->make(true); // Menghasilkan respons dalam format DataTables JSON
    }

    public function get_tambah_data()
    {
        // Mengarahkan pengguna ke halaman tambah data barang
        return view('barang.tambah_data');
    }


    public function post_tambah_data(Request $request)
    {
        // Validasi data yang diterima dari form
        $validated = $request->validate([
            'nama' => 'required|min:2|max:100',    // Nama barang wajib, minimal 2 karakter, maksimal 100 karakter
            'harga' => 'required|numeric|min:0.01', // Harga wajib diisi dan harus angka lebih dari 0
            'stok' => 'required|integer|min:1',    // Stok wajib diisi dan harus integer lebih dari 0
            'deskripsi' => 'nullable|max:255'      // Deskripsi opsional, maksimal 255 karakter
        ]);

        // Menyimpan data barang yang sudah tervalidasi ke database
        BarangModel::create([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'deskripsi' => $validated['deskripsi']
        ]);

        // Mengembalikan response dalam bentuk JSON
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }


    public function get_edit_data(string $id)
    {
        // Mengambil data barang berdasarkan id
        $query = BarangModel::find($id);

        // Mengembalikan view edit dengan membawa data barang yang diambil
        return view('barang.edit_data', ['barang' => $query]);
    }


    public function put_edit_data(Request $request, $id)
    {
        // Mengecek apakah request adalah AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {

            // Menentukan aturan validasi untuk data yang dikirim
            $rules = [
                'nama' => 'required|min:2|max:100',  // Nama barang harus ada, minimal 2 karakter, maksimal 100
                'harga' => 'required|numeric|min:0.01',  // Harga harus ada, bertipe numerik, minimal 0.01
                'stok' => 'required|integer|min:1',  // Stok harus ada, bertipe integer, minimal 1
                'deskripsi' => 'nullable|max:255'  // Deskripsi opsional, maksimal 255 karakter
            ];

            // Melakukan validasi terhadap input request
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal, mengembalikan error dan pesan kesalahan
            if ($validator->fails()) {
                \Log::error('Validator gagal:', $validator->errors()->toArray()); // Mencatat error validasi dalam log
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',  // Pesan kesalahan validasi
                    'msgfield' => $validator->errors()  // Menyertakan pesan kesalahan untuk tiap field
                ]);
            }

            // Mencari barang berdasarkan ID yang diberikan
            $barang = BarangModel::find($id);

            // Jika barang ditemukan, lakukan update data
            if ($barang) {
                // Melakukan pembaruan data barang dengan data yang diberikan melalui request
                $barang->update([
                    'nama' => $request['nama'],  // Memperbarui nama barang
                    'harga' => $request['harga'],  // Memperbarui harga barang
                    'stok' => $request['stok'],  // Memperbarui jumlah stok barang
                    'deskripsi' => $request['deskripsi'],  // Memperbarui deskripsi barang
                ]);

                // Mengembalikan respons JSON jika update berhasil
                return response()->json([
                    'status' => true,  // Status sukses
                    'message' => 'Data berhasil diupdate'  // Pesan sukses
                ]);
            } else {
                // Jika barang tidak ditemukan berdasarkan ID, mengembalikan respons error
                return response()->json([
                    'status' => false,  // Status gagal
                    'message' => 'Data tidak ditemukan'  // Pesan kesalahan jika data tidak ditemukan
                ]);
            }
        }

        // Jika bukan request AJAX atau JSON, redirect ke halaman utama
        return redirect('/');
    }


    public function get_detail_data(string $id)
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Mencari data barang berdasarkan ID
        $query = BarangModel::find($id);

        // Mendapatkan tingkat pengguna (misalnya admin atau user)
        $tingkat = $user->tingkat;

        // Mengembalikan view dengan data barang dan tingkat pengguna
        return view('barang.detail_data', ['barang' => $query, 'tingkat' => $tingkat]);
    }


    public function get_hapus_data(string $id)
    {
        // Mencari data barang berdasarkan ID
        $query = BarangModel::where('id_barang', $id)->first();

        // Mengembalikan view dengan data barang untuk konfirmasi penghapusan
        return view('barang.hapus_data', ['barang' => $query]);
    }


    public function delete_hapus_data(Request $request, $id)
    {
        // Mengecek jika request menggunakan AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Mencari barang berdasarkan ID
            $barang = BarangModel::find($id);

            // Jika barang ditemukan, hapus barang tersebut
            if ($barang) {
                $barang->delete(); // Menghapus data barang dari database

                // Mengembalikan response JSON dengan status sukses
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
        } else {
            // Jika request bukan AJAX atau JSON, mengembalikan response gagal
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        // Redirect ke halaman utama jika bukan request AJAX/JSON
        return redirect('/');
    }
}
