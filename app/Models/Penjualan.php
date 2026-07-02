<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CodeGenerator;

class Penjualan extends Model
{
    protected $table = 'penjualans';
    // ✅ DIPERBAIKI: Primary key sesuai database
    protected $primaryKey = 'kode_jual';
    public $incrementing = false; // ✅ Bukan angka otomatis
    protected $keyType = 'string'; // ✅ Tipe teks

    protected $fillable = [
        'kode_jual',
        'id_user',
        'tanggal_jual',
        'nama_pembeli',
        'total_jual',
        'metode_bayar',
        'bukti_bayar',
        'status_bayar',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_jual' => 'datetime',
        'total_jual' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_jual)) {
                $model->kode_jual = CodeGenerator::generateNomorPenjualan();
            }

            if (!$model->tanggal_jual) {
                $model->tanggal_jual = now();
            }
        });
    }

    // ========================
    // RELATIONSHIPS
    // ========================
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function details()
    {
        // ✅ DIPERBAIKI: Gunakan kode_jual
        return $this->hasMany(DetailPenjualan::class, 'kode_jual', 'kode_jual');
    }

    public function penerimaanKas()
    {
        // ✅ DIPERBAIKI: Gunakan kode_jual
        return $this->hasMany(PenerimaanKas::class, 'kode_jual', 'kode_jual');
    }

    // ========================
    // HELPER METHODS
    // ========================
    
    /**
     * Apakah transaksi sudah lunas?
     */
    public function isLunas()
    {
        return $this->status_bayar === 'Lunas';
    }

    /**
     * Apakah transaksi menunggu pembayaran?
     */
    public function isPending()
    {
        return $this->status_bayar === 'Belum Lunas';
    }

    /**
     * Apakah transaksi pembayaran sebagian?
     */
    public function isPartial()
    {
        return $this->status_bayar === 'Sebagian';
    }

    /**
     * Hitung total item yang dibeli
     */
    public function getTotalItemsAttribute()
    {
        return $this->details()->sum('jumlah');
    }

    /**
     * Hitung jumlah pembayaran yang sudah masuk
     */
    public function getTotalPaidAttribute()
    {
        return $this->penerimaanKas()->sum('jmlh_terimakas') ?? 0;
    }

    /**
     * Hitung sisa pembayaran
     */
    public function getRemainderAttribute()
    {
        $paid = $this->penerimaanKas()->sum('jmlh_terimakas') ?? 0;
        return $this->total_jual - $paid;
    }

    /**
     * Ubah status pembayaran ke lunas
     */
    public function markAsLunas($keterangan = 'Verifikasi pembayaran')
    {
        if ($this->isLunas()) {
            return false; // Sudah lunas sebelumnya
        }

        $this->update(['status_bayar' => 'Lunas']);

        // Jika belum ada penerimaan kas, buat baru
        if ($this->penerimaanKas()->count() == 0) {
            PenerimaanKas::create([
                // ✅ DIPERBAIKI: Gunakan kode_jual
                'kode_jual'        => $this->kode_jual,
                'tgl_terimakas'  => now(),
                'jmlh_terimakas' => $this->total_jual,
                'keterangan'     => $keterangan
            ]);
        }

        return true;
    }

    /**
     * Format tanggal untuk display
     */
    public function getFormattedDateAttribute()
    {
        return $this->tanggal_jual ? $this->tanggal_jual->format('d M Y H:i') : '-';
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->isLunas()) {
            return 'badge-success';
        } elseif ($this->isPartial()) {
            return 'badge-warning';
        }
        return 'badge-danger';
    }

    /**
     * Get payment method label
     */
    public function getPaymentMethodLabelAttribute()
    {
        $methods = [
            'Cash' => '💵 Cash',
            'Transfer' => '🏦 Transfer',
            'Kartu Kredit' => '💳 Kartu Kredit',
            'SpayLater' => '📱 SpayLater',
            'Akulaku' => '📱 Akulaku',
            'Kredivo' => '📱 Kredivo',
            'GopayLater' => '📱 GopayLater'
        ];

        return $methods[$this->metode_bayar] ?? $this->metode_bayar;
    }
}