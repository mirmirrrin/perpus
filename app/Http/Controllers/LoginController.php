<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        // 1. Validasi input (Kita pakai nama 'login' agar fleksibel)
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // 2. Logika Cek: Apakah input itu Email atau Username?
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Coba login dengan kredensial yang dinamis
        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // 4. Redirect berdasarkan Role
            if ($user->role === 'admin' || $user->username === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/siswa/dashboard');
            }
        }

        // 5. Jika gagal
        return back()->with('loginError', 'Username/Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
