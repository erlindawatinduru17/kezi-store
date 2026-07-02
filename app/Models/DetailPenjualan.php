<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualans';
    protected $primaryKey = 'id_detailjual';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'kode_jual',
        'id_produk',
        'jumlah',
        'harga',
        'subtotal'
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    // ========================
    // RELATIONSHIPS
    // ========================
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'kode_jual', 'kode_jual');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    // ========================
    // HELPER METHODS
    // ========================

    /**
     * Format harga untuk display
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Format subtotal untuk display
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Hitung total dengan format
     */
    public function getTotalFormatted()
    {
        return number_format($this->subtotal, 0, ',', '.');
    }
}