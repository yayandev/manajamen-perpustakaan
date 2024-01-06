<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|same:confirmPassword',
            'confirmPassword' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if (!$user) {
            return redirect('/register')->with(['error' => 'Registrasi Gagal Silahkan Coba Lagi!']);
        }

        return redirect('/login')->with(['success' => 'Registrasi Berhasil Silahkan Login!']);
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return redirect('/login')->with(['error' => 'Email atau Password Salah!']);
        }

        return redirect('/')->with(['success' => 'Selamat Datang!']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
