<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function get_login()
    {
        // Mengecek apakah pengguna sudah terautentikasi
        if (Auth::check()) {
            // Jika pengguna sudah login, arahkan ke halaman utama
            return redirect('/');
        }

        // Jika pengguna belum login, tampilkan halaman login
        return view('auth.login');
    }

    public function post_login(Request $request)
    {
        // Login dan simpan session pengguna jika berhasil
        if ($request->ajax() || $request->wantsJson()) {
            // Mendapatkan email dan password dari request
            $credentials = $request->only('email', 'password');

            // Mencoba melakukan login dengan kredensial yang diberikan
            if (Auth::attempt($credentials)) {
                // Jika login berhasil, kirimkan response JSON dengan status true dan redirect URL
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            // Jika login gagal, kirimkan response JSON dengan status false
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        // Jika bukan request ajax atau json, redirect ke halaman login
        return redirect('login');
    }

    public function get_logout(Request $request)
    {
        // Logout dan hapus session pengguna
        Auth::logout();  // Menghapus autentikasi pengguna (session)

        // Menghapus data session yang tersimpan
        $request->session()->invalidate();

        // Meregenerasi token CSRF untuk keamanan
        $request->session()->regenerateToken();

        // Redirect pengguna kembali ke halaman login setelah logout
        return redirect('login');
    }
}