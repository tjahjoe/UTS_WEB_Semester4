<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function get_login()
    {
        // untuk menentukan halaman awal
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }
    public function post_login(Request $request)
    {
        // login dan disimpan disession
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')

                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
        return redirect('login');
    }
    public function get_logout(Request $request)
    {
        // logout dan menghapus session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}