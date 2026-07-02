# 📋 DOKUMENTASI SISTEM KODE INPUT - KeziStore

## 🎯 Fitur Kode Input

Sistem ini memungkinkan **Admin/Kasir** untuk:
1. **Input kode manual** untuk setiap tabel
2. **Auto-generate kode** jika tidak diisi

---

## 📊 Struktur Database Terbaru

### 1️⃣ Tabel KATEGORIS
```
┌─────────────────────────────────────┐
│ kategoris                           │
├─────────────────────────────────────┤
│ id_kategori (PK)                    │
│ kode_kategori (UNIQUE) ← Input      │
│ nama_kategori                       │
│ created_at, updated_at              │
└─────────────────────────────────────┘

Format Kode: KTG-001, KTG-002, ...
```

### 2️⃣ Tabel PRODUKS
```
┌─────────────────────────────────────┐
│ produks                             │
├─────────────────────────────────────┤
│ id_produk (PK)                      │
│ kode_produk (UNIQUE) ← Input        │
│ nama_produk                         │
│ harga, stok, gambar                 │
│ id_kategori (FK)                    │
│ created_at, updated_at              │
└─────────────────────────────────────┘

Format Kode: PRD-0001, PRD-0002, ...
```

### 3️⃣ Tabel PENJUALANS
```
┌─────────────────────────────────────┐
│ penjualans                          │
├─────────────────────────────────────┤
│ id_jual (PK)                        │
│ no_penjualan (UNIQUE) ← Input       │
│ id_user (FK)                        │
│ tanggal_jual, nama_pembeli, no_hp   │
│ total_jual, metode_bayar            │
│ bukti_bayar, status_bayar           │
│ created_at, updated_at              │
└─────────────────────────────────────┘

Format Kode: PJL-20260430-001, PJL-20260430-002, ...
(Format: PJL-YYYYMMDD-###)
```

### 4️⃣ Tabel PENERIMAAN_KAS
```
┌─────────────────────────────────────┐
│ penerimaan_kas                      │
├─────────────────────────────────────┤
│ id_terimakas (PK)                   │
│ kode_terimakas (UNIQUE) ← Input     │
│ id_jual (FK)                        │
│ tgl_terimakas, jmlh_terimakas       │
│ keterangan                          │
│ created_at, updated_at              │
└─────────────────────────────────────┘

Format Kode: TRK-20260430-001, TRK-20260430-002, ...
(Format: TRK-YYYYMMDD-###)
```

---

## 🚀 Cara Penggunaan

### ✅ Opsi 1: Admin/Kasir Input Kode Manual

```php
// Kategori
Kategori::create([
    'kode_kategori' => 'KTG-CUSTOM', // Input manual
    'nama_kategori' => 'Elektronik'
]);

// Produk
Produk::create([
    'kode_produk' => 'PRD-CUSTOM', // Input manual
    'nama_produk' => 'Laptop',
    'harga' => 5000000,
    'stok' => 10,
    'id_kategori' => 1
]);

// Penjualan
Penjualan::create([
    'no_penjualan' => 'PJL-CUSTOM-001', // Input manual
    'id_user' => 1,
    'tanggal_jual' => '2026-04-30',
    'nama_pembeli' => 'Budi Santoso',
    'total_jual' => 5000000,
    'metode_bayar' => 'Cash',
    'status_bayar' => 'Lunas'
]);

// Penerimaan Kas
PenerimaanKas::create([
    'kode_terimakas' => 'TRK-CUSTOM-001', // Input manual
    'id_jual' => 1,
    'tgl_terimakas' => '2026-04-30',
    'jmlh_terimakas' => 5000000,
    'keterangan' => 'Pembayaran tunai'
]);
```

### ✅ Opsi 2: Auto-Generate Kode (Rekomendasi)

```php
// Kategori - Auto-generate
Kategori::create([
    // kode_kategori TIDAK ada → auto-generate ke KTG-001, KTG-002, dst
    'nama_kategori' => 'Fashion'
]);

// Produk - Auto-generate
Produk::create([
    // kode_produk TIDAK ada → auto-generate ke PRD-0001, PRD-0002, dst
    'nama_produk' => 'Mouse',
    'harga' => 250000,
    'stok' => 50,
    'id_kategori' => 1
]);

// Penjualan - Auto-generate dengan tanggal
Penjualan::create([
    // no_penjualan TIDAK ada → auto-generate ke PJL-20260430-001, dst
    'id_user' => 1,
    'tanggal_jual' => date('Y-m-d'),
    'nama_pembeli' => 'Siti Nurhaliza',
    'total_jual' => 3500000,
    'metode_bayar' => 'Transfer',
    'status_bayar' => 'Belum Lunas'
]);

// Penerimaan Kas - Auto-generate dengan tanggal
PenerimaanKas::create([
    // kode_terimakas TIDAK ada → auto-generate ke TRK-20260430-001, dst
    'id_jual' => 1,
    'tgl_terimakas' => date('Y-m-d'),
    'jmlh_terimakas' => 2500000,
    'keterangan' => 'Pembayaran sebagian'
]);
```

