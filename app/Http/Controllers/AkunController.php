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
        $breadcrumb = (object) [
            'title' => 'Daftar Akun',
            'list' => ['Home', 'Akun']
        ];

        $page = (object) [
            'title' => 'Daftar Akun yang terdaftar dalam sistem'
        ];

        $activeMenu = 'akun';

        return view('akun.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
        // return response()->json(Auth::user()->id_akun);
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $query = AkunModel::with('biodata:id_akun,nama')
            ->select('akun.id_akun', 'email', 'tingkat', 'status')
            ->where('akun.id_akun', '!=', $user->id_akun);

        if ($request->id_akun) {
            $query->where('id_akun', $request->id_akun);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($akun) {
                $btn = '<button onclick="modalAction(\'' . url('/admin/akun/' . $akun->id_akun . '/detail_data') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/akun/' . $akun->id_akun . '/edit_data') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/akun/' . $akun->id_akun . '/hapus_data') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_profil()
    {
        $user = Auth::user();
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')
            ->select('akun.id_akun', 'email', 'tingkat', 'status')
            ->where('akun.id_akun', $user->id_akun)
            ->first();

        $breadcrumb = (object) [
            'title' => 'Profil',
            'list' => ['Home', 'Profil']
        ];
        $page = (object) [
            'title' => 'Data diri anda'
        ];

        $activeMenu = 'profil';

        return view('profil.index', ['breadcrumb' => $breadcrumb, 'akun' => $query, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list_data_profil($id)
    {
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')
            ->select('akun.id_akun', 'email', 'tingkat', 'status')
            ->where('akun.id_akun', $id)
            ->first();

        $data = [
            ['Field' => 'Email', 'Data' => $query->email],
            ['Field' => 'Tingkat', 'Data' => ucfirst($query->tingkat)],
            ['Field' => 'Status', 'Data' => ucfirst($query->status)],
            ['Field' => 'Nama', 'Data' => $query->biodata->nama ?? '-'],
            ['Field' => 'Umur', 'Data' => ($query->biodata->umur ?? '-') . ' tahun'],
            ['Field' => 'Alamat', 'Data' => $query->biodata->alamat ?? '-'],
            ['Field' => 'Gender', 'Data' => $query->biodata->gender == 'L' ? 'Laki-laki' : ($query->biodata->gender == 'P' ? 'Perempuan' : '-')],
        ];

        return response()->json(['data' => $data]);
    }

    public function get_edit_profil(string $id)
    {
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')
            ->select('akun.id_akun', 'email', 'tingkat', 'status')
            ->where('akun.id_akun', $id)
            ->first();

        $option = [
            'tingkat' => ['admin', 'user'],
            'status' => ['aktif', 'nonaktif'],
            'gender' => ['L', 'P'],
        ];

        return view('profil.edit_data', ['akun' => $query, 'option' => $option]);
    }

    public function put_edit_profil(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'email' => 'required|email|max:100|unique:akun,email,' . $id . ',id_akun',
                'password' => 'nullable|min:6|max:255',
                'nama' => 'required|max:100',
                'umur' => 'required|integer|min:1|max:150',
                'alamat' => 'required',
                'gender' => 'required|in:L,P',
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

            $akun = AkunModel::find($id);
            if ($akun) {
                if ($request->filled('password')) {
                    $plainPassword = $request->input('password');
                    $request->request->remove('password');
                    $akun->update([
                        'password' => Hash::make($plainPassword),
                    ]);
                }
                $akun->update([
                    'email' => $request['email'],
                ]);

                BiodataModel::where('id_akun', $id)->update([
                    'id_akun' => $akun->id_akun,
                    'nama' => $request['nama'],
                    'umur' => $request['umur'],
                    'alamat' => $request['alamat'],
                    'gender' => $request['gender'],
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

    public function get_tambah_data()
    {
        $option = [
            'tingkat' => ['admin', 'user'],

            'gender' => ['L', 'P'],
        ];

        return view('akun.tambah_data')->with('option', $option);
    }

    public function post_tambah_data(Request $request)
    {

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
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function get_edit_data(string $id)
    {
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')
            ->select('akun.id_akun', 'email', 'tingkat', 'status')
            ->where('akun.id_akun', $id)
            ->first();

        $option = [
            'tingkat' => ['admin', 'user'],
            'status' => ['aktif', 'nonaktif'],
            'gender' => ['L', 'P'],
        ];

        return view('akun.edit_data', ['akun' => $query, 'option' => $option]);
    }

    public function put_edit_data(Request $request, $id)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'email' => 'required|email|max:100|unique:akun,email,' . $id . ',id_akun',
                'password' => 'nullable|min:6|max:255',
                'tingkat' => 'required|in:admin,user',
                'status' => 'required|in:aktif,nonaktif',
                'nama' => 'required|max:100',
                'umur' => 'required|integer|min:1|max:150',
                'alamat' => 'required',
                'gender' => 'required|in:L,P',
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

            $akun = AkunModel::find($id);
            if ($akun) {
                if ($request->filled('password')) {
                    $plainPassword = $request->input('password');
                    $request->request->remove('password');
                    $akun->update([
                        'password' => Hash::make($plainPassword),
                    ]);
                }
                $akun->update([
                    'email' => $request['email'],
                    'tingkat' => $request['tingkat'],
                    'status' => $request['status'],
                ]);

                BiodataModel::where('id_akun', $id)->update([
                    'id_akun' => $akun->id_akun,
                    'nama' => $request['nama'],
                    'umur' => $request['umur'],
                    'alamat' => $request['alamat'],
                    'gender' => $request['gender'],
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
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')
            ->select('akun.id_akun', 'email', 'tingkat', 'status')
            ->where('akun.id_akun', $id)
            ->first();

        return view('akun.detail_data', ['akun' => $query]);
    }

    public function get_hapus_data(string $id)
    {
        $query = AkunModel::with('biodata:id_akun,nama,umur,alamat,gender')
            ->select('akun.id_akun', 'email', 'tingkat', 'status')
            ->where('akun.id_akun', $id)
            ->first();

        return view('akun.hapus_data', ['akun' => $query]);
    }

    public function delete_hapus_data(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $akun = AkunModel::find($id);
            if ($akun) {
                BiodataModel::where('id_akun', $id)->delete();
                $akun->delete();
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