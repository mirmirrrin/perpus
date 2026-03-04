<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('siswa.pages.profile');
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'phone' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update Data Dasar
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->alamat = $request->alamat;

        // Logika Upload Foto
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $fileName = time() . '_' . $user->username . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/avatars', $fileName);
            $user->avatar = $fileName;
        }

        // Logika Password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil dan foto berhasil diperbarui!');
    }
}
