<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukVarian extends Model
{
    protected $table = 'produk_varian';

    protected $fillable = [
        'id_produk',
        'ram',
        'storage',
        'warna',
        'harga',
        'stok'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}