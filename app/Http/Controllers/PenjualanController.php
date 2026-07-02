<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenerimaanKas;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    // ========================
    // LIST + FILTER TANGGAL
    // ========================
    public function index(Request $request)
    {
        $query = Penjualan::with('user')->latest();

        // ========================
        // 🔥 FILTER TANGGAL (FROM - TO)
        // ========================
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_jual', [
                $request->from,
                $request->to
            ]);
        }

        elseif ($request->filled('from')) {
            $query->whereDate('tanggal_jual', '>=', $request->from);
        }

        elseif ($request->filled('to')) {
            $query->whereDate('tanggal_jual', '<=', $request->to);
        }

        $data = $query->get();

        // ========================
        // 🔥 LOG AKTIVITAS (AMAN + RAPI)
        // ========================
        if (Auth::check() && ($request->filled('from') || $request->filled('to'))) {
            ActivityLog::create([
                'id_user'    => Auth::user()->id_user,
                'aktivitas'  => 'Filter Data Penjualan',
                'keterangan' => 'Periode: ' .
                    ($request->from ?? 'awal') .
                    ' s/d ' .
                    ($request->to ?? 'akhir')
            ]);
        }

        return view('penjualan.index', compact('data'));
    }

    // ========================
    // DETAIL PENJUALAN
    // ========================
    public function show($id)
    {
        // ✅ DIPERBAIKI: Cari berdasarkan kode_jual (karena route pakai kode)
        $data = Penjualan::with('details.produk')
                    ->where('kode_jual', $id)
                    ->firstOrFail();
                    
        return view('penjualan.show', compact('data'));
    }

    // ========================
    // CETAK NOTA
    // ========================
    public function nota($id)
    {
        // ✅ DIPERBAIKI: Cari berdasarkan kode_jual
        $data = Penjualan::with('details.produk')
                    ->where('kode_jual', $id)
                    ->firstOrFail();
                    
        return view('penjualan.nota', compact('data'));
    }

    // ========================
    // HAPUS DATA
    // ========================
    public function destroy($id)
    {
        // ✅ DIPERBAIKI: Hapus berdasarkan kode_jual
        $data = Penjualan::where('kode_jual', $id)->firstOrFail();
        $data->delete();

        return back()->with('success', 'Data penjualan berhasil dihapus');
    }

    // ========================
    // VERIFIKASI PEMBAYARAN
    // ========================
    public function verifikasi($id)
{
    $data = Penjualan::where('kode_jual', $id)->firstOrFail();

    if ($data->status_bayar === 'Lunas') {
        return back()->with('error', 'Transaksi sudah lunas');
    }

    $data->update([
        'status_bayar' => 'Lunas'
    ]);

    // ✅ Data masuk sesuai struktur tabel dan Model kamu
    PenerimaanKas::create([
        'kode_jual'        => $data->kode_jual,
        'tgl_terimakas'    => now(),
        'jmlh_terimakas'   => $data->total_jual,
        'keterangan'       => 'Verifikasi pembayaran transaksi ' . $data->kode_jual
    ]);

    return back()->with('success', 'Pembayaran berhasil diverifikasi & masuk ke Penerimaan Kas');
}
    
    // ==================================================
    // 🔥 TAMBAHAN BARU: FUNGSI UPLOAD BUKTI BAYAR
    // ==================================================
    public function uploadBukti(Request $request, $id)
    {
        // 1. Cari data
        $data = Penjualan::where('kode_jual', $id)->firstOrFail();

        // 2. ✅ ATURAN VALIDASI (Ini yang mengatur pesan error tadi!)
        // Jika mau ubah aturan, ubah di baris ini
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', 
            // ⬆️ Saya tambah PDF juga di sini, kalau mau hapus PDF, hapus tulisan ,pdf
        ], [
            'bukti_bayar.mimes' => 'File harus berformat: JPG, JPEG, PNG, atau PDF.', // Pesan kustom
            'bukti_bayar.max'   => 'Ukuran file maksimal 2 MB.'
        ]);

        // 3. Proses Simpan File
        if ($request->hasFile('bukti_bayar')) {
            
            // Hapus file lama kalau ada
            if ($data->bukti_bayar && file_exists(public_path('bukti_bayar/'.$data->bukti_bayar))) {
                unlink(public_path('bukti_bayar/'.$data->bukti_bayar));
            }

            // Simpan file baru dengan nama unik
            $file = $request->file('bukti_bayar');
            $nama_file = 'bukti_' . $data->kode_jual . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('bukti_bayar'), $nama_file);

            // Update nama file ke database
            $data->update([
                'bukti_bayar' => $nama_file
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
    }
}