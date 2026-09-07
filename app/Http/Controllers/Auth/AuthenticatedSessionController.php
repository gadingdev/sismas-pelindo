<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    // Tampilkan halaman login
    public function create()
    {
        // Kalo udah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    // Proses login (Email atau NIP)
    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        // Cek apakah input itu email atau NIP
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';

        if (Auth::attempt([$field => $request->login, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login' => 'Email/NIP atau password salah.',
        ])->onlyInput('login');
    }

    // Proses logout
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}