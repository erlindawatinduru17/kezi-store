<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // 🔐 FORM LOGIN
    public function login()
    {
        return view('auth.login');
    }

    // 🔐 PROSES LOGIN
    public function loginProses(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            // 🔥 SECURITY
            $request->session()->regenerate();

            $user = Auth::user();

            // 🔥 SEMUA ROLE KE DASHBOARD
            if ($user->isAdmin()) {
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat datang Admin');
            }

            if ($user->isKasir()) {
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat datang Kasir');
            }

            // 🔥 fallback (jaga-jaga)
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Role tidak dikenali');
        }

        return back()->with('error', 'Username atau password salah');
    }

    // 📝 FORM REGISTER
    public function register()
    {
        return view('auth.register');
    }

    // 📝 PROSES REGISTER
    public function registerProses(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'jabatan' => 'required|in:admin,kasir' // 🔥 penting
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat, silakan login');
    }

    // 🚪 LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        // 🔥 SECURITY
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}