# 📊 ATRIBUT & TYPE DATA - KEZ iStore

## 1️⃣ TABEL: USERS

**Primary Key:** `id_user` (BIGINT - Auto Increment)

| Kolom | Type Data | Constraint | Keterangan |
|-------|-----------|-----------|-----------|
| `id_user` | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| `nama` | VARCHAR(255) | NOT NULL | Nama User (Admin/Kasir) |
| `username` | VARCHAR(255) | UNIQUE, NOT NULL | Username untuk login |
| `email` | VARCHAR(255) | UNIQUE, NULLABLE | Email (opsional) |
| `password` | VARCHAR(255) | NOT NULL | Password ter-hash |
| `jabatan` | ENUM | NOT NULL | Pilihan: `admin`, `kasir` |
| `foto` | VARCHAR(255) | NULLABLE | Path ke file foto profil |
| `created_at` | TIMESTAMP | NOT NULL | Tanggal buat record |
| `updated_at` | TIMESTAMP | NOT NULL | Tanggal update record |

**Relasi:**
- ➡️ PENJUALANS (1:M) - Foreign Key `id_user`
- ➡️ ACTIVITY_LOGS (1:M) - Foreign Key `id_user`

**Contoh Data:**
```sql
INSERT INTO users (nama, username, email, password, jabatan, created_at, updated_at)
VALUES 
('Admin Kezi', 'admin', 'admin@kezistore.com', 'hashed_password', 'admin', NOW(), NOW()),
('Kasir Joni', 'joni', 'joni@kezistore.com', 'hashed_password', 'kasir', NOW(), NOW());
```

---

## 2️⃣ TABEL: KATEGORIS

**Primary Key:** `id_kategori` (BIGINT - Auto Increment)

| Kolom | Type Data | Constraint | Keterangan |
|-------|-----------|-----------|-----------|
| `id_kategori` | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| `kode_kategori` | VARCHAR(255) | UNIQUE, NOT NULL | Kode kategori (auto-generate) |
| `nama_kategori` | VARCHAR(255) | NOT NULL | Nama kategori produk |
| `created_at` | TIMESTAMP | NOT NULL | Tanggal buat record |
| `updated_at` | TIMESTAMP | NOT NULL | Tanggal update record |

**Relasi:**
- ➡️ PRODUKS (1:M) - Foreign Key `id_kategori`

**Contoh Data:**
```sql
INSERT INTO kategoris (kode_kategori, nama_kategori, created_at, updated_at)
VALUES 
('KAT-001', 'Elektronik', NOW(), NOW()),
('KAT-002', 'Fashion', NOW(), NOW()),
('KAT-003', 'Makanan & Minuman', NOW(), NOW());
```

---

## 3️⃣ TABEL: PRODUKS

**Primary Key:** `id_produk` (BIGINT - Auto Increment)

| Kolom | Type Data | Constraint | Keterangan |
|-------|-----------|-----------|-----------|
| `id_produk` | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| `kode_produk` | VARCHAR(255) | UNIQUE, NULLABLE | Kode produk (auto-generate) |
| `nama_produk` | VARCHAR(255) | NOT NULL | Nama produk |
| `harga` | DECIMAL(10,2) | NOT NULL | Harga jual produk |
| `stok` | INTEGER | NOT NULL | Jumlah stok produk |
| `gambar` | VARCHAR(255) | NULLABLE | Path ke file gambar |
| `id_kategori` | BIGINT | FK, NOT NULL | Referensi ke KATEGORIS |
| `created_at` | TIMESTAMP | NOT NULL | Tanggal buat record |
| `updated_at` | TIMESTAMP | NOT NULL | Tanggal update record |

**Foreign Key:**
- `id_kategori` ➡️ KATEGORIS.id_kategori (CASCADE ON DELETE)

**Relasi:**
- ⬅️ KATEGORIS (M:1) - Foreign Key `id_kategori`
- ➡️ DETAIL_PENJUALANS (1:M) - Foreign Key `id_produk`

