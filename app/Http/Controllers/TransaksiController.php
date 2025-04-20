<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PembelianModel;
use App\Models\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        // Mempersiapkan data untuk penjualan (menampilkan semua barang)
        $query = BarangModel::get();

        // Membuat objek breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        // Membuat objek untuk halaman yang aktif
        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];

        // Menetapkan menu aktif yang sedang dipilih
        $activeMenu = 'barang';

        // Mengembalikan view dengan data yang diperlukan
        return view('transaksi.index', [
            'breadcrumb' => $breadcrumb,
            'barang' => $query,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }


    public function beli(Request $request)
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Membuat entri baru di tabel PembelianModel
        $pembelian = PembelianModel::create([
            'id_akun' => $user->id_akun, // ID akun pengguna yang sedang login
            'status' => 'menunggu',      // Status pembelian sementara adalah 'menunggu'
            'total' => 0,                // Total harga pembelian dimulai dari 0
            'tanggal_pembelian' => now() // Menyimpan tanggal pembelian saat ini
        ]);

        // Variabel untuk menghitung total harga pembelian
        $total = 0;

        // Iterasi melalui setiap item pembelian
        for ($i = 0; $i < count($request->jumlah); $i++) {
            $jumlah = $request->jumlah[$i]; // Jumlah barang yang dibeli

            // Jika jumlah barang yang dibeli adalah 0 atau tidak ada, lewati iterasi
            if ($jumlah == 0 || $jumlah == null)
                continue;

            $id_barang = $request->id_barang[$i]; // ID barang yang dibeli
            $harga = intval($request->harga[$i]); // Harga per barang
            $subtotal = $jumlah * $harga; // Hitung subtotal untuk item ini

            // Menambahkan transaksi baru untuk pembelian barang
            TransaksiModel::create([
                'id_pembelian' => $pembelian->id_pembelian,
                'id_barang' => $id_barang,
                'jumlah_beli' => $jumlah,
                'harga' => $harga,
            ]);

            // Mengurangi stok barang yang dibeli
            BarangModel::find($id_barang)->decrement('stok', $jumlah);

            // Menambahkan subtotal ke total harga pembelian
            $total += $subtotal;
        }

        // Jika tidak ada item yang dibeli, hapus pembelian dan beri pesan error
        if ($total == 0) {
            $pembelian->delete(); // Menghapus pembelian karena tidak ada barang yang dibeli
            return redirect()->back()->with('error', 'Transaksi gagal! Tidak ada item yang dibeli.');
        } else {
            // Jika ada item yang dibeli, update total harga dan simpan transaksi
            $pembelian->update(['total' => $total]);
            return redirect('/user/pembelian')->with('success', 'Transaksi berhasil disimpan');
        }
    }
}
