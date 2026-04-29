<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        // 1. Ganti 'email' menjadi 'nik_sap' dan hapus validasi format email
        $credentials = $request->validate([
            'nik_sap' => ['required', 'string'], 
            'password' => ['required'],
        ]);

        // 2. Cek ke database (tabel users)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role; 

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'user') {
                return redirect()->route('user.dashboard');
            }
        }

        // 3. Jika gagal, kembalikan dengan pesan error NIK SAP
        return back()->withErrors([
            'nik_sap' => 'NIK SAP atau password salah.',
        ])->onlyInput('nik_sap');
    }

    // Fungsi untuk Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}