**Contoh Data:**
```sql
INSERT INTO produks (kode_produk, nama_produk, harga, stok, id_kategori, created_at, updated_at)
VALUES 
('PRD-001', 'Headphone Wireless', 299000, 50, 1, NOW(), NOW()),
('PRD-002', 'T-Shirt Pria', 89000, 150, 2, NOW(), NOW()),
('PRD-003', 'Kopi Arabika 1kg', 149000, 60, 3, NOW(), NOW());
```

---

## 4️⃣ TABEL: PENJUALANS

**Primary Key:** `id_jual` (BIGINT - Auto Increment)

| Kolom | Type Data | Constraint | Keterangan |
|-------|-----------|-----------|-----------|
| `id_jual` | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| `kode_jual` | VARCHAR(255) | UNIQUE, NULLABLE | Kode penjualan (PJ-YYYYMMDD-XXXX) |
| `id_user` | BIGINT | FK, NOT NULL | Referensi ke USERS (kasir) |
| `tanggal_jual` | DATETIME | NOT NULL | Tanggal & waktu transaksi |
| `nama_pembeli` | VARCHAR(255) | NULLABLE | Nama pembeli |
| `no_hp` | VARCHAR(20) | NULLABLE | Nomor HP pembeli |
| `total_jual` | INTEGER | NOT NULL | Total harga penjualan |
| `metode_bayar` | ENUM | NOT NULL | Pilihan: `Cash`, `Transfer`, `Kartu Kredit`, `SpayLater`, `Akulaku`, `Kredivo`, `GopayLater` |
| `bukti_bayar` | VARCHAR(255) | NULLABLE | Path ke file bukti pembayaran |
| `status_bayar` | ENUM | DEFAULT 'Belum Lunas' | Pilihan: `Lunas`, `Belum Lunas`, `Sebagian` |
| `keterangan` | TEXT | NULLABLE | Keterangan tambahan |
| `created_at` | TIMESTAMP | NOT NULL | Tanggal buat record |
| `updated_at` | TIMESTAMP | NOT NULL | Tanggal update record |

**Foreign Key:**
- `id_user` ➡️ USERS.id_user (CASCADE ON DELETE)

**Relasi:**
- ⬅️ USERS (M:1) - Foreign Key `id_user`
- ➡️ DETAIL_PENJUALANS (1:M) - Foreign Key `id_jual`
- ➡️ PENERIMAAN_KAS (1:M) - Foreign Key `id_jual`

**Contoh Data:**
```sql
INSERT INTO penjualans (kode_jual, id_user, tanggal_jual, nama_pembeli, no_hp, total_jual, metode_bayar, status_bayar, created_at, updated_at)
VALUES 
('PJ-20260522-0001', 2, '2026-05-22 10:30:00', 'Budi Santoso', '081234567890', 389000, 'Cash', 'Lunas', NOW(), NOW()),
('PJ-20260522-0002', 3, '2026-05-22 11:15:00', 'Siti Nurhaliza', '082345678901', 1245000, 'Transfer', 'Belum Lunas', NOW(), NOW());
```

---

## 5️⃣ TABEL: DETAIL_PENJUALANS

**Primary Key:** `id_detailjual` (BIGINT - Auto Increment)

| Kolom | Type Data | Constraint | Keterangan |
|-------|-----------|-----------|-----------|
| `id_detailjual` | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| `kode_jual` | BIGINT | FK, NOT NULL | Referensi ke PENJUALANS |
| `id_produk` | BIGINT | FK, NOT NULL | Referensi ke PRODUKS |
| `jumlah` | INTEGER | NOT NULL | Jumlah item dibeli |
| `harga` | DECIMAL(10,2) | NOT NULL | Harga per item (saat transaksi) |
| `subtotal` | DECIMAL(10,2) | NOT NULL | Harga * Jumlah |
| `created_at` | TIMESTAMP | NOT NULL | Tanggal buat record |
| `updated_at` | TIMESTAMP | NOT NULL | Tanggal update record |

