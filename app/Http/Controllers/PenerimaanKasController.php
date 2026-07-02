<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaanKas;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PenerimaanKasController extends Controller
{
    // ✅ Tampilkan daftar + filter
    public function index(Request $request)
    {
        $query = PenerimaanKas::with('penjualan');

        // Filter tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tgl_terimakas', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tgl_terimakas', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tgl_terimakas', '<=', $request->to);
        }

        // Urutkan dari terbaru
        $data = $query->orderBy('tgl_terimakas', 'desc')
                      ->orderBy('kode_terimakas', 'desc')
                      ->get();

        // Catat aktivitas
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Lihat Data Penerimaan Kas',
                'keterangan'=> 'Mengakses halaman daftar penerimaan kas'
            ]);
        }

        return view('keuangan.penerimaan_kas', compact('data'));
    }

    // ✅ Simpan data baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_jual'       => 'required|exists:penjualans,kode_jual',
            'tgl_terimakas'   => 'required|date',
            'jmlh_terimakas'  => 'required|numeric|min:1',
            'keterangan'      => 'nullable|string|max:255'
        ]);

        // Simpan data (kode TRK dibuat otomatis di Model)
        $kas = PenerimaanKas::create([
            'kode_jual'       => $request->kode_jual,
            'tgl_terimakas'   => $request->tgl_terimakas,
            'jmlh_terimakas'  => $request->jmlh_terimakas,
            'keterangan'      => $request->keterangan
        ]);

        // Catat aktivitas
        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Tambah Penerimaan Kas',
                'keterangan'=> "Berhasil menambah kode {$kas->kode_terimakas} untuk transaksi {$request->kode_jual}"
            ]);
        }

        return back()->with('success', "Data berhasil disimpan dengan kode: {$kas->kode_terimakas}");
    }

    // ✅ Hapus data
    public function destroy($id)
    {
        $kas = PenerimaanKas::findOrFail($id);
        $kodeDihapus = $kas->kode_terimakas;
        $kas->delete();

        if (Auth::check()) {
            ActivityLog::create([
                'id_user'   => Auth::user()->id_user,
                'aktivitas' => 'Hapus Penerimaan Kas',
                'keterangan'=> "Menghapus kode: {$kodeDihapus}"
            ]);
        }

        return back()->with('success', "Kode {$kodeDihapus} berhasil dihapus");
    }
}