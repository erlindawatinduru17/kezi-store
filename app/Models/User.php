<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // =========================
    // TETAP SAMA SEPERTI AWAL
    // =========================
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'nama',
        'username',
        'email',
        'password',
        'jabatan',
        'foto'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->jabatan === 'admin';
    }

    public function isKasir()
    {
        return $this->jabatan === 'kasir';
    }

    // =========================
    // ✅ DIPERBAIKI: BISA BACA DARI FOLDER BERBEDA TANPA MENGUBAH PENYIMPANAN
    // =========================
    // Tambahkan kode ini di dalam Model User
public function getFotoUrlAttribute()
{
    if (empty($this->foto)) {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&size=150&background=random';
    }

    // 1. Jika berupa URL lengkap
    if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
        return $this->foto;
    }

    // 2. Cek di folder Profile yang asli: public/foto/
    if (file_exists(public_path('foto/' . $this->foto))) {
        return asset('foto/' . $this->foto);
    }

    // 3. Cek di folder User: storage/app/public/user/
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->foto)) {
        return asset('storage/' . $this->foto);
    }

    // 4. Cek di folder umum lain di public
    if (file_exists(public_path($this->foto))) {
        return asset($this->foto);
    }

    // Jika tidak ditemukan di mana pun
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&size=150&background=random';
}

    // =========================
    // RELASI TETAP SAMA
    // =========================
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'id_user', 'id_user');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'id_user', 'id_user');
    }
}