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
        $breadcrumb = (object) [
            'title' => 'Daftar Pembelian',
            'list' => ['Home', 'Pembelian']
        ];

        $page = (object) [
            'title' => 'Daftar Pembelian yang terdaftar dalam sistem'
        ];

        $activeMenu = 'pembelian';

        return view('pembelian.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function index_user()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Pembelian',
            'list' => ['Home', 'Pembelian']
        ];

        $page = (object) [
            'title' => 'Daftar Pembelian yang terdaftar dalam sistem'
        ];

        $activeMenu = 'pembelian';

        return view('pembelian.index_user', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $query = PembelianModel::with('akun:id_akun,email')
        -> select('pembelian.id_akun','pembelian.id_pembelian', 'pembelian.status', 'pembelian.total');

        if ($request->id_pembelian) {
            $query->where('id_pembelian', $request->id_pembelian);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pembelian) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/pembelian/' . $pembelian->id_pembelian . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/pembelian/' . $pembelian->id_pembelian . '/edit_data') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/pembelian/' . $pembelian->id_pembelian . '/hapus_data') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function list_user(Request $request)
    {
        $user = Auth::user();
        $query = PembelianModel::with('akun:id_akun,email')
        -> select('id_akun','id_pembelian', 'status', 'total')
        -> where('id_akun', $user->id_akun);

        if ($request->id_pembelian) {
            $query->where('id_pembelian', $request->id_pembelian);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pembelian) {
                $btn = '<button onclick="modalAction(\'' . url('/user/pembelian/' . $pembelian->id_pembelian . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_edit_data(string $id)
    {
        $query = PembelianModel::with(['akun:id_akun,email','transaksi:id_pembelian,id_barang,harga', 'transaksi.barang:id_barang,nama'])
        ->select('id_akun','id_pembelian', 'status', 'total')
        ->where('id_pembelian', $id)
        ->first();

        $option = [
            'status' => ['menunggu', 'diproses', 'selesai', 'gagal']
        ];

        return view('pembelian.edit_data', ['pembelian' => $query, 'option' => $option]);
    }

    public function put_edit_data(Request $request, $id)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'status' => 'required|in:menunggu,diproses,selesai,gagal',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                \Log::error('Validator gagal:', $validator->errors()->toArray()); // Logging error
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgfield' => $validator->errors()
                ]);
            }

            $pembelian = PembelianModel::find($id);
            if ($pembelian) {
                $pembelian->update([
                    'status' => $request['status'],
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function get_detail_data(string $id)
    {
        $query = PembelianModel::with(['akun:id_akun,email','transaksi:id_pembelian,id_barang,harga', 'transaksi.barang:id_barang,nama'])
        ->select('id_akun','id_pembelian', 'status', 'total')
        ->where('id_pembelian', $id)
        ->first();

        return view('pembelian.detail_data', ['pembelian' => $query]);
    }

    public function get_hapus_data(string $id)
    {
        $query = PembelianModel::with(['akun:id_akun,email','transaksi:id_pembelian,id_barang,harga', 'transaksi.barang:id_barang,nama'])
        ->select('id_akun','id_pembelian', 'status', 'total')
        ->where('id_pembelian', $id)
        ->first();

        return view('pembelian.hapus_data', ['pembelian' => $query]);
    }

        public function delete_hapus_data(Request $request, $id){
        if ($request->ajax() || $request->wantsJson()) {
            $pembelian = PembelianModel::find($id);
            if ($pembelian) {
                TransaksiModel::where('id_pembelian', $id)->delete();
                $pembelian->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }
}
