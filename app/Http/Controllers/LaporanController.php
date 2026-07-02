<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // ========================
    // LAPORAN PENJUALAN (Diperbaiki & Lebih Fleksibel)
    // ========================
    public function penjualan(Request $request)
    {
        $query = Penjualan::query();

        // ✅ LEBIH FLEKSIBEL: Bisa isi salah satu atau keduanya
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_jual', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_jual', '<=', $request->sampai);
        }

        // ✅ Tetap memuat relasi detail dan produk
        $data = $query->with('details.produk')
                      ->latest('tanggal_jual') // Urut dari terbaru
                      ->get();

        $total = $data->sum('total_jual');

        return view('laporan.penjualan', compact('data', 'total'));
    }

    // ========================
    // LAPORAN PRODUK TERLARIS (Dioptimalkan)
    // ========================
    public function produkTerlaris(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $produk = Produk::with('kategori')
            ->withCount([
                'details as total_terjual' => function ($query) use ($dari, $sampai) {
                    
                    // Hitung total jumlah barang terjual
                    $query->select(DB::raw('COALESCE(SUM(jumlah), 0)'));

                    // ✅ Filter: Jika ada tanggal, terapkan filter
                    $query->when($dari || $sampai, function ($q) use ($dari, $sampai) {
                        $q->whereHas('penjualan', function ($sub) use ($dari, $sampai) {
                            
                            // Filter tanggal (bisa salah satu atau keduanya)
                            if ($dari) {
                                $sub->whereDate('tanggal_jual', '>=', $dari);
                            }
                            if ($sampai) {
                                $sub->whereDate('tanggal_jual', '<=', $sampai);
                            }

                            // ✅ Wajib Lunas
                            $sub->where('status_bayar', 'Lunas');
                        });
                    });
                }
            ])
            ->orderByDesc('total_terjual') // Paling laku di atas
            ->get();

        // Hitung Total Omset dari produk terjual
        $total = $produk->sum(function ($item) {
            // Gunakan harga jual saat transaksi jika ada, atau harga saat ini
            return $item->total_terjual * ($item->harga ?? 0);
        });

        return view('laporan.produk_terlaris', compact(
            'produk',
            'total',
            'dari',
            'sampai'
        ));
    }
}