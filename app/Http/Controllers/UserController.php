<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $data = User::latest()->get();
        return view('user.index', compact('data'));
    }

    // =========================
    // ✅ PENYIMPANAN TETAP DI FOLDER AWAL
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required',
            'username'  => 'required|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:5',
            'jabatan'   => 'required|in:admin,kasir',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_url'  => 'nullable|url' // Tambahan opsional
        ]);

        $foto = null;

        // Jika unggah file, simpan ke folder awal
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('user', 'public');
        }
        // Jika masukkan URL, simpan saja alamatnya
        elseif ($request->filled('foto_url')) {
            $foto = $request->foto_url;
        }

        User::create([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'jabatan'   => $request->jabatan,
            'foto'      => $foto
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'      => 'required',
            'username'  => 'required|unique:users,username,' . $id . ',id_user',
            'email'     => 'required|email|unique:users,email,' . $id . ',id_user',
            'jabatan'   => 'required|in:admin,kasir',
            'password'  => 'nullable|min:5',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_url'  => 'nullable|url'
        ]);

        // Hapus foto lama hanya jika ada dan berupa file lokal
        if (($request->hasFile('foto') || $request->filled('foto_url')) && $user->foto) {
            if (!filter_var($user->foto, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
        }

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('user', 'public');
        } elseif ($request->filled('foto_url')) {
            $foto = $request->foto_url;
        } else {
            $foto = $user->foto;
        }

        $user->update([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email,
            'jabatan'   => $request->jabatan,
            'foto'      => $foto
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->foto && !filter_var($user->foto, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}