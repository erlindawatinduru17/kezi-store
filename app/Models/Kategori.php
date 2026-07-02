<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'kode_kategori'; // ✅ SESUAI
    public $incrementing = false; // ✅ Bukan angka otomatis
    protected $keyType = 'string'; // ✅ Tipe teks

    protected $fillable = [
        'kode_kategori',
        'nama_kategori'
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->kode_kategori)) {
                $model->kode_kategori = \App\Helpers\CodeGenerator::generateKodeKategori();
            }
        });
    }

    // Relasi ke Produk
    public function produks()
    {
        return $this->hasMany(Produk::class, 'kode_kategori', 'kode_kategori');
    }
}