<?php

use App\Models\ActivityLog;

if (!function_exists('activity_log')) {

    function activity_log($aktivitas, $keterangan = null)
    {
        ActivityLog::create([
            'id_user' => auth()->user()->id_user ?? null,
            'aktivitas' => $aktivitas,
            'keterangan' => $keterangan
        ]);
    }
}