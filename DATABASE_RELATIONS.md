# 📊 RELASI ANTAR TABEL - KEZ iStore

## 🗂️ STRUKTUR TABEL & RELASI

```
┌─────────────────────────────────────────────────────────────┐
│                     DIAGRAM RELASI                          │
└─────────────────────────────────────────────────────────────┘

                          ┌──────────────────┐
                          │      USERS       │
                          │  (id_user - PK)  │
                          └────────┬─────────┘
                                   │
                    ┌──────────────┼──────────────┐
                    │              │              │
                    ▼              ▼              ▼
            ┌──────────────┐ ┌──────────────┐ ┌────────────────┐
            │ PENJUALANS   │ │ACTIVITY_LOGS │ │PENERIMAAN_KAS? │
            │(id_jual-PK)  │ │ (id_log-PK)  │ │   (FK→JUAL)    │
            └──────┬───────┘ └──────────────┘ └────────────────┘
                   │
       ┌───────────┴───────────┐
       │                       │
       ▼                       ▼
┌────────────────────┐  ┌──────────────────┐
│DETAIL_PENJUALANS   │  │PENERIMAAN_KAS    │
│ (id_detailjual-PK) │  │(id_terimakas-PK) │
│      (FK→JUAL)     │  │   (FK→JUAL)      │
└────────┬───────────┘  └──────────────────┘
         │
         ▼
    ┌─────────────────────┐
    │  PRODUKS            │
    │ (id_produk - PK)    │
    │    (FK→KATEGORI)    │
    └────────┬────────────┘
             │
             ▼
    ┌─────────────────────┐
    │  KATEGORIS          │
    │(id_kategori - PK)   │
    └─────────────────────┘
```

---

## 📋 DETAIL RELASI SETIAP TABEL

### 1️⃣ **USERS** (Tabel Utama)
**Primary Key:** `id_user`
**Kolom:** nama, username, email, password, jabatan (admin/kasir), foto

**Relasi Ke:**
- ➡️ **PENJUALANS** (1 User → Many Penjualan)
  - Foreign Key: `id_user` di tabel `penjualans`
  - Cascade On Delete ✅
  
- ➡️ **ACTIVITY_LOGS** (1 User → Many Activity Logs)
  - Foreign Key: `id_user` di tabel `activity_logs`
  - Cascade On Delete ✅

```php
// Model User.php
public function penjualans() {
    return $this->hasMany(Penjualan::class, 'id_user', 'id_user');
}

public function activityLogs() {
    return $this->hasMany(ActivityLog::class, 'id_user', 'id_user');
}
```

---

### 2️⃣ **KATEGORIS** (Master Data)
**Primary Key:** `id_kategori`
**Kolom:** kode_kategori (unique), nama_kategori

**Relasi Ke:**
- ➡️ **PRODUKS** (1 Kategori → Many Produk)
  - Foreign Key: `id_kategori` di tabel `produks`
  - Cascade On Delete ✅

```php
// Model Kategori.php
public function produks() {
    return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
}
```

---

### 3️⃣ **PRODUKS** (Master Data)
**Primary Key:** `id_produk`
**Kolom:** kode_produk (unique), nama_produk, harga, stok, gambar, id_kategori (FK)

**Relasi Dari:**
- ⬅️ **KATEGORIS** (Many Produk → 1 Kategori)
  - Foreign Key: `id_kategori` → references `kategoris.id_kategori`

**Relasi Ke:**
- ➡️ **DETAIL_PENJUALANS** (1 Produk → Many Detail Penjualan)
  - Foreign Key: `id_produk` di tabel `detail_penjualans`
  - Cascade On Delete ✅

```php
// Model Produk.php
public function kategori() {
    return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
}

public function details() {
    return $this->hasMany(DetailPenjualan::class, 'id_produk', 'id_produk');
}
```

---

### 4️⃣ **PENJUALANS** (Transaksi Utama)
**Primary Key:** `id_jual`
**Kolom:** kode_jual (unique), id_user (FK), tanggal_jual, nama_pembeli, no_hp, total_jual, metode_bayar, bukti_bayar, status_bayar

**Relasi Dari:**
- ⬅️ **USERS** (Many Penjualan → 1 User)
  - Foreign Key: `id_user` → references `users.id_user`

**Relasi Ke:**
- ➡️ **DETAIL_PENJUALANS** (1 Penjualan → Many Detail Penjualan)
  - Foreign Key: `id_jual` di tabel `detail_penjualans`
  - Cascade On Delete ✅

- ➡️ **PENERIMAAN_KAS** (1 Penjualan → Many Penerimaan Kas)
  - Foreign Key: `id_jual` di tabel `penerimaan_kas`
  - Cascade On Delete ✅

```php
// Model Penjualan.php
public function user() {
    return $this->belongsTo(User::class, 'id_user', 'id_user');
}

public function details() {
    return $this->hasMany(DetailPenjualan::class, 'id_jual');
}
```

---

### 5️⃣ **DETAIL_PENJUALANS** (Item Penjualan)
**Primary Key:** `id_detailjual`
**Kolom:** id_jual (FK), id_produk (FK), jumlah, harga, subtotal

**Relasi Dari:**
- ⬅️ **PENJUALANS** (Many Detail → 1 Penjualan)
  - Foreign Key: `id_jual` → references `penjualans.id_jual`
  - Cascade On Delete ✅

