<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';


        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

//     public function list(Request $request)
//     {
//         $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual');



//         return DataTables::of($barangs)
//             ->addIndexColumn()
//             ->addColumn('aksi', function ($barang) {

//                 //                 $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    
//                 //                 $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    
//                 //                 $btn .= '<form class="d-inline-block" method="POST" action="' .
    
//                 //                     url('/barang/' . $barang->barang_id) . '">'
    
//                 //                     . csrf_field() . method_field('DELETE') .
// //                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return
    
//                 // confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
//                 $btn = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .

//                     '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';

//                 $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .

//                     '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';

//                 $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .

//                     '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

//                 return $btn;
//             })
//             ->rawColumns(['aksi'])
//             ->make(true);
//     }


//     public function create()
//     {
//         $breadcrumb = (object) [
//             'title' => 'Tambah Barang',
//             'list' => ['Home', 'Barang', 'Tambah']
//         ];

//         $page = (object) [
//             'title' => 'Tambah barang Baru'
//         ];

//         $kategori = KategoriModel::all();
//         $activeMenu = 'barang';

//         return view('barang.create', ['breadcrumb' => $breadcrumb, 'kategori' => $kategori, 'page' => $page, 'activeMenu' => $activeMenu]);

//     }

//     public function create_ajax()
//     {
//         $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

//         return view('barang.create_ajax')->with('kategori', $kategori);
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
//             'barang_nama' => 'required|string|max:100',
//             'harga_beli' => 'required|integer',
//             'harga_jual' => 'required|integer',
//             'kategori_id' => 'required|integer'
//         ]);

//         BarangModel::create([
//             'barang_kode' => $request->barang_kode,
//             'barang_nama' => $request->barang_nama,
//             'harga_beli' => $request->harga_beli,
//             'harga_jual' => $request->harga_jual,
//             'kategori_id' => $request->kategori_id
//         ]);

//         return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
//     }

//     public function store_ajax(Request $request)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
//                 'barang_nama' => 'required|string|max:100',
//                 'harga_beli' => 'required|integer',
//                 'harga_jual' => 'required|integer',
//                 'kategori_id' => 'required|integer'
//             ];

//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validasi Gagal',
//                     'msgField' => $validator->errors()
//                 ]);
//             }

//             BarangModel::create($request->all());
//             return response()->json([
//                 'status' => true,
//                 'message' => 'Data barang berhasil disimpan'
//             ]);
//         }
//         redirect('/');
//     }

//     public function show(string $id)
//     {
//         $barang = BarangModel::with('kategori')->find($id);
//         // return response()->json($barang);
//         $breadcrumb = (object) [
//             'title' => 'Detail Barang',
//             'list' => ['Home', 'Barang', 'Detail']
//         ];

//         $page = (object) [
//             'title' => 'Detail barang'
//         ];

//         $activeMenu = 'barang';

//         return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
//     }

//     public function edit(string $id)
//     {
//         $barang = BarangModel::find($id);
//         $kategori = KategoriModel::all();

//         $breadcrumb = (object) [
//             'title' => 'Edit Barang',
//             'list' => ['Home', 'Barang', 'Edit']
//         ];

//         $page = (object) [
//             'title' => 'Edit barang'
//         ];

//         $activeMenu = 'barang';
//         return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
//     }

//     public function edit_ajax(string $id)
//     {
//         $barang = BarangModel::find($id);
//         $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

//         return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
//     }

//     public function update(Request $request, string $id)
//     {
//         $request->validate([
//             'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
//             'barang_nama' => 'required|string|max:100',
//             'harga_beli' => 'required|integer',
//             'harga_jual' => 'required|integer',
//             'kategori_id' => 'required|integer'
//         ]);

//         BarangModel::find($id)->update([
//             'barang_kode' => $request->barang_kode,
//             'barang_nama' => $request->barang_nama,
//             'harga_beli' => $request->harga_beli,
//             'harga_jual' => $request->harga_jual,
//             'kategori_id' => $request->kategori_id
//         ]);

//         return redirect('/barang')->with('success', 'Data Barang berhasil diubah');
//     }

//     public function update_ajax(Request $request, $id)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
//                 'barang_nama' => 'required|string|max:100',
//                 'harga_beli' => 'required|integer',
//                 'harga_jual' => 'required|integer',
//                 'kategori_id' => 'required|integer'
//             ];

//             $validator = Validator::make($request->all(), $rules);
//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validaso gagal',
//                     'msgfield' => $validator->errors()
//                 ]);
//             }
//             $check = BarangModel::find($id);
//             if ($check) {
//                 $check->update($request->all());
//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data berhasil diupdate'
//                 ]);
//             } else {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Data tidak ditemukan'
//                 ]);
//             }
//         }
//         return redirect('/');
//     }

//     public function confirm_ajax(string $id){
//         $barang = BarangModel::find($id);

//         return view('barang.confirm_ajax', ['barang' => $barang]);
//     }

//     public function delete_ajax(Request $request, $id){
//         if ($request->ajax() || $request->wantsJson()) {
//             $user = BarangModel::find($id);
//             if ($user) {
//                 $user->delete();
//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data berhasil dihapus'
//                 ]);
//             }
//         } else {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Data tidak ditemukan'
//             ]);
//         }
//         return redirect('/');
//     }
//     public function destroy(string $id)
//     {
//         $check = BarangModel::find($id);
//         if (!$check) {
//             return redirect('/barang')->with('error', 'Data Barang tidak ditemukan');
//         }

//         try {
//             BarangModel::destroy($id);
//             return redirect('/barang')->with('success', 'Data Barang berhasil dihapus');
//         } catch (\Illuminate\Database\QueryException $e) {
//             return redirect('/barang')->with('error', 'Data Barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
//         }
//     }

}
