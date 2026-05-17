<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Algoritma Sign Up (Simpan Data)
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'username' => 'required|string|min:5|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'nim' => 'nullable|numeric|digits:12|unique:users,nim',
            'phone' => 'required|numeric|digits_between:10,13',
            'address' => 'required|string|min:10', // Alamat minimal 10 karakter agar jelas
            'password' => 'required|min:8|confirmed',
        ], [
            'nim.digits' => 'NIM harus tepat 12 digit!',
            'nim.unique' => 'NIM ini sudah terdaftar!',
            'address.min' => 'Alamatnya kurang lengkap, nih!',
        ]);

        // Logika penentuan role otomatis berdasarkan NIM
        $role = $request->nim ? 'mahasiswa' : 'user';

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'nim' => $request->nim,
            'role' => $role,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // Algoritma Login (Cek Data)
    public function login(Request $request) 
    {
        // Kita ambil username dan password dari form
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    // Tambahkan fungsi Logout untuk Desktop
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Top Up Saldo
    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ], [
            'amount.required' => 'Nominal harus diisi!',
            'amount.numeric' => 'Nominal hanya boleh berisi angka!',
            'amount.min' => 'Minimal top up Rp 1.000!',
        ]);

        // Proses top up ke database
        // $user = Auth::user();
        // $user->balance += $request->amount;
        // $user->save();

        return back()->with('success', 'Top up berhasil! Saldo kamu bertambah Rp ' . number_format($request->amount, 0, ',', '.'));
    }
}