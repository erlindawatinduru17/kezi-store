<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CodeGenerator;

class PenerimaanKas extends Model
{
    protected $table = 'penerimaan_kas';

    // ✅ Primary Key sebagai teks, bukan angka
    protected $primaryKey = 'kode_terimakas';
    public $incrementing = false;       // Matikan auto-increment angka
    protected $keyType = 'string';      // Tipe data teks/VARCHAR

    // ✅ Masukkan kode_terimakas agar bisa disimpan
    protected $fillable = [
        'kode_terimakas',
        'kode_jual',
        'tgl_terimakas',
        'jmlh_terimakas',
        'keterangan'
    ];

    // ✅ Otomatis buat kode TRK sebelum disimpan
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Buat kode hanya jika belum ada isinya
            if (empty($model->kode_terimakas)) {
                $model->kode_terimakas = CodeGenerator::generateKodeTerimaKas();
            }

            // Isi tanggal otomatis jika kosong
            if (!$model->tgl_terimakas) {
                $model->tgl_terimakas = now();
            }
        });
    }

    // ========================
    // RELASI
    // ========================
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'kode_jual', 'kode_jual');
    }

    // ========================
    // HELPER
    // ========================
    public function getTanggalFormattedAttribute()
    {
        return $this->tgl_terimakas ? $this->tgl_terimakas->format('d M Y') : '-';
    }

    public function getJumlahFormattedAttribute()
    {
        return 'Rp ' . number_format($this->jmlh_terimakas, 0, ',', '.');
    }
}