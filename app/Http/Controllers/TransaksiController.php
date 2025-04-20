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
        $query = BarangModel::get();
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';

        return view('transaksi.index', ['breadcrumb' => $breadcrumb, 'barang' => $query, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function beli(Request $request)
    {
        $user = Auth::user();

        $pembelian = PembelianModel::create([
            'id_akun' => $user->id_akun,
            'status' => 'menunggu',
            'total' => 0,
            'tanggal_pembelian' => now()
        ]);

        $total = 0;

        for ($i = 0; $i < count($request->jumlah); $i++) {
            $jumlah = $request->jumlah[$i];

            if ($jumlah == 0 || $jumlah == null)
                continue;

            $id_barang = $request->id_barang[$i];
            $harga = intval($request->harga[$i]);
            $subtotal = $jumlah * $harga;

            TransaksiModel::create([
                'id_pembelian' => $pembelian->id_pembelian,
                'id_barang' => $id_barang,
                'jumlah_beli' => $jumlah,
                'harga' => $harga,
            ]);

            BarangModel::find($id_barang)->decrement('stok', $jumlah);

            $total += $subtotal;
        }

        if ($total == 0) {
            $pembelian->delete(); 
            return redirect()->back()->with('error', 'Transaksi gagal! Tidak ada item yang dibeli.');
        } else {
            $pembelian->update(['total' => $total]);
            return redirect()->back()->with('success', 'Transaksi berhasil disimpan');
        }
    }
}