- ⬅️ **PRODUKS** (Many Detail → 1 Produk)
  - Foreign Key: `id_produk` → references `produks.id_produk`
  - Cascade On Delete ✅

```php
// Model DetailPenjualan.php
public function penjualan() {
    return $this->belongsTo(Penjualan::class, 'id_jual', 'id_jual');
}

public function produk() {
    return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
}
```

---

### 6️⃣ **PENERIMAAN_KAS** (Pembayaran)
**Primary Key:** `id_terimakas`
**Kolom:** kode_terimakas (unique), id_jual (FK), tgl_terimakas, jmlh_terimakas, keterangan

**Relasi Dari:**
- ⬅️ **PENJUALANS** (Many Penerimaan Kas → 1 Penjualan)
  - Foreign Key: `id_jual` → references `penjualans.id_jual`
  - Cascade On Delete ✅

```php
// Model PenerimaanKas.php
public function penjualan() {
    return $this->belongsTo(Penjualan::class, 'id_jual');
}

public function kasir() {
    return $this->penjualan()->user();
}
```

---

### 7️⃣ **ACTIVITY_LOGS** (Audit Trail)
**Primary Key:** `id_log`
**Kolom:** id_user (FK), menu, aktivitas, keterangan, ip_address, user_agent

**Relasi Dari:**
- ⬅️ **USERS** (Many Activity Log → 1 User)
  - Foreign Key: `id_user` → references `users.id_user`
  - Cascade On Delete ✅

```php
// Model ActivityLog.php
public function user() {
    return $this->belongsTo(User::class, 'id_user', 'id_user');
}
```

---

## 🔄 RINGKASAN RELASI

| Dari | Ke | Tipe | Foreign Key | Cascade |
|------|-----|------|--------------|---------|
| **USERS** | PENJUALANS | 1:M | id_user | ✅ |
| **USERS** | ACTIVITY_LOGS | 1:M | id_user | ✅ |
| **KATEGORIS** | PRODUKS | 1:M | id_kategori | ✅ |
| **PRODUKS** | DETAIL_PENJUALANS | 1:M | id_produk | ✅ |
| **PENJUALANS** | DETAIL_PENJUALANS | 1:M | id_jual | ✅ |
| **PENJUALANS** | PENERIMAAN_KAS | 1:M | id_jual | ✅ |

---

## 💡 ALUR DATA

### 📱 Alur Penjualan (POS)
```
KASIR LOGIN (User)
    ↓
BUKA HALAMAN POS
    ↓
PILIH PRODUK (dari tabel PRODUKS → KATEGORIS)
    ↓
TAMBAH KE KERANJANG (session)
    ↓
CHECKOUT → CREATE PENJUALAN
    ↓
DETAIL PENJUALAN (CREATE dalam DETAIL_PENJUALANS)
    ↓
UPDATE STOK PRODUK
    ↓
PEMBAYARAN:
  ├─ CASH → Status "Lunas" → CREATE PENERIMAAN_KAS
  └─ NON-CASH → Status "Belum Lunas" → Tunggu Verifikasi
```

### 💰 Alur Pembayaran (Non-Cash)
```
PENJUALAN (Status: Belum Lunas)
    ↓
KASIR/ADMIN VERIFIKASI PEMBAYARAN
    ↓
UPDATE PENJUALAN (Status: Lunas)
    ↓
CREATE PENERIMAAN_KAS (Catat nominal yang diterima)
```

### 📝 Audit Trail
```
Setiap ACTION (Login, Tambah Produk, Checkout, dll)
    ↓
ACTIVITY_LOGS dicatat dengan:
  ├─ id_user (Siapa yang melakukan)
  ├─ aktivitas (Apa yang dilakukan)
  ├─ keterangan (Detail tambahan)
  └─ timestamp (Kapan dilakukan)
```

---

## ⚠️ PENTING: CASCADE ON DELETE

Semua relasi foreign key menggunakan **CASCADE ON DELETE**, artinya:
- Jika **User dihapus** → Semua Penjualan & Activity Logs-nya ikut terhapus
- Jika **Kategori dihapus** → Semua Produk-nya ikut terhapus
- Jika **Penjualan dihapus** → Semua Detail Penjualan & Penerimaan Kas-nya ikut terhapus
- Jika **Produk dihapus** → Semua Detail Penjualan-nya ikut terhapus

---

## 📊 ENTITY RELATIONSHIP DIAGRAM (ERD)

```sql
-- PRIMARY KEYS & FOREIGN KEYS
USERS
  - id_user (PK)
  
KATEGORIS
  - id_kategori (PK)

PRODUKS
  - id_produk (PK)
  - id_kategori (FK → KATEGORIS)

PENJUALANS
  - id_jual (PK)
  - id_user (FK → USERS)

DETAIL_PENJUALANS
  - id_detailjual (PK)
  - id_jual (FK → PENJUALANS)
  - id_produk (FK → PRODUKS)

PENERIMAAN_KAS
  - id_terimakas (PK)
  - id_jual (FK → PENJUALANS)

ACTIVITY_LOGS
  - id_log (PK)
  - id_user (FK → USERS)
```

---

**Dibuat:** 22 Mei 2026
**Versi:** 1.0
