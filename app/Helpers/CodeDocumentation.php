<?php

/**
 * ============================================
 * DOKUMENTASI PENGGUNAAN KODE INPUT
 * ============================================
 *
 * File ini menjelaskan cara menggunakan fitur
 * input kode di setiap tabel.
 *
 * FIELD KODE YANG DAPAT DI-INPUT:
 * 1. Kategori: kode_kategori (contoh: KTG-001)
 * 2. Produk: kode_produk (contoh: PRD-0001)
 * 3. Penjualan: kode_jual (contoh: PJL-20260430-001)
 * 4. Penerimaan Kas: kode_terimakas (contoh: TRK-20260430-001)
 *
 * ============================================
 * CONTOH PENGGUNAAN DI CONTROLLER
 * ============================================
 */

namespace App\Helpers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\PenerimaanKas;
use CodeGenerator;

/**
 * Documentation Class - Contoh penggunaan auto-generate codes
 * File ini hanya untuk referensi dan dokumentasi
 */
class CodeDocumentation
{
    /**
     * KATEGORI - Buat kategori dengan kode manual atau auto-generate
     */
    public function createKategori()
    {
        // Cara 1: Admin/Kasir input kode manual
        $kategori1 = Kategori::create([
            'kode_kategori' => 'KTG-CUSTOM', // Input manual dari admin
            'nama_kategori' => 'Elektronik'
        ]);
        // Output: kode_kategori = 'KTG-CUSTOM'

        // Cara 2: Auto-generate kode otomatis
        $kategori2 = Kategori::create([
            // kode_kategori dihilangkan, akan auto-generate
            'nama_kategori' => 'Fashion'
        ]);
        // Output: kode_kategori = 'KTG-002' (auto-generated)
    }

    /**
     * PRODUK - Buat produk dengan kode manual atau auto-generate
     */
    public function createProduk()
    {
        // Cara 1: Admin/Kasir input kode manual
        $produk1 = Produk::create([
            'kode_produk' => 'PRD-CUSTOM', // Input manual
            'nama_produk' => 'Laptop Dell',
            'harga' => 5000000,
            'stok' => 10,
            'id_kategori' => 1
        ]);
        // Output: kode_produk = 'PRD-CUSTOM'

        // Cara 2: Auto-generate kode otomatis
        $produk2 = Produk::create([
            // kode_produk dihilangkan, akan auto-generate
            'nama_produk' => 'Mouse Logitech',
            'harga' => 250000,
            'stok' => 50,
            'id_kategori' => 1
        ]);
        // Output: kode_produk = 'PRD-0002' (auto-generated)
    }

    /**
     * PENJUALAN - Buat penjualan dengan nomor manual atau auto-generate
     */
    public function createPenjualan()
    {
        // Cara 1: Kasir input nomor manual
        $penjualan1 = Penjualan::create([
            'kode_jual' => 'PJL-2026-0001-CUSTOM', // Input manual
            'id_user' => 1,
            'tanggal_jual' => date('Y-m-d'),
            'nama_pembeli' => 'Budi Santoso',
            'no_hp' => '08123456789',
            'total_jual' => 5250000,
            'metode_bayar' => 'Cash',
            'status_bayar' => 'Lunas'
        ]);
        // Output: kode_jual = 'PJL-2026-0001-CUSTOM'

        // Cara 2: Auto-generate nomor otomatis (format: PJL-20260430-001)
        $penjualan2 = Penjualan::create([
            // kode_jual dihilangkan, akan auto-generate
            'id_user' => 1,
            'tanggal_jual' => date('Y-m-d'),
            'nama_pembeli' => 'Siti Nurhaliza',
            'no_hp' => '08987654321',
            'total_jual' => 3500000,
            'metode_bayar' => 'Transfer',
            'status_bayar' => 'Belum Lunas'
        ]);
        // Output: kode_jual = 'PJL-20260430-001' (auto-generated dengan tanggal)
    }

