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
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $query = BarangModel::get();

        if ($request->id_barang) {
            $query->where('id_barang', $request->id_barang);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/barang/' . $barang->id_barang . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/barang/' . $barang->id_barang . '/edit_data') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/barang/' . $barang->id_barang . '/hapus_data') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function get_tambah_data()
    {
        return view('barang.tambah_data');
    }

    public function post_tambah_data(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'required|min:2|max:100', 
            'harga' => 'required|numeric|min:0.01',  
            'stok' => 'required|integer|min:1',  
            'deskripsi' => 'nullable|max:255'
        ]);

        BarangModel::create([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'deskripsi' => $validated['deskripsi']
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function get_edit_data(string $id)
    {
        $query = BarangModel::find($id);

        return view('barang.edit_data', ['barang' => $query]);
    }

    public function put_edit_data(Request $request, $id)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama' => 'required|min:2|max:100', 
            'harga' => 'required|numeric|min:0.01',  
            'stok' => 'required|integer|min:1',  
            'deskripsi' => 'nullable|max:255'
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

            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->update([
                    'nama' => $request['nama'],
                    'harga' => $request['harga'],
                    'stok' => $request['stok'],
                    'deskripsi' => $request['deskripsi'],
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
        $user = Auth::user();
        $query = BarangModel::find($id);
        $tingkat = $user->tingkat;

        return view('barang.detail_data', ['barang' => $query, 'tingkat' => $tingkat]);
    }

    public function get_hapus_data(string $id)
    {
        $query = BarangModel::where('id_barang', $id)->first();

        return view('barang.hapus_data', ['barang' => $query]);
    }

        public function delete_hapus_data(Request $request, $id){
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
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
