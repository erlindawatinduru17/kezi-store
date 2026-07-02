<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\DetailPenjualan;

class MonitoringController extends Controller
{

    // ========================
    // ACTIVITY LOG
    // ========================
    public function activity(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->dari) {
            $query->whereDate('created_at', '>=', $request->dari);
        }

        if ($request->sampai) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        if ($request->user) {
            $query->where('id_user', $request->user);
        }

        $logs = $query->limit(100)->get();
        $users = User::all();

        return view('monitoring.activity', compact('logs', 'users'));
    }


    // ========================
    // GRAFIK PENJUALAN (DENGAN FILTER TANGGAL)
    // ========================
    public function grafik(Request $request)
{
    $query = Penjualan::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COALESCE(SUM(total_jual), 0) as total')
        );

    // ✅ LOGIKA FILTER DIPERBAIKI: BISA ISI SALAH SATU ATAU KEDUANYA
    if ($request->filled('dari_tanggal')) {
        $query->whereDate('created_at', '>=', $request->dari_tanggal);
    }

    if ($request->filled('sampai_tanggal')) {
        $query->whereDate('created_at', '<=', $request->sampai_tanggal);
    }

    // ✅ Kelompokkan dan urutkan
    $data = $query->groupBy(DB::raw('DATE(created_at)'))
                  ->orderBy('tanggal', 'ASC')
                  ->get();

    return view('monitoring.grafik', compact('data'));
}

    // ========================
    // PRODUK TERLARIS
    // ========================
    public function produkTerlaris(Request $request)
    {
        $query = DetailPenjualan::select(
                'id_produk',
                DB::raw('COALESCE(SUM(jumlah),0) as total_terjual')
            )
            ->with('produk')
            ->groupBy('id_produk')
            ->orderByDesc('total_terjual');

        if ($request->dari) {
            $query->whereDate('created_at', '>=', $request->dari);
        }

        if ($request->sampai) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        $data = $query->limit(10)->get();

        return view('monitoring.produk_terlaris', compact('data'));
    }


    // ========================
    // HAPUS ACTIVITY LOG
    // ========================
    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);

        $log->delete();

        return redirect()->back()->with(
            'success',
            'Log aktivitas berhasil dihapus'
        );
    }

}