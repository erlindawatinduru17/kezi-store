<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    // =========================
    // FUNGSI UTAMA: SESUAI RUTE ->name('activity')
    // =========================
    public function activity(Request $request)
    {
        // Ambil data dari terbaru
        $query = ActivityLog::with('user')->latest();

        // 🔍 FILTER BERDASARKAN RENTANG TANGGAL
        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('created_at', [
                $request->dari . ' 00:00:00',
                $request->sampai . ' 23:59:59'
            ]);
        }

        // 🔍 FILTER BERDASARKAN PENGGUNA
        if ($request->filled('user')) {
            $query->where('id_user', $request->user);
        }

        // Ambil hasil data
        $logs = $query->get();

        // Ambil semua user untuk pilihan filter
        $users = User::all();

        // Kirim ke tampilan
        return view('monitoring.activity', compact('logs', 'users'));
    }

    // =========================
    // FUNGSI HAPUS (Sudah ada rute ->name('delete'))
    // =========================
    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        return redirect()->route('monitoring.activity')
                         ->with('success', 'Log aktivitas berhasil dihapus!');
    }
}