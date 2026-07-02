<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        // ✅ Urutkan benar
        $data = Kategori::orderByRaw("CAST(SUBSTRING(kode_kategori, -3) AS UNSIGNED) DESC")->get();

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Buka Data Kategori',
            'keterangan'=> 'Mengakses halaman kategori'
        ]);

        return view('kategori.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Tambah Kategori',
            'keterangan'=> 'Menambahkan kategori: ' . $kategori->nama_kategori . ' (Kode: ' . $kategori->kode_kategori . ')'
        ]);

        return back()->with('success', 'Kategori berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        // ✅ Cari berdasarkan kode_kategori
        $kategori = Kategori::where('kode_kategori', $id)->firstOrFail();

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Update Kategori',
            'keterangan'=> 'Mengupdate kategori: ' . $kategori->nama_kategori . ' (Kode: ' . $kategori->kode_kategori . ')'
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::where('kode_kategori', $id)->firstOrFail();
        $nama = $kategori->nama_kategori;
        $kode = $kategori->kode_kategori;

        // ✅ Cek dulu apakah masih ada produk
        $cek = Produk::where('kode_kategori', $id)->exists();
        if($cek){
            return back()->with('error', '❌ Tidak bisa hapus! Masih ada produk dalam kategori ini.');
        }

        $kategori->delete();

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Hapus Kategori',
            'keterangan'=> 'Menghapus kategori: ' . $nama . ' (Kode: ' . $kode . ')'
        ]);

        return back()->with('success', 'Kategori berhasil dihapus');
    }

    public function edit($id)
    {
        $data = Kategori::where('kode_kategori', $id)->firstOrFail();

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Edit Kategori',
            'keterangan'=> 'Membuka halaman edit kategori Kode: ' . $id
        ]);

        return view('kategori.edit', compact('data'));
    }
}