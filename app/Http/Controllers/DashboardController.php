<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ======================
        // STATISTIK UTAMA
        // ======================
        $totalProduk = Produk::count();
        $totalTransaksi = Penjualan::count();
        $totalPendapatan = Penjualan::sum('total_jual');

        // ======================
        // HARI INI
        // ======================
        $penjualanHariIni = Penjualan::whereDate('tanggal_jual', Carbon::today())->count();

        $pendapatanHariIni = Penjualan::whereDate('tanggal_jual', Carbon::today())
            ->sum('total_jual');

        // ======================
        // 🔥 GRAFIK PENJUALAN (WAJIB UNTUK DASHBOARD)
        // ======================
        $grafik = Penjualan::select(
                DB::raw('DATE(tanggal_jual) as tanggal'),
                DB::raw('SUM(total_jual) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        // ======================
        // 🔥 PRODUK TERLARIS (PAKAI MODEL)
        // ======================
        $produkTerlaris = DetailPenjualan::select(
                'id_produk',
                DB::raw('SUM(jumlah) as total_terjual')
            )
            ->with('produk')
            ->groupBy('id_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // ======================
        // 🔥 TRANSAKSI TERBARU
        // ======================
        $transaksiTerbaru = Penjualan::latest()
            ->limit(5)
            ->get();

        // ======================
        // RETURN VIEW
        // ======================
        return view('dashboard.index', compact(
            'totalProduk',
            'totalTransaksi',
            'totalPendapatan',
            'penjualanHariIni',
            'pendapatanHariIni',
            'grafik',
            'produkTerlaris',
            'transaksiTerbaru'
        ));
    }
}