    /**
     * PENERIMAAN KAS - Buat terima kas dengan kode manual atau auto-generate
     */
    public function createTerimaKas()
    {
        // Cara 1: Kasir input kode terima kas manual
        $terimakas1 = PenerimaanKas::create([
            'kode_terimakas' => 'TRK-CUSTOM-001', // Input manual
            'id_jual' => 1,
            'tgl_terimakas' => date('Y-m-d'),
            'jmlh_terimakas' => 5250000,
            'keterangan' => 'Pembayaran tunai'
        ]);
        // Output: kode_terimakas = 'TRK-CUSTOM-001'

        // Cara 2: Auto-generate kode otomatis (format: TRK-20260430-001)
        $terimakas2 = PenerimaanKas::create([
            // kode_terimakas dihilangkan, akan auto-generate
            'id_jual' => 2,
            'tgl_terimakas' => date('Y-m-d'),
            'jmlh_terimakas' => 2500000,
            'keterangan' => 'Pembayaran sebagian'
        ]);
        // Output: kode_terimakas = 'TRK-20260430-001' (auto-generated dengan tanggal)
    }

    /**
     * ============================================
     * VALIDASI DI FORM REQUEST
     * ============================================
     * 
     * Saat membuat form di controller/view, Anda dapat:
     * 1. Biarkan field kosong → kode auto-generate
     * 2. Input kode manual → validasi unique
     * 
     * Contoh validation rules:
     */
    public function validationRules()
    {
        return [
            // Untuk Kategori
            'kode_kategori' => 'nullable|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required|string|max:255',

            // Untuk Produk
            'kode_produk' => 'nullable|unique:produks,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'required|exists:kategoris,id_kategori',

            // Untuk Penjualan
            'kode_jual' => 'nullable|unique:penjualans,kode_jual',
            'id_user' => 'required|exists:users,id_user',
            'tanggal_jual' => 'required|date',
            'total_jual' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:Cash,Transfer,Kartu Kredit,SpayLater,Akulaku,Kredivo,GopayLater',

            // Untuk Penerimaan Kas
            'kode_terimakas' => 'nullable|unique:penerimaan_kas,kode_terimakas',
            'id_jual' => 'required|exists:penjualans,id_jual',
            'tgl_terimakas' => 'required|date',
            'jmlh_terimakas' => 'required|numeric|min:0'
        ];
    }

    /**
     * ============================================
     * AUTO-GENERATE KODE MANUAL
     * ============================================
     * 
     * Jika ingin generate kode secara manual:
     */
    public function manualGenerate()
    {
        // Generate kode kategori
        $kodeKategori = CodeGenerator::generateKodeKategori();
        // Output: 'KTG-001', 'KTG-002', dst

        // Generate kode produk
        $kodeProduk = CodeGenerator::generateIdProduk();
        // Output: 'PRD-0001', 'PRD-0002', dst

        // Generate nomor penjualan
        $noPenjualan = CodeGenerator::generateIdJual();
        // Output: 'PJL-20260430-001', 'PJL-20260430-002', dst

        // Generate kode terima kas
        $kodeTerimaKas = CodeGenerator::generateKodeTerimaKas();
        // Output: 'TRK-20260430-001', 'TRK-20260430-002', dst

        return [
            'kodeKategori' => $kodeKategori,
            'kodeProduk' => $kodeProduk,
            'noPenjualan' => $noPenjualan,
            'kodeTerimaKas' => $kodeTerimaKas
        ];
    }
}

/**
 * ============================================
 * RINGKASAN
 * ============================================
 * 
 * ✅ TABEL KATEGORI
 *    - Kolom: kode_kategori (unique)
 *    - Format: KTG-001, KTG-002, dst
 *    - Admin bisa input manual atau auto-generate
 *
 * ✅ TABEL PRODUK
 *    - Kolom: kode_produk (unique)
 *    - Format: PRD-0001, PRD-0002, dst
 *    - Admin bisa input manual atau auto-generate
 *
 * ✅ TABEL PENJUALAN
 *    - Kolom: no_penjualan (unique)
 *    - Format: PJL-20260430-001 (dengan tanggal)
 *    - Kasir bisa input manual atau auto-generate
 *
 * ✅ TABEL PENERIMAAN KAS
 *    - Kolom: kode_terimakas (unique)
 *    - Format: TRK-20260430-001 (dengan tanggal)
 *    - Kasir bisa input manual atau auto-generate
 *
 * ============================================
 */
