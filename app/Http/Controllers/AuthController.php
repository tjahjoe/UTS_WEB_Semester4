<?php
namespace App\Http\Controllers;
use App\Models\AkunModel;
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
        // Hanya tangani permintaan AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {
    
            // Ambil status akun berdasarkan email
            $akun = AkunModel::where('email', $request['email'])->first();
    
            // Cek apakah akun ditemukan dan statusnya aktif
            if ($akun && $akun->status === 'aktif') {
                // Ambil email dan password dari request
                $credentials = $request->only('email', 'password');
    
                // Coba login dengan kredensial tersebut
                if (Auth::attempt($credentials)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Berhasil',
                        'redirect' => url('/')
                    ]);
                }
            }
    
            // Jika status tidak aktif atau login gagal
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal: Email, password, atau status akun tidak valid.'
            ]);
        }
    
        // Jika bukan request AJAX/JSON
        abort(403, 'Unauthorized action.');
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