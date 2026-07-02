<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    // =========================
    // TAMPIL DATA
    // =========================
    public function index()
    {
        $data = Produk::with('kategori')->latest()->get();
        $kategori = Kategori::all();

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Buka Data Produk',
            'keterangan'=> 'Mengakses halaman produk'
        ]);

        return view('produk.index', compact('data', 'kategori'));
    }

    // =========================
    // SIMPAN DATA
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'harga'         => 'required|numeric|min:100',
            'stok'          => 'required|integer|min:0',
            'kode_kategori' => 'required|string|max:20',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // --------------------------
        // Logika Batas Harga (decimal(10,2) = maks 99999999.99)
        // --------------------------
        $hargaInput = (float) str_replace('.', '', $request->harga); // Bersihkan titik ribuan
        $hargaMaksimal = 99999999.99;

        if ($hargaInput > $hargaMaksimal) {
            $hargaAkhir = $hargaMaksimal;
            session()->flash('info', '⚠️ Harga melebihi batas maksimal, otomatis disimpan menjadi Rp 99.999.999,99');
        } else {
            $hargaAkhir = $hargaInput;
        }

        // Proses upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        // ✅ id_produk SUDAH DIISI OTOMATIS dari Model
        $produk = Produk::create([
            'nama_produk'   => $request->nama_produk,
            'harga'         => $hargaAkhir, // Pakai nilai yang sudah dibatasi
            'stok'          => $request->stok,
            'gambar'        => $gambarPath,
            'kode_kategori' => $request->kode_kategori
        ]);

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Tambah Produk',
            'keterangan'=> 'Menambah produk: ' . $produk->nama_produk . ' (Kode: ' . $produk->id_produk . ')'
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambah');
    }

    // =========================
    // HALAMAN EDIT
    // =========================
    public function edit($id)
    {
        // ✅ Cari berdasarkan id_produk (VARCHAR)
        $data = Produk::where('id_produk', $id)->firstOrFail();
        $kategori = Kategori::all();

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Edit Produk',
            'keterangan'=> 'Membuka edit produk Kode: ' . $id
        ]);

        return view('produk.edit', compact('data', 'kategori'));
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk'   => 'required|max:100',
            'harga'         => 'required|numeric',
            'stok'          => 'required|integer',
            'kode_kategori' => 'required',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ✅ Cari pakai where (karena primary key string)
        $produk = Produk::where('id_produk', $id)->firstOrFail();

        // --------------------------
        // Logika Batas Harga Sama Seperti di Store
        // --------------------------
        $hargaInput = (float) str_replace('.', '', $request->harga);
        $hargaMaksimal = 99999999.99;

        if ($hargaInput > $hargaMaksimal) {
            $hargaAkhir = $hargaMaksimal;
            session()->flash('info', '⚠️ Harga melebihi batas maksimal, otomatis disimpan menjadi Rp 99.999.999,99');
        } else {
            $hargaAkhir = $hargaInput;
        }

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $produk->gambar = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update([
            'nama_produk'   => $request->nama_produk,
            'harga'         => $hargaAkhir, // Pakai nilai yang sudah dibatasi
            'stok'          => $request->stok,
            'kode_kategori' => $request->kode_kategori
        ]);

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Update Produk',
            'keterangan'=> 'Update produk: ' . $produk->nama_produk . ' (Kode: ' . $produk->id_produk . ')'
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    // =========================
    // HAPUS DATA
    // =========================
    public function destroy($id)
    {
        $produk = Produk::where('id_produk', $id)->firstOrFail();

        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $nama = $produk->nama_produk;
        $kode = $produk->id_produk;

        $produk->delete();

        ActivityLog::create([
            'id_user'   => Auth::check() ? Auth::user()->id_user : null,
            'aktivitas' => 'Hapus Produk',
            'keterangan'=> 'Menghapus produk: ' . $nama . ' (Kode: ' . $kode . ')'
        ]);

        return back()->with('success', 'Produk berhasil dihapus');
    }
}