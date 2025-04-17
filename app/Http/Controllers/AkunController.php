<?php

namespace App\Http\Controllers;

use App\Models\AkunModel;
use App\Models\BiodataModel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Akun',
            'list' => ['Home', 'Akun']
        ];

        $page = (object) [
            'title' => 'Daftar Akun yang terdaftar dalam sistem'
        ];

        $activeMenu = 'akun';

        $query = BiodataModel::with('akun:id_akun,email,tingkat,status')->get(['id_akun', 'nama']);
        // $akun = BiodataModel::select('id_akun', 'nama')->with('akun:id_akun,email')->get();

        // return response()->json($akun);

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'akun' => $query, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $query = BiodataModel::with('akun:id_akun,email,tingkat,status')
            ->select(['id_akun', 'nama']);
    
        if ($request->id_akun) {
            $query->where('id_akun', $request->id_akun);
        }
    
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($akun) {
                $btn = '<button onclick="modalAction(\'' . url('/akun/' . $akun->id_akun . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/akun/' . $akun->id_akun . '/edit_data') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/akun/' . $akun->id_akun . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    

//     public function create()
//     {
//         $breadcrumb = (object) [
//             'title' => 'Tambah User',
//             'list' => ['Home', 'User', 'Tambah']
//         ];

//         $page = (object) [
//             'title' => 'Tambah User Baru'
//         ];

//         $level = LevelModel::all();
//         $activeMenu = 'user';

//         return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);

//     }

    public function get_tambah_data()
    {
        $option = [
            'tingkat' => ['admin', 'user'],
            'gender' => ['L', 'P'],
        ];
        // return response()->json($option);

        return view('user.tambah_data')->with('option', $option);   
    }

    public function post_tambah_data(Request $request){

        $validated = $request->validate([
            'email' => 'required|email|max:100|unique:akun,email',
            'password' => 'required|min:6|max:255',
            'tingkat' => 'required|in:admin,user',
            'nama' => 'required|max:100',
            'umur' => 'required|integer|min:1|max:150',
            'alamat' => 'required',
            'gender' => 'required|in:L,P',
        ]);
    
        $akun = AkunModel::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tingkat' => $validated['tingkat'],
            'status' => 'aktif',
        ]);

        BiodataModel::create([
            'id_akun' => $akun->id_akun,
            'nama' => $validated['nama'],
            'umur' => $validated['umur'],
            'alamat' => $validated['alamat'],
            'gender' => $validated['gender'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan'
        ]);
    }

    public function get_edit_data(string $id)
    {
        $query = BiodataModel::with('akun:id_akun,email,tingkat,status')
        ->select('id_akun', 'nama', 'umur', 'alamat', 'gender')
        ->where('id_akun', $id)
        ->first();

        $option = [
            'tingkat' => ['admin', 'user'],
            'status' => ['aktif', 'nonaktif'],
            'gender' => ['L', 'P'],
        ];

        $breadcrumb = (object) [
            'title' => 'Edit Akun',
            'list' => ['Home', 'Akun', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Akun'
        ];

        $activeMenu = 'akun';
        return view('user.edit_data', ['breadcrumb' => $breadcrumb, 'page' => $page, 'akun' => $query, 'option' => $option, 'activeMenu' => $activeMenu]);
    }

    public function put_edit_data(Request $request, $id){
        $validated = $request->validate([
            'email' => 'required|email|max:100|unique:akun,email',
            'password' => 'required|min:6|max:255',
            'tingkat' => 'required|in:admin,user',
            'nama' => 'required|max:100',
            'umur' => 'required|integer|min:1|max:150',
            'alamat' => 'required',
            'gender' => 'required|in:L,P',
        ]);

        $akun = AkunModel::find($id)->update([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tingkat' => $validated['tingkat'],
            'status' => 'aktif',
        ]);

        BiodataModel::where('id_akun', $id)->update([
            'id_akun' => $akun->id_akun,
            'nama' => $validated['nama'],
            'umur' => $validated['umur'],
            'alamat' => $validated['alamat'],
            'gender' => $validated['gender'],
        ]);
        
        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan'
        ]);
    }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'username' => 'required|string|min:3|unique:m_user,username',
//             'nama' => 'required|string|max:100',
//             'password' => 'required|min:5',
//             'level_id' => 'required|integer'
//         ]);

//         UserModel::create([
//             'username' => $request->username,
//             'nama' => $request->nama,
//             'password' => bcrypt($request->password),
//             'level_id' => $request->level_id
//         ]);

//         return redirect('/user')->with('success', 'Data user berhasil disimpan');
//     }

