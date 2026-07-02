<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';
    protected $primaryKey = 'id_produk'; // ✅ SESUAI DATABASE
    public $incrementing = false; // ✅ Teks, bukan angka
    protected $keyType = 'string'; // ✅ Tipe teks

    protected $fillable = [
        'id_produk',    // ✅ Kunci utama
        'nama_produk',
        'harga',
        'stok',
        'gambar',
        'kode_kategori' // ✅ Kunci asing ke kategori
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // ✅ OTOMATIS GENERATE KODE PRODUK
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_produk)) {
                // Panggil generator kita
                $model->id_produk = \App\Helpers\CodeGenerator::generateKodeProduk();
            }
        });
    }

    // ==============================================
    // ✅ RELASI KE KATEGORI (DIPERBAIKI SESUAI KAMU)
    // ==============================================
    public function kategori()
    {
        // Kamu pakai kode_kategori, BUKAN id_kategori
        return $this->belongsTo(Kategori::class, 'kode_kategori', 'kode_kategori');
    }

    // ==============================================
    // 🔥 TAMBAHAN BARU: RELASI KE DETAIL PENJUALAN
    // ==============================================
    // Ini yang DICARI SISTEM untuk Laporan Produk Terlaris
    public function details()
    {
        // 'id_produk' di tabel detail_penjualans -> merujuk ke 'id_produk' di tabel produks
        return $this->hasMany(DetailPenjualan::class, 'id_produk', 'id_produk');
    }
}