---

## 🎯 Auto-Generate Kode Manual

Jika perlu generate kode secara manual di controller:

```php
use App\Helpers\CodeGenerator;

// Generate kode
$kodeKategori = CodeGenerator::generateKodeKategori();    // KTG-001
$kodeProduk = CodeGenerator::generateKodeProduk();        // PRD-0001
$noPenjualan = CodeGenerator::generateNoPenjualan();      // PJL-20260430-001
$kodeTerimaKas = CodeGenerator::generateKodeTerimaKas(); // TRK-20260430-001

// Gunakan di form atau API response
return [
    'suggested_kode_kategori' => $kodeKategori,
    'suggested_kode_produk' => $kodeProduk,
    'suggested_no_penjualan' => $noPenjualan,
    'suggested_kode_terimakas' => $kodeTerimaKas
];
```

---

## 📝 Form Validation

File request validation sudah siap di: `app/Http/Requests/CreateFormRequests.php`

```php
// Untuk Kategori
'kode_kategori' => 'nullable|unique:kategoris,kode_kategori',

// Untuk Produk
'kode_produk' => 'nullable|unique:produks,kode_produk',

// Untuk Penjualan
'no_penjualan' => 'nullable|unique:penjualans,no_penjualan',

// Untuk Penerimaan Kas
'kode_terimakas' => 'nullable|unique:penerimaan_kas,kode_terimakas',
```

---

## 🔧 Boot Method (Auto-Generate)

Setiap model sudah memiliki boot method untuk auto-generate kode:

```php
// File: app/Models/Kategori.php, Produk.php, Penjualan.php, PenerimaanKas.php

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->kode_field)) {
            $model->kode_field = CodeGenerator::generateKode();
        }
    });
}
```

**Cara kerjanya:**
- Saat record baru dibuat
- Jika field kode kosong → auto-generate
- Jika field kode ada nilai → gunakan nilai yang di-input

---

## 📂 File-File Penting

| File | Fungsi |
|------|--------|
| `app/Helpers/CodeGenerator.php` | Generate kode otomatis |
| `app/Helpers/CodeDocumentation.php` | Dokumentasi penggunaan |
| `app/Http/Requests/CreateFormRequests.php` | Form validation |
| `app/Models/Kategori.php` | Model dengan boot method |
| `app/Models/Produk.php` | Model dengan boot method |
| `app/Models/Penjualan.php` | Model dengan boot method |
| `app/Models/PenerimaanKas.php` | Model dengan boot method |

---

## ✨ Fitur Lengkap

✅ **Tabel KATEGORIS**
- ✓ Kolom `kode_kategori` (unique)
- ✓ Format: KTG-001, KTG-002, dst
- ✓ Bisa input manual atau auto-generate

✅ **Tabel PRODUKS**
- ✓ Kolom `kode_produk` (unique)
- ✓ Format: PRD-0001, PRD-0002, dst
- ✓ Bisa input manual atau auto-generate

✅ **Tabel PENJUALANS**
- ✓ Kolom `no_penjualan` (unique)
- ✓ Format: PJL-20260430-001 (dengan tanggal)
- ✓ Bisa input manual atau auto-generate
- ✓ Nomor auto-increment per hari

✅ **Tabel PENERIMAAN_KAS**
- ✓ Kolom `kode_terimakas` (unique)
- ✓ Format: TRK-20260430-001 (dengan tanggal)
- ✓ Bisa input manual atau auto-generate
- ✓ Nomor auto-increment per hari

---

## 🎓 Contoh di Controller

```php
// Di dalam KategoriController
public function store(Request $request)
{
    $kategori = Kategori::create([
        'kode_kategori' => $request->kode_kategori ?? null, // Bisa null
        'nama_kategori' => $request->nama_kategori
    ]);
    // Jika kode_kategori null → auto-generate
    // Jika kode_kategori ada → gunakan nilai input
}
```

---

## 📞 Support

Untuk bantuan atau pertanyaan, silakan periksa:
1. `app/Helpers/CodeDocumentation.php` - Dokumentasi lengkap dengan contoh
2. `app/Http/Requests/CreateFormRequests.php` - Validation rules
3. `app/Helpers/CodeGenerator.php` - Logika generate kode

---

**Status: ✅ READY TO USE**
Database sudah di-migrate dan siap menerima input kode dari admin/kasir!
