<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan halaman dashboard pengguna.
     */
    public function index()
    {
        return view('user.home');
    }

    /**
     * Tampilkan halaman edit profil pengguna.
     */
    public function edit()
    {
        $user = Auth::user(); // Ambil data pengguna yang sedang login
        return view('user.edit', compact('user'));
    }

    /**
     * Update profil pengguna.
     */
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'nik' => 'nullable|string|max:20|unique:users,nik,' . Auth::id(),
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15|unique:users,phone,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed', // Validasi password (optional)
        ]);

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Update data pengguna, jika password diisi maka hash password
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'nik' => $request->input('nik'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password, // Update password jika diisi
        ]);

        // Redirect kembali ke halaman edit dengan pesan sukses
        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
