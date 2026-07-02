<?php

namespace App\Helpers;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\PenerimaanKas;

class CodeGenerator
{
   
    // =========================
    // KODE KATEGORI
    // =========================
    public static function generateKodeKategori()
    {
        $semuaKode = Kategori::pluck('kode_kategori');
        $maxAngka = 0;

        foreach ($semuaKode as $kode) {
            if (is_numeric($kode)) {
                $angka = (int) $kode;
            } else {
                $angka = (int) substr($kode, -3);
            }
            if ($angka > $maxAngka) $maxAngka = $angka;
        }

        $next = $maxAngka + 1;
        return 'KTG-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    // =========================
    // KODE PRODUK
    // =========================
    public static function generateKodeProduk()
    {
        $semuaKode = Produk::pluck('id_produk');
        $maxAngka = 0;

        foreach ($semuaKode as $kode) {
            $angka = (int) substr($kode, -4);
            if ($angka > $maxAngka) $maxAngka = $angka;
        }

        $next = $maxAngka == 0 ? 1 : $maxAngka + 1;
        return 'PRD-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    // =========================
    // NOMOR PENJUALAN
    // =========================
    public static function generateNomorPenjualan()
    {
        $today = date('Ymd');
        $last = Penjualan::whereDate('tanggal_jual', date('Y-m-d'))
            ->orderBy('kode_jual', 'desc')
            ->first();

        $sequence = 1;
        if ($last && preg_match('/PJL-\d{8}-(\d+)/', $last->kode_jual, $match)) {
            $sequence = (int)$match[1] + 1;
        }

        return 'PJL-' . $today . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    // =========================
    // ✅ KODE TERIMA KAS (FORMAT TRK)
    // =========================
    public static function generateKodeTerimaKas()
    {
        $tanggal = date('Ymd'); // Format: 20260623
        $hariIni = date('Y-m-d');

        // Ambil data terakhir hari ini
        $terakhir = PenerimaanKas::whereDate('tgl_terimakas', $hariIni)
                                  ->orderBy('kode_terimakas', 'desc')
                                  ->first();

        $urutan = 1;

        // Ambil nomor urut jika sudah ada data berformat TRK
        if ($terakhir && str_starts_with($terakhir->kode_terimakas, 'TRK-')) {
            if (preg_match('/TRK-\d{8}-(\d+)/', $terakhir->kode_terimakas, $cocok)) {
                $urutan = (int)$cocok[1] + 1;
            }
        }

        // Hasil akhir: TRK-20260623-001
        return 'TRK-' . $tanggal . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }
}