**Foreign Keys:**
- `kode_jual` ➡️ PENJUALANS.kode_jual (CASCADE ON DELETE)
- `id_produk` ➡️ PRODUKS.id_produk (CASCADE ON DELETE)

**Relasi:**
- ⬅️ PENJUALANS (M:1) - Foreign Key `kode_jual`
- ⬅️ PRODUKS (M:1) - Foreign Key `id_produk`

**Contoh Data:**
```sql
INSERT INTO detail_penjualans (kode_jual, id_produk, jumlah, harga, subtotal, created_at, updated_at)
VALUES 
(1, 1, 1, 299000, 299000, NOW(), NOW()),
(1, 2, 3, 89000, 267000, NOW(), NOW()),
(2, 3, 5, 149000, 745000, NOW(), NOW());
```

---

## 6️⃣ TABEL: PENERIMAAN_KAS

**Primary Key:** `id_terimakas` (BIGINT - Auto Increment)

| Kolom | Type Data | Constraint | Keterangan |
|-------|-----------|-----------|-----------|
| `id_terimakas` | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| `kode_terimakas` | VARCHAR(255) | UNIQUE, NOT NULL | Kode penerimaan kas (auto-generate) |
| `kode_jual` | BIGINT | FK, NOT NULL | Referensi ke PENJUALANS |
| `tgl_terimakas` | DATE | NOT NULL | Tanggal penerimaan kas |
| `jmlh_terimakas` | INTEGER | NOT NULL | Jumlah kas yang diterima |
| `keterangan` | VARCHAR(255) | NULLABLE | Keterangan (metode bayar, dll) |
| `created_at` | TIMESTAMP | NOT NULL | Tanggal buat record |
| `updated_at` | TIMESTAMP | NOT NULL | Tanggal update record |

**Foreign Key:**
- `kode_jual` ➡️ PENJUALANS.id_jual (CASCADE ON DELETE)

**Relasi:**
- ⬅️ PENJUALANS (M:1) - Foreign Key `kode_jual`

**Contoh Data:**
```sql
INSERT INTO penerimaan_kas (kode_terimakas, kode_jual, tgl_terimakas, jmlh_terimakas, keterangan, created_at, updated_at)
VALUES 
('KAS-001', 1, '2026-05-22', 389000, 'Pembayaran langsung - Cash', NOW(), NOW()),
('KAS-002', 2, '2026-05-22', 1245000, 'Verifikasi pembayaran - Transfer', NOW(), NOW());
```

---

## 7️⃣ TABEL: ACTIVITY_LOGS

**Primary Key:** `id_log` (BIGINT - Auto Increment)

| Kolom | Type Data | Constraint | Keterangan |
|-------|-----------|-----------|-----------|
| `id_log` | BIGINT | PK, AUTO_INCREMENT | Primary Key |
| `id_user` | BIGINT | FK, NOT NULL | Referensi ke USERS |
| `menu` | VARCHAR(255) | NULLABLE | Menu yang diakses (Transaksi, Produk, dll) |
| `aktivitas` | VARCHAR(255) | NOT NULL | Aktivitas yang dilakukan (Login, Tambah, Edit, Hapus, dll) |
| `keterangan` | TEXT | NULLABLE | Detail aktivitas tambahan |
| `ip_address` | VARCHAR(45) | NULLABLE | IP address user |
| `user_agent` | TEXT | NULLABLE | Browser/device information |
| `created_at` | TIMESTAMP | NOT NULL | Tanggal buat record |
| `updated_at` | TIMESTAMP | NOT NULL | Tanggal update record |

**Foreign Key:**
- `id_user` ➡️ USERS.id_user (CASCADE ON DELETE)

**Relasi:**
- ⬅️ USERS (M:1) - Foreign Key `id_user`