//     public function store_ajax(Request $request)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'username' => 'required|string|min:3|unique:m_user,username',
//                 'nama' => 'required|string|max:100',
//                 'password' => 'required|min:5',
//                 'level_id' => 'required|integer'
//             ];

//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validasi Gagal',
//                     'msgField' => $validator->errors()
//                 ]);
//             }

//             UserModel::create($request->all());
//             return response()->json([
//                 'status' => true,
//                 'message' => 'Data user berhasil disimpan'
//             ]);
//         }
//         redirect('/');
//     }
//     public function show(string $id)
//     {
//         $user = UserModel::with('level')->find($id);

//         $breadcrumb = (object) [
//             'title' => 'Detail User',
//             'list' => ['Home', 'User', 'Detail']
//         ];

//         $page = (object) [
//             'title' => 'Detail user'
//         ];

//         $activeMenu = 'user';

//         return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
//     }

    // public function edit(string $id)
    // {
    //     $user = UserModel::find($id);
    //     $level = LevelModel::all();

    //     $breadcrumb = (object) [
    //         'title' => 'Edit User',
    //         'list' => ['Home', 'User', 'Edit']
    //     ];

    //     $page = (object) [
    //         'title' => 'Edit user'
    //     ];

    //     $activeMenu = 'user';
    //     return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    // }

    // public function edit_ajax(string $id)
    // {
    //     $user = UserModel::find($id);
    //     $level = LevelModel::select('level_id', 'level_nama')->get();

    //     return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    // }

//     public function update(Request $request, string $id)
//     {
//         $request->validate([
//             'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
//             'nama' => 'required|string|max:100',
//             'password' => 'nullable|min:5',
//             'level_id' => 'required|integer'
//         ]);

//         UserModel::find($id)->update([
//             'username' => $request->username,
//             'nama' => $request->nama,
//             'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
//             'level_id' => $request->level_id
//         ]);

//         return redirect('/user')->with('success', 'Data user berhasil diubah');
//     }

//     public function update_ajax(Request $request, $id)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'level_id' => 'required|integer',
//                 'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
//                 'nama' => 'required|max:100',
//                 'password' => 'nullable|min:6|max:20'
//             ];

//             $validator = Validator::make($request->all(), $rules);
//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validaso gagal',
//                     'msgfield' => $validator->errors()
//                 ]);
//             }
//             $check = UserModel::find($id);
//             if ($check) {
//                 if (!$request->filled('password')) {

//                     $request->request->remove('password');
//                 }
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
    public function get_detail_data(string $id){
        $query = BiodataModel::with('akun:id_akun,email,tingkat,status')
        ->select('id_akun', 'nama', 'umur', 'alamat', 'gender')
        ->where('id_akun', $id)
        ->first();

        $activeMenu = 'akun';
        return view('user.detail_data', ['akun' => $query, 'activeMenu' => $activeMenu]);
    }   

    // public function confirm_ajax(string $id){
    //     $akun = AkunModel::find($id);
    //     return view('user.show', ['akun' => $akun]);
    // }

//     public function delete_ajax(Request $request, $id){
//         if ($request->ajax() || $request->wantsJson()) {
//             $user = UserModel::find($id);
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
//         $check = UserModel::find($id);
//         if (!$check) {
//             return redirect('/user')->with('error', 'Data user tidak ditemukan');
//         }

//         try {
//             UserModel::destroy($id);
//             return redirect('/user')->with('success', 'Data user berhasil dihapus');
//         } catch (\Illuminate\Database\QueryException $e) {
//             return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
//         }
//     }

//     public function tambah()
//     {
//         return view('user_tambah');
//     }

//     public function tambah_simpan(Request $request)
//     {
//         UserModel::create([
//             'username' => $request->username,
//             'nama' => $request->nama,
//             'password' => Hash::make($request->password),
//             'level_id' => $request->level_id
//         ]);

//         return redirect('user');
//     }

//     public function ubah($id)
//     {
//         $user = UserModel::find($id);
//         return view('user_ubah', ['data' => $user]);
//     }

//     public function ubah_simpan($id, Request $request)
//     {
//         $user = UserModel::find($id);
//         $user->username = $request->username;
//         $user->nama = $request->nama;
//         $user->password = Hash::make($request->password);
//         $user->level_id = $request->level_id;
//         var_dump($user);
//         $user->save();
//         return redirect(url('http://localhost/PWL_2G_30/PWL_POS/public/user'));
//     }

//     public function hapus($id)
//     {
//         $user = UserModel::find($id);
//         $user->delete();

//         return redirect(url('http://localhost/PWL_2G_30/PWL_POS/public/user'));
//     }
}
