@extends('layouts.app')

@section('content')

<style>
/* --------------------------
   STYLE UTAMA & TATA LETAK
--------------------------- */
.transaksi-wrapper {
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    min-height: 100vh;
    padding: 25px 0;
}

/* ✅ UBAH RASIO UKURAN: KIRI 1.8 / KANAN 1.2 → KANAN LEBIH BESAR */
.grid-transaksi {
    display: grid;
    grid-template-columns: 1.8fr 1.5fr;
    gap: 25px;
    max-width: 1500px;
    margin: 0 auto;
    padding: 0 20px;
}

/* --------------------------
   CARD STYLE
--------------------------- */
.card {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 25px;
    border: none;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f1f5f9;
}

.card-title {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* --------------------------
   PENCARIAN PRODUK
--------------------------- */
.search-input {
    width: 100%;
    padding: 12px 16px;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    font-size: 15px;
    outline: none;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    background: #ffffff;
}

/* --------------------------
   GRID PRODUK
--------------------------- */
.grid-produk {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 18px;
    margin-top: 20px;
}

.item-produk {
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #f1f5f9;
    transition: all 0.3s ease;
}

.item-produk:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    border-color: #dbeafe;
}

.produk-gambar {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.produk-stok {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(15, 23, 42, 0.75);
    color: #ffffff;
    font-size: 11px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 20px;
}

.produk-info {
    padding: 14px;
}

.produk-nama {
    font-weight: 600;
    font-size: 14px;
    color: #1e293b;
    height: 36px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    margin-bottom: 8px;
}

.produk-harga {
    font-size: 15px;
    font-weight: 700;
    color: #16a34a;
    margin-bottom: 12px;
}

.btn-tambah {
    width: 100%;
    padding: 9px;
    border: none;
    border-radius: 8px;
    background: #3b82f6;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

.btn-tambah:hover:not(:disabled) {
    background: #2563eb;
}

.btn-tambah:disabled {
    background: #94a3b8;
    cursor: not-allowed;
}

/* --------------------------
   ✅ PERBESAR KERANJANG BELANJA
--------------------------- */
.keranjang-card {
    position: sticky;
    top: 25px;
    max-height: 95vh;
    display: flex;
    flex-direction: column;
    min-width: 450px; /* Lebar minimal diperbesar */
}

/* ✅ Perbesar area daftar barang di keranjang */
.keranjang-scroll {
    flex: 1;
    overflow-y: auto;
    max-height: 320px; /* Tinggi diperbesar */
    padding-right: 10px;
    margin: 15px 0;
}

.keranjang-scroll::-webkit-scrollbar {
    width: 6px;
}

.keranjang-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.keranjang-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* ✅ Perbesar ukuran teks dan jarak tabel */
.table-keranjang {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px; /* Ukuran teks diperbesar */
}

.table-keranjang th {
    text-align: left;
    padding: 12px 10px;
    font-weight: 600;
    color: #64748b;
    border-bottom: 1px solid #e2e8f0;
    font-size: 15px;
}

.table-keranjang td {
    padding: 14px 10px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
}

.total-bayar {
    font-size: 22px; /* Ukuran teks total diperbesar */
    font-weight: 800;
    color: #166534;
    text-align: right;
    padding: 15px 0;
    margin: 10px 0;
    border-top: 2px dashed #e2e8f0;
    border-bottom: 2px dashed #e2e8f0;
}

/* --------------------------
   METODE PEMBAYARAN
--------------------------- */
.pembayaran-scroll {
    overflow-y: auto;
    max-height: 350px; /* Tinggi area pembayaran juga diperbesar */
    padding-right: 10px;
    margin: 15px 0;
}

.judul-kategori {
    font-size: 14px;
    font-weight: 700;
    color: #475569;
    margin: 20px 0 12px 0;
}

.metode-bayar-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.btn-metode {
    padding: 12px;
    border: 2px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}

.btn-metode:hover {
    border-color: #93c5fd;
    background: #eff6ff;
}

.btn-metode.aktif {
    border-color: #2563eb;
    background: #2563eb;
    color: white;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

/* --------------------------
   INFORMASI REKENING & QRIS
--------------------------- */
.info-box {
    background: #f8fafc;
    border: 2px dashed #93c5fd;
    border-radius: 12px;
    padding: 20px;
    margin: 18px 0;
    text-align: center;
    display: none;
}

.info-box h5 {
    margin: 0 0 15px 0;
    font-weight: 700;
    font-size: 16px;
    color: #1e40af;
}

.nomor-rekening {
    font-size: 22px;
    font-weight: 800;
    color: #1e40af;
    background: #dbeafe;
    padding: 12px;
    border-radius: 8px;
    margin: 12px 0;
    letter-spacing: 1px;
}

.gambar-qris {
    width: 240px;
    height: 240px;
    object-fit: contain;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px;
    background: white;
    margin: 12px auto;
}

/* --------------------------
   INPUT FORM
--------------------------- */
.form-control {
    width: 100%;
    padding: 12px 15px;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    font-size: 15px;
    outline: none;
    transition: 0.2s;
    background: #fafbfc;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    background: white;
}

.text-opsional {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 4px;
    display: block;
}

/* --------------------------
   TOMBOL UTAMA
--------------------------- */
.btn-bayar {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    font-size: 17px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 15px;
}

.btn-bayar:hover:not(:disabled) {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(16, 185, 129, 0.25);
}

.btn-bayar:disabled {
    background: #94a3b8;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* --------------------------
   ALERT
--------------------------- */
.alert {
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 15px;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: #ecfdf5;
    color: #065f46;
    border-left: 4px solid #10b981;
}

.alert-danger {
    background: #fef2f2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
}

/* --------------------------
   RESPONSIF
--------------------------- */
@media (max-width: 1200px) {
    .grid-transaksi {
        grid-template-columns: 1fr;
    }
    .keranjang-card {
        position: static;
        max-height: none;
        min-width: auto;
    }
}

@media (max-width: 576px) {
    .grid-produk {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
    .metode-bayar-grid {
        grid-template-columns: 1fr 1fr;
    }
}
</style>

<div class="transaksi-wrapper">
    <div class="grid-transaksi">

        {{-- ================= BAGIAN KIRI: DAFTAR PRODUK ================= --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">🛒 Daftar Produk</h2>
                </div>

                <div class="search-wrapper">
                    <input type="text" id="cariProduk" class="search-input" placeholder="🔍 Cari nama produk...">
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="grid-produk">
                    @forelse($produk as $p)
                    <form action="{{ route('transaksi.add') }}" method="POST" class="item-produk">
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                        <div style="position: relative;">
                            <img src="{{ $p->gambar ? asset('storage/'.$p->gambar) : asset('images/default.png') }}" 
                                 alt="{{ $p->nama_produk }}" class="produk-gambar">
                            <div class="produk-stok">Stok: {{ $p->stok }}</div>
                        </div>
                        <div class="produk-info">
                            <div class="produk-nama">{{ $p->nama_produk }}</div>
                            <div class="produk-harga">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                            <button type="submit" class="btn-tambah" {{ $p->stok == 0 ? 'disabled' : '' }}>
                                {{ $p->stok == 0 ? 'Stok Habis' : '+ Tambah' }}
                            </button>
                        </div>
                    </form>
                    @empty
                        <div style="text-align:center; padding:40px 20px; color:#94a3b8; grid-column: 1 / -1;">
                            <p style="font-size:16px;">📦 Produk belum tersedia</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ================= BAGIAN KANAN: KERANJANG & PEMBAYARAN (LEBIH BESAR) ================= --}}
        <div>
            <div class="card keranjang-card">
                <h2 class="card-title">🧾 Keranjang Belanja</h2>

                <div class="keranjang-scroll">
                    @php 
                        $total = 0; 
                        $cart = session('cart', []);
                        if(!empty($cart)){
                            foreach($cart as $item){
                                $total += $item['harga'] * $item['qty'];
                            }
                        }
                    @endphp

                    <table class="table-keranjang">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cart as $id => $item)
                                @php $subtotal = $item['harga'] * $item['qty']; @endphp
                                <tr>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['qty'] }}</td>
                                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('transaksi.delete') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_produk" value="{{ $id }}">
                                            <button type="submit" class="btn btn-danger btn-sm" style="padding:4px 10px; border-radius:4px; font-size:13px;">×</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center; padding:40px 0; color:#94a3b8; font-size:16px;">
                                        🛒 Keranjang masih kosong
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="total-bayar">
                    Total: Rp {{ number_format($total, 0, ',', '.') }}
                </div>

                {{-- FORM PEMBAYARAN --}}
                <div class="pembayaran-scroll">
                    <form action="{{ route('transaksi.checkout') }}" method="POST" enctype="multipart/form-data" id="formPembayaran">
                        @csrf
                        <input type="hidden" name="id_user" value="{{ auth()->user()->id_user }}" readonly>

                        <div style="margin-bottom:15px;">
                            <input type="text" name="nama_pembeli" class="form-control" placeholder="Nama Pembeli" value="{{ old('nama_pembeli') }}">
                            <span class="text-opsional">* Kosongkan jika tidak ingin diisi</span>
                        </div>
                        <input type="hidden" name="metode_bayar" id="metodeBayarInput" required>

                        {{-- TUNAI --}}
                        <div class="judul-kategori">TUNAI</div>
                        <div class="metode-bayar-grid">
                            <div class="btn-metode" data-value="Cash">💵 Bayar di Tempat</div>
                        </div>

                        {{-- TRANSFER BANK --}}
                        <div class="judul-kategori">TRANSFER BANK</div>
                        <div class="metode-bayar-grid">
                            <div class="btn-metode" data-value="Seabank">SeaBank</div>
                            <div class="btn-metode" data-value="BRI">Bank BRI</div>
                            <div class="btn-metode" data-value="BCA">Bank BCA</div>
                        </div>

                        {{-- E-WALLET / QRIS --}}
                        <div class="judul-kategori">E-WALLET / QRIS</div>
                        <div class="metode-bayar-grid">
                            <div class="btn-metode" data-value="QRIS">📱 QRIS</div>
                        </div>

                        {{-- PAYLATER --}}
                        <div class="judul-kategori">PAYLATER & KARTU</div>
                        <div class="metode-bayar-grid">
                            <div class="btn-metode" data-value="Kartu Kredit">💳 Kartu Kredit</div>
                            <div class="btn-metode" data-value="SpayLater">Shopee PayLater</div>
                            <div class="btn-metode" data-value="Akulaku">Akulaku</div>
                            <div class="btn-metode" data-value="Kredivo">Kredivo</div>
                            <div class="btn-metode" data-value="GopayLater">GopayLater</div>
                        </div>

                        {{-- INFORMASI REKENING --}}
                        <div class="info-box" id="rekeningBox">
                            <h5>Nomor Rekening Tujuan</h5>
                            <div id="namaBank" style="font-weight:600; font-size:17px; margin-bottom:10px;"></div>
                            <div class="nomor-rekening" id="nomorRek"></div>
                            <p style="margin:10px 0 0 0; font-size:15px;">a.n. <strong>Kezistore</strong></p>
                            <p style="margin-top:15px; font-weight:600; font-size:16px;">Total Bayar: Rp {{ number_format($total, 0, ',', '.') }}</p>
                        </div>

                        {{-- INFORMASI QRIS --}}
                        <div class="info-box" id="qrisBox">
                            <h5>Scan QRIS Pembayaran</h5>
                            <img src="{{ asset('storage/QRIS.jpeg') }}" alt="QRIS" class="gambar-qris">
                            <p style="font-weight:700; font-size:17px; margin:10px 0;">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
                            <p style="font-size:14px; color:#64748b; margin-bottom:12px;">a.n. Kezistore</p>
                            <div style="background:#eff6ff; padding:12px; border-radius:8px; text-align:left; font-size:13px;">
                                <strong>Cara bayar:</strong>
                                <ol style="margin:5px 0 0 20px; padding:0;">
                                    <li>Scan kode QRIS dengan aplikasi perbankan / e-wallet</li>
                                    <li>Pastikan nominal sudah sesuai</li>
                                    <li>Konfirmasi pembayaran & simpan bukti</li>
                                </ol>
                            </div>
                        </div>

                        {{-- UPLOAD BUKTI BAYAR --}}
                        <div id="buktiBayarArea" style="margin-top:18px;">
                            <label style="font-weight:600; font-size:14px; display:block; margin-bottom:8px;">📎 Unggah Bukti Pembayaran <span style="color:red;">*</span></label>
                            <input type="file" name="bukti_bayar" class="form-control" accept="image/*">
                            <span class="text-opsional">* Wajib diisi kecuali bayar di tempat</span>
                        </div>
                    </form>
                </div>

                <button type="button" class="btn-bayar" id="btnBayar" {{ $total <= 0 ? 'disabled' : '' }}>
                    {{ $total <= 0 ? 'Keranjang Kosong' : '💳 Lanjutkan Pembayaran' }}
                </button>
            </div>
        </div>

    </div>
</div>

<script>
// FITUR PENCARIAN PRODUK
document.getElementById('cariProduk').addEventListener('keyup', function() {
    const kataKunci = this.value.toLowerCase().trim();
    const daftarProduk = document.querySelectorAll('.item-produk');
    daftarProduk.forEach(item => {
        const nama = item.querySelector('.produk-nama').textContent.toLowerCase();
        item.style.display = nama.includes(kataKunci) ? '' : 'none';
    });
});

// DATA REKENING
const dataRekening = {
    'Seabank': { nama: 'SeaBank', no: '901333527126' },
    'BRI': { nama: 'Bank Rakyat Indonesia', no: '008501045150501' },
    'BCA': { nama: 'Bank Central Asia', no: '8465878602' }
};

// ELEMEN UTAMA
const semuaBtnMetode = document.querySelectorAll('.btn-metode');
const inputMetode = document.getElementById('metodeBayarInput');
const rekeningBox = document.getElementById('rekeningBox');
const namaBankEl = document.getElementById('namaBank');
const nomorRekEl = document.getElementById('nomorRek');
const qrisBox = document.getElementById('qrisBox');
const buktiBayarArea = document.getElementById('buktiBayarArea');
const inputBukti = document.querySelector('input[name="bukti_bayar"]');
const formPembayaran = document.getElementById('formPembayaran');
const btnBayar = document.getElementById('btnBayar');
const totalNilai = {{ json_encode($total ?? 0) }};

// LOGIKA PILIH METODE BAYAR
semuaBtnMetode.forEach(btn => {
    btn.addEventListener('click', function() {
        semuaBtnMetode.forEach(b => b.classList.remove('aktif'));
        this.classList.add('aktif');
        const nilai = this.getAttribute('data-value');
        inputMetode.value = nilai;

        // Reset tampilan
        rekeningBox.style.display = 'none';
        qrisBox.style.display = 'none';
        buktiBayarArea.style.display = 'block';
        inputBukti.required = true;

        // Transfer Bank
        if (dataRekening.hasOwnProperty(nilai)) {
            rekeningBox.style.display = 'block';
            namaBankEl.textContent = dataRekening[nilai].nama;
            nomorRekEl.textContent = dataRekening[nilai].no;
            btnBayar.textContent = '✅ Saya Sudah Transfer';
        }

        // QRIS
        else if (nilai === 'QRIS') {
            qrisBox.style.display = 'block';
            btnBayar.textContent = '✅ Saya Sudah Bayar';
        }

        // Tunai
        else if (nilai === 'Cash') {
            buktiBayarArea.style.display = 'none';
            inputBukti.required = false;
            btnBayar.textContent = '🤝 Konfirmasi Pesanan';
        }

        // Lainnya
        else {
            btnBayar.textContent = '✅ Konfirmasi Pesanan';
        }
    });
});

// PROSES KIRIM FORM
btnBayar.addEventListener('click', function(e) {
    e.preventDefault();

    if(totalNilai <= 0) {
        alert('❌ Keranjang belanja masih kosong!');
        return;
    }

    if(!inputMetode.value) {
        alert('❌ Silakan pilih metode pembayaran terlebih dahulu!');
        return;
    }

    if(inputMetode.value !== 'Cash' && !inputBukti.value) {
        alert('⚠️ Silakan unggah bukti pembayaran terlebih dahulu!');
        return;
    }

    formPembayaran.submit();
});

// Cegah submit saat tekan Enter
document.querySelectorAll('input[name="nama_pembeli"], input[name="no_hp"]').forEach(input => {
    input.addEventListener('keydown', e => {
        if(e.key === 'Enter') e.preventDefault();
    });
});
</script>

@endsection