**Contoh Data:**
```sql
INSERT INTO activity_logs (id_user, menu, aktivitas, keterangan, ip_address, created_at, updated_at)
VALUES 
(1, 'Dashboard', 'Login', 'User login berhasil', '192.168.1.100', NOW(), NOW()),
(2, 'Transaksi', 'Proses Checkout', 'No Penjualan: PJ-20260522-0001 | Total: Rp 389000', '192.168.1.101', NOW(), NOW()),
(3, 'Produk', 'Tambah Produk', 'Produk baru: Headphone Wireless', '192.168.1.102', NOW(), NOW());
```

---

## 📋 RINGKASAN TYPE DATA

| Type | Deskripsi | Contoh |
|------|-----------|--------|
| **BIGINT** | Integer 64-bit | id_user, id_jual |
| **VARCHAR(n)** | String variabel dengan panjang max n | nama, email, keterangan |
| **TEXT** | String panjang (lebih dari 255 karakter) | keterangan detail |
| **DECIMAL(10,2)** | Angka desimal presisi tinggi | harga, total, subtotal |
| **INTEGER** | Integer 32-bit | stok, jumlah, total |
| **DATE** | Tanggal (YYYY-MM-DD) | tanggal_jual, tgl_terimakas |
| **DATETIME** | Tanggal dan waktu (YYYY-MM-DD HH:MM:SS) | tanggal_jual |
| **TIMESTAMP** | Timestamp otomatis (created_at, updated_at) | - |
| **ENUM** | Pilihan dari beberapa nilai | jabatan, metode_bayar, status_bayar |

---

## 🔗 FOREIGN KEY CONSTRAINTS

| Tabel | Kolom | Referensi | Aksi Delete |
|-------|-------|-----------|------------|
| PRODUKS | id_kategori | KATEGORIS.id_kategori | CASCADE |
| PENJUALANS | id_user | USERS.id_user | CASCADE |
| DETAIL_PENJUALANS | id_jual | PENJUALANS.id_jual | CASCADE |
| DETAIL_PENJUALANS | id_produk | PRODUKS.id_produk | CASCADE |
| PENERIMAAN_KAS | id_jual | PENJUALANS.id_jual | CASCADE |
| ACTIVITY_LOGS | id_user | USERS.id_user | CASCADE |

---

## 📊 DIAGRAM DATA FLOW

```
┌─────────────┐
│   USERS     │ ◄─── Login (id_user, username, password, jabatan)
│  (id_user)  │
└──────┬──────┘
       │
       ├─────────────────────────┬────────────────────────┐
       │                         │                        │
       ▼                         ▼                        ▼
   ┌────────────┐           ┌─────────────────┐    ┌──────────────────┐
   │ PENJUALANS │           │ ACTIVITY_LOGS   │    │ PENERIMAAN_KAS?  │
   │ (id_jual)  │           │   (id_log)      │    │  (id_terimakas)  │
   └──────┬─────┘           └─────────────────┘    └──────────────────┘
          │
          ├──────────────────────────┬────────────────────────┐
          │                          │                        │
          ▼                          ▼                        ▼
    ┌──────────────────┐     ┌────────────────────┐   ┌────────────────┐
    │DETAIL_PENJUALANS │     │ PENERIMAAN_KAS     │   │ PENERIMAAN_KAS │
    │(id_detailjual)   │     │  (id_terimakas)    │   │  (Multiple)    │
    └──────┬───────────┘     └────────────────────┘   └────────────────┘
           │
           ▼
    ┌──────────────┐
    │   PRODUKS    │ ◄─── Stok berkurang saat checkout
    │ (id_produk)  │
    └──────┬───────┘
           │
           ▼
    ┌──────────────────┐
    │   KATEGORIS      │
    │(id_kategori)     │
    └──────────────────┘
```

---

**Dibuat:** 22 Mei 2026
**Versi:** 2.0
