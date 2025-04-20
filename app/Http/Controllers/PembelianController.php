<?php

namespace App\Http\Controllers;

use App\Models\PembelianModel;
use App\Models\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class PembelianController extends Controller
{
    public function index()
    {
        // Membuat objek breadcrumb untuk navigasi halaman
        $breadcrumb = (object) [
            'title' => 'Daftar Pembelian',       // Judul breadcrumb
            'list' => ['Home', 'Pembelian']      // Daftar urutan breadcrumb
        ];

        // Menyiapkan objek page untuk judul halaman
        $page = (object) [
            'title' => 'Daftar Pembelian yang terdaftar dalam sistem' // Deskripsi halaman
        ];

        // Menandai menu yang sedang aktif di sidebar/nav
        $activeMenu = 'pembelian';

        // Menampilkan view 'pembelian.index' sambil mengirim data breadcrumb, page, dan activeMenu
        return view('pembelian.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function index_user()
    {
        // Menyiapkan data breadcrumb untuk navigasi di tampilan
        $breadcrumb = (object) [
            'title' => 'Daftar Pembelian',           // Judul yang akan ditampilkan di breadcrumb
            'list' => ['Home', 'Pembelian']          // Daftar urutan breadcrumb (navigasi)
        ];

        // Menyiapkan informasi halaman
        $page = (object) [
            'title' => 'Daftar Pembelian yang terdaftar dalam sistem' // Judul halaman utama
        ];

        // Menentukan menu yang sedang aktif (misalnya untuk highlight di sidebar)
        $activeMenu = 'pembelian';

        // Menampilkan view 'pembelian.index_user' dan mengirim data breadcrumb, page, dan activeMenu ke dalamnya
        return view('pembelian.index_user', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }


    public function list(Request $request)
    {
        // Membuat query data pembelian, termasuk relasi ke akun (hanya ambil id_akun dan email)
        $query = PembelianModel::with('akun:id_akun,email')
            ->select('pembelian.id_akun', 'pembelian.id_pembelian', 'pembelian.status', 'pembelian.total')
            ->orderBy('created_at', 'desc'); // Urutkan berdasarkan waktu pembuatan terbaru

        // Filter jika ada parameter id_pembelian dari request (digunakan untuk pencarian/filtering)
        if ($request->id_pembelian) {
            $query->where('id_pembelian', $request->id_pembelian);
        }

        // Mengembalikan hasil query dalam format DataTables
        return DataTables::of($query)
            ->addIndexColumn() // Tambahkan kolom index (nomor urut otomatis)

            // Tambahkan kolom 'aksi' dengan tombol-tombol Detail, Edit, Hapus
            ->addColumn('aksi', function ($pembelian) {
                // Tombol Detail
                $btn = '<button onclick="modalAction(\'' . url('/admin/pembelian/' . $pembelian->id_pembelian . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';

                // Tombol Edit
                $btn .= '<button onclick="modalAction(\'' . url('/admin/pembelian/' . $pembelian->id_pembelian . '/edit_data') . '\')" class="btn btn-warning btn-sm">Edit</button> ';

                // Tombol Hapus
                $btn .= '<button onclick="modalAction(\'' . url('/admin/pembelian/' . $pembelian->id_pembelian . '/hapus_data') . '\')" class="btn btn-danger btn-sm">Hapus</button>';

                return $btn;
            })

            // Memberitahu DataTables bahwa kolom 'aksi' berisi HTML (bukan teks biasa)
            ->rawColumns(['aksi'])

            // Menghasilkan response JSON untuk digunakan oleh frontend DataTables
            ->make(true);
    }

    public function list_user(Request $request)
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Buat query untuk mengambil data pembelian milik user ini saja
        $query = PembelianModel::with('akun:id_akun,email') // join relasi akun, hanya ambil id dan email
            ->select('id_akun', 'id_pembelian', 'status', 'total') // pilih kolom yang dibutuhkan
            ->where('id_akun', $user->id_akun) // filter berdasarkan id_akun user login
            ->orderBy('created_at', 'desc'); // urutkan dari yang terbaru

        // Jika ada filter berdasarkan id_pembelian dari request, tambahkan ke query
        if ($request->id_pembelian) {
            $query->where('id_pembelian', $request->id_pembelian);
        }

        // Format hasil query untuk DataTables
        return DataTables::of($query)
            ->addIndexColumn() // tambahkan kolom nomor urut otomatis

            // Tambahkan kolom 'aksi' yang berisi tombol Detail
            ->addColumn('aksi', function ($pembelian) {
                $btn = '<button onclick="modalAction(\'' . url('/user/pembelian/' . $pembelian->id_pembelian . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })

            // Izinkan kolom 'aksi' menampilkan HTML
            ->rawColumns(['aksi'])

            // Kembalikan response JSON untuk DataTables
            ->make(true);
    }


    public function get_edit_data(string $id)
    {
        // Ambil data pembelian berdasarkan id, sekaligus relasinya:
        $query = $this->query_get_detail_data($id);

        // Opsi status yang bisa dipilih saat edit
        $option = [
            'status' => ['menunggu', 'diproses', 'selesai', 'gagal']
        ];

        // Tampilkan view edit_data dengan data pembelian & pilihan status
        return view('pembelian.edit_data', [
            'pembelian' => $query,
            'option' => $option
        ]);
    }


    public function put_edit_data(Request $request, $id)
    {
        // Cek apakah request berupa AJAX atau ingin JSON (biasanya dari frontend JS)
        if ($request->ajax() || $request->wantsJson()) {

            // Aturan validasi untuk field 'status'
            $rules = [
                'status' => 'required|in:menunggu,diproses,selesai,gagal', // hanya boleh isi dari daftar ini
            ];

            // Jalankan validasi
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                \Log::error('Validator gagal:', $validator->errors()->toArray()); // Catat ke log untuk debugging

                // Kirim response JSON dengan status gagal dan detail error-nya
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgfield' => $validator->errors()
                ]);
            }

            // Cari data pembelian berdasarkan ID
            $pembelian = PembelianModel::find($id);

            // Jika ditemukan, update data
            if ($pembelian) {
                $pembelian->update([
                    'status' => $request['status'], // update status sesuai request
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                // Jika data tidak ditemukan
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        // Jika request bukan AJAX atau bukan JSON, redirect ke halaman utama
        return redirect('/');
    }


    public function get_detail_data(string $id)
    {
        // Ambil data pembelian berdasarkan id, termasuk relasinya:
        $query = $this->query_get_detail_data($id);

        // Kirim data pembelian ke view detail_data
        return view('pembelian.detail_data', [
            'pembelian' => $query
        ]);
    }


    public function get_hapus_data(string $id)
    {
        // Ambil data pembelian berdasarkan id, sekaligus relasi terkait
        $query = $this->query_get_detail_data($id);

        // Kirim data ke view hapus_data, biasanya untuk konfirmasi sebelum dihapus
        return view('pembelian.hapus_data', [
            'pembelian' => $query
        ]);
    }

    public function delete_hapus_data(Request $request, $id)
    {
        // Cek apakah request berasal dari AJAX atau menginginkan response JSON
        if ($request->ajax() || $request->wantsJson()) {

            // Cari data pembelian berdasarkan ID
            $pembelian = PembelianModel::find($id);

            if ($pembelian) {
                // Hapus semua data transaksi yang terkait dengan pembelian ini
                TransaksiModel::where('id_pembelian', $id)->delete();

                // Hapus data pembelian-nya
                $pembelian->delete();

                // Kembalikan response sukses ke frontend
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
        } else {
            // Jika bukan AJAX atau JSON, kirim response gagal
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        // Jika tidak terpenuhi kondisi, redirect ke halaman utama (fallback)
        return redirect('/');
    }


    private function query_get_detail_data($id){
        $query = PembelianModel::with([
            'akun:id_akun,email',                          // Relasi ke akun (ambil id & email)
            'transaksi:id_pembelian,id_barang,harga,jumlah_beli',      // Relasi ke transaksi (ambil id pembelian, barang & harga)
            'transaksi.barang:id_barang,nama'              // Relasi ke barang dari transaksi (ambil nama barang)
        ])
            ->select('id_akun', 'id_pembelian', 'status', 'total') // Kolom dari tabel pembelian
            ->where('id_pembelian', $id)                           // Filter berdasarkan id pembelian
            ->first();     
            
            return $query;
    }
}