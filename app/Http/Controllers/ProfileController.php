<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // ========================
    // HALAMAN PROFILE (VIEW)
    // ========================
    public function index()
    {
        $data = Auth::user();
        return view('profile.index', compact('data'));
    }

    // ========================
    // HALAMAN EDIT PROFILE
    // ========================
    public function edit()
    {
        $data = Auth::user();
        return view('profile.edit', compact('data'));
    }

    // ========================
    // UPDATE DATA PROFILE + FOTO
    // ========================
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'      => 'required|string|max:100',
            'email'     => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id_user, 'id_user')
            ],
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_url'  => 'nullable|string|max:255' // ✅ Tambah agar bisa pakai alamat langsung
        ]);

        // Update data teks
        $user->nama  = strip_tags($request->nama);
        $user->email = strtolower($request->email);

        // ========================
        // PROSES FOTO
        // ========================
        // Jika ada file yang diunggah → simpan ke folder asli "public/foto"
        if ($request->hasFile('foto')) {

            $path = public_path('foto');

            // Buat folder jika belum ada
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // Hapus foto lama jika ada dan ada di folder ini
            if ($user->foto && !filter_var($user->foto, FILTER_VALIDATE_URL) && File::exists($path . '/' . $user->foto)) {
                File::delete($path . '/' . $user->foto);
            }

            // Nama file unik
            $namaFile = time() . '_' . uniqid() . '.' . $request->file('foto')->getClientOriginalExtension();

            // Simpan file
            $request->file('foto')->move($path, $namaFile);

            // Simpan nama file ke database
            $user->foto = $namaFile;
        }
        // Jika diisi alamat foto dari folder lain / URL
        elseif ($request->filled('foto_url')) {
            // Hapus foto lama jika berupa file lokal
            if ($user->foto && !filter_var($user->foto, FILTER_VALIDATE_URL) && File::exists(public_path('foto/' . $user->foto))) {
                File::delete(public_path('foto/' . $user->foto));
            }
            // Simpan alamat yang dimasukkan
            $user->foto = $request->foto_url;
        }
        // Jika tidak diubah sama sekali → biarkan tetap seperti semula

        // Simpan perubahan
        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

    // ========================
    // UPDATE PASSWORD
    // ========================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    // ========================
    // UPLOAD FOTO TERPISAH
    // ========================
    public function uploadFoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = public_path('foto');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // Hapus foto lama hanya jika berupa file lokal
        if ($user->foto && !filter_var($user->foto, FILTER_VALIDATE_URL) && File::exists($path . '/' . $user->foto)) {
            File::delete($path . '/' . $user->foto);
        }

        $file = $request->file('foto');
        $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $namaFile);

        $user->update(['foto' => $namaFile]);

        return back()->with('success', 'Foto profil berhasil diperbarui');
    }
}