@extends('layouts.app')

@section('content')

<style>
/* ==========================================
   VARIABEL UTAMA - MUDAH DIUBAH
========================================== */
:root {
    --warna-utama: #2563eb;
    --warna-utama-terang: #3b82f6;
    --warna-sukses: #10b981;
    --warna-sukses-terang: #34d399;
    --warna-peringatan: #f59e0b;
    --warna-peringatan-terang: #fbbf24;
    --warna-bahaya: #ef4444;
    --warna-bahaya-terang: #f87171;
    --warna-abu: #94a3b8;
    --warna-abu-terang: #e2e8f0;
    --warna-terang: #f8fafc;
    --warna-teks: #1e293b;
    --warna-teks-ringan: #64748b;
    --bayangan: 0 10px 25px rgba(0, 0, 0, 0.06);
    --bayangan-kuat: 0 15px 35px rgba(0, 0, 0, 0.12);
    --bayangan-ringan: 0 4px 12px rgba(0, 0, 0, 0.05);
    --radius: 20px;
    --radius-kecil: 12px;
    --transisi: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ==========================================
   WRAPPER UTAMA
========================================== */
.dashboard-wrapper {
    background: linear-gradient(145deg, #f0f4ff 0%, #eef2ff 40%, #f8fafc 100%);
    min-height: 100vh;
    padding: 35px 30px;
    font-size: 14px; /* Ukuran dasar font */
}

/* ==========================================
   HEADER / GREETING
========================================== */
.welcome-card {
    background: linear-gradient(135deg, var(--warna-utama) 0%, #4f46e5 100%);
    color: white;
    padding: 30px 35px;
    border-radius: var(--radius);
    box-shadow: var(--bayangan-kuat);
    margin-bottom: 35px;
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out;
}

.welcome-card::before,
.welcome-card::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.12);
}

.welcome-card::before {
    width: 220px;
    height: 220px;
    top: -60px;
    right: -60px;
}

.welcome-card::after {
    width: 120px;
    height: 120px;
    bottom: -30px;
    left: 30%;
    opacity: 0.08;
}

.welcome-card h2 {
    margin: 0 0 8px;
    font-size: 22px; /* Dikurangi dari 28px */
    font-weight: 700;
    letter-spacing: 0.2px;
}

.welcome-card p {
    margin: 0;
    opacity: 0.92;
    font-size: 14px; /* Dikurangi dari 16px */
    line-height: 1.5;
    max-width: 75%;
}

/* ==========================================
   ANIMASI MASUK
========================================== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animasi-masuk {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
}

.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }
.delay-4 { animation-delay: 0.4s; }
.delay-5 { animation-delay: 0.5s; }

/* ==========================================
   GRID STATISTIK
========================================== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 35px;
}

.stat-card {
    background: #ffffff;
    padding: 22px 20px;
    border-radius: var(--radius);
    box-shadow: var(--bayangan);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: var(--transisi);
    border: 1px solid rgba(226, 232, 240, 0.8);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    transition: var(--transisi);
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--bayangan-kuat);
    border-color: rgba(59, 130, 246, 0.2);
}

.stat-card:hover::before {
    height: 5px;
}

.stat-info h4 {
    font-size: 12px; /* Dikurangi dari 14px */
    font-weight: 600;
    color: var(--warna-teks-ringan);
    margin: 0 0 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-info .nilai {
    font-size: 26px; /* Dikurangi dari 32px */
    font-weight: 700;
    color: var(--warna-teks);
    line-height: 1;
}

.stat-icon {
    width: 55px;
    height: 55px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px; /* Dikurangi dari 26px */
    color: white;
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.12);
}

.icon-produk {
    background: linear-gradient(135deg, var(--warna-utama), var(--warna-utama-terang));
}
.stat-card:nth-child(1)::before { background: var(--warna-utama); }

.icon-transaksi {
    background: linear-gradient(135deg, var(--warna-sukses), var(--warna-sukses-terang));
}
.stat-card:nth-child(2)::before { background: var(--warna-sukses); }

.icon-pendapatan {
    background: linear-gradient(135deg, var(--warna-peringatan), var(--warna-peringatan-terang));
}
.stat-card:nth-child(3)::before { background: var(--warna-peringatan); }

/* ==========================================
   KOMPONEN UMUM (SECTION)
========================================== */
.section-card {
    background: #ffffff;
    border-radius: var(--radius);
    box-shadow: var(--bayangan);
    padding: 22px;
    margin-bottom: 25px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: var(--transisi);
}

.section-card:hover {
    box-shadow: var(--bayangan-kuat);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}

.section-header h3 {
    font-size: 16px; /* Dikurangi dari 18px */
    font-weight: 600;
    color: var(--warna-teks);
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}

/* ==========================================
   NOTIFIKASI STOK MENIPIS
========================================== */
.notifikasi-stok {
    background: linear-gradient(135deg, #fff7ed 0%, #fff1f2 100%);
    border: 1px solid #fed7aa;
    position: relative;
    overflow: hidden;
}

.notifikasi-stok::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--warna-bahaya);
}

.list-stok {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 12px;
}

.item-stok {
    background: white;
    padding: 14px 16px;
    border-radius: var(--radius-kecil);
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-left: 4px solid var(--warna-bahaya);
    box-shadow: var(--bayangan-ringan);
    transition: var(--transisi);
}

.item-stok:hover {
    transform: translateX(3px);
    box-shadow: 0 3px 10px rgba(239, 68, 68, 0.18);
}

.stok-info .nama {
    font-weight: 500;
    font-size: 14px; /* Dikurangi dari 15px */
    color: var(--warna-teks);
    margin-bottom: 3px;
}

.stok-info .kategori {
    font-size: 12px;
    color: var(--warna-abu);
}

.badge-stok {
    background: linear-gradient(135deg, var(--warna-bahaya), var(--warna-bahaya-terang));
    color: white;
    font-size: 11px; /* Dikurangi dari 12px */
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    box-shadow: 0 2px 5px rgba(239, 68, 68, 0.2);
}

/* ==========================================
   AKSI CEPAT
========================================== */
.aksi-cepat {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
}

.btn-aksi {
    padding: 12px 16px;
    border-radius: var(--radius-kecil);
    color: white;
    text-decoration: none;
    font-size: 14px; /* Dikurangi dari 15px */
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: var(--transisi);
    border: none;
    box-shadow: var(--bayangan-ringan);
}

.btn-aksi:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.12);
}

.btn-baru { background: linear-gradient(135deg, var(--warna-utama), var(--warna-utama-terang)); }
.btn-produk { background: linear-gradient(135deg, var(--warna-sukses), var(--warna-sukses-terang)); }
.btn-laporan { background: linear-gradient(135deg, var(--warna-peringatan), var(--warna-peringatan-terang)); }

/* ==========================================
   TABEL & LIST
========================================== */
.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern th {
    background: #f8fafc;
    padding: 12px 14px;
    text-align: left;
    font-weight: 600;
    font-size: 12px; /* Dikurangi dari 13px */
    color: var(--warna-teks-ringan);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 2px solid #e2e8f0;
}

.table-modern td {
    padding: 13px 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px; /* Dikurangi dari 14px */
    color: var(--warna-teks);
    transition: background 0.2s;
}

.table-modern tr:hover td {
    background: #fafcff;
}

/* Produk Terlaris */
.produk-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
    transition: var(--transisi);
}

.produk-list li:hover {
    padding-left: 4px;
    background: #fafbff;
    padding-right: 4px;
    border-radius: 6px;
}

.produk-nama {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    font-size: 13px;
    color: var(--warna-teks);
}

.produk-nama i {
    color: var(--warna-peringatan);
    font-size: 15px;
}

.produk-jumlah {
    font-weight: 600;
    font-size: 12px;
    color: var(--warna-sukses);
    background: #ecfdf5;
    padding: 4px 10px;
    border-radius: 20px;
    border: 1px solid #d1fae5;
}

/* ==========================================
   GRAFIK
========================================== */
.chart-container {
    position: relative;
    height: 240px;
    padding: 8px 0;
}

/* ==========================================
   RESPONSIVE
========================================== */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .welcome-card p {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .dashboard-wrapper {
        padding: 18px 15px;
    }
    .welcome-card {
        padding: 22px 18px;
    }
    .welcome-card h2 {
        font-size: 20px;
    }
    .stat-info .nilai {
        font-size: 24px;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        font-size: 20px;
    }
    .section-card {
        padding: 18px;
    }
}

@media (max-width: 992px) {
    .dashboard-wrapper > div:nth-child(4) {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dashboard-wrapper">

    {{-- 🔥 HEADER SELAMAT DATANG --}}
    <div class="welcome-card animasi-masuk delay-1">
        <h2>Halo, {{ auth()->user()->jabatan }} 👋</h2>
        <p>Selamat datang kembali di sistem manajemen <strong>Kez iStore</strong>. Berikut ringkasan bisnis hari ini.</p>
    </div>

    {{-- 🔥 STATISTIK UTAMA --}}
    <div class="stats-grid">
        <div class="stat-card animasi-masuk delay-2">
            <div class="stat-info">
                <h4>Total Produk</h4>
                <div class="nilai">{{ $totalProduk }}</div>
            </div>
            <div class="stat-icon icon-produk">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>

        <div class="stat-card animasi-masuk delay-3">
            <div class="stat-info">
                <h4>Total Transaksi</h4>
                <div class="nilai">{{ $totalTransaksi }}</div>
            </div>
            <div class="stat-icon icon-transaksi">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
        </div>

        <div class="stat-card animasi-masuk delay-4">
            <div class="stat-info">
                <h4>Total Pendapatan</h4>
                <div class="nilai">Rp {{ number_format($totalPendapatan,0,',','.') }}</div>
            </div>
            <div class="stat-icon icon-pendapatan">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
        </div>
    </div>


    {{-- 🔥 NOTIFIKASI STOK MENIPIS - TAMBAHAN FITUR BARU --}}
    @if(isset($stokMenipis) && $stokMenipis->isNotEmpty())
    <div class="section-card notifikasi-stok animasi-masuk delay-5">
        <div class="section-header">
            <h3 style="color: var(--warna-bahaya);">
                <i class="fa-solid fa-triangle-exclamation"></i> Peringatan Stok Menipis ({{ $stokMenipis->count() }})
            </h3>
            <a href="{{ route('produk.index') }}" class="btn-aksi btn-baru" style="font-size:11px; padding:6px 12px;">Kelola Stok</a>
        </div>
        <div class="list-stok">
            @foreach($stokMenipis as $s)
            <div class="item-stok">
                <div class="stok-info">
                    <div class="nama">{{ $s->nama_produk }}</div>
                    <div class="kategori">{{ optional($s->kategori)->nama_kategori ?? 'Tanpa Kategori' }}</div>
                </div>
                <div class="badge-stok">Sisa: {{ $s->stok }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif


    {{-- 🔥 AKSI CEPAT & GRAFIK --}}
    <div style="display: grid; grid-template-columns: 32% 1fr; gap:24px;">

        {{-- KOLOM KIRI: AKSI CEPAT & PRODUK TERLARIS --}}
        <div>
            {{-- AKSI CEPAT --}}
            <div class="section-card animasi-masuk delay-2">
                <div class="section-header">
                    <h3><i class="fa-solid fa-bolt" style="color:var(--warna-peringatan)"></i> Aksi Cepat</h3>
                </div>
                <div class="aksi-cepat">
                    <a href="{{ route('transaksi.index') }}" class="btn-aksi btn-baru">
                        <i class="fa-solid fa-cash-register"></i> Transaksi Baru
                    </a>
                    <a href="{{ route('produk.index') }}" class="btn-aksi btn-produk">
                        <i class="fa-solid fa-plus-circle"></i> Tambah Produk
                    </a>
                    <a href="{{ route('laporan.penjualan') }}" class="btn-aksi btn-laporan">
                        <i class="fa-solid fa-file-chart-column"></i> Lihat Laporan
                    </a>
                </div>
            </div>

            {{-- PRODUK TERLARIS --}}
            <div class="section-card animasi-masuk delay-3">
                <div class="section-header">
                    <h3><i class="fa-solid fa-fire" style="color:var(--warna-bahaya)"></i> Produk Terlaris</h3>
                </div>
                <ul class="produk-list" style="list-style:none; margin:0; padding:0;">
                    @forelse($produkTerlaris as $p)
                    <li>
                        <div class="produk-nama">
                            <i class="fa-solid fa-caret-up"></i>
                            {{ optional($p->produk)->nama_produk ?? '-' }}
                        </div>
                        <div class="produk-jumlah">{{ $p->total ?? $p->total_terjual }} Pcs</div>
                    </li>
                    @empty
                    <li style="justify-content:center; color:var(--warna-abu); padding:20px 0; font-size:13px;">Belum ada data penjualan</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- KOLOM KANAN: GRAFIK & RIWAYAT --}}
        <div>
            {{-- GRAFIK PENJUALAN --}}
            <div class="section-card animasi-masuk delay-4">
                <div class="section-header">
                    <h3><i class="fa-solid fa-chart-line" style="color:var(--warna-sukses)"></i> Tren Penjualan Mingguan</h3>
                </div>
                <div class="chart-container">
                    <canvas id="chartPenjualan"></canvas>
                </div>
            </div>

            {{-- TRANSAKSI TERBARU --}}
            <div class="section-card animasi-masuk delay-5">
                <div class="section-header">
                    <h3><i class="fa-solid fa-receipt" style="color:var(--warna-utama)"></i> Riwayat Transaksi Terbaru</h3>
                </div>
                <div style="overflow-x:auto;">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->nama_pembeli ?? 'Umum' }}</td>
                                <td><strong style="color:var(--warna-sukses)">Rp {{ number_format($t->total_jual,0,',','.') }}</strong></td>
                                <td><small style="font-size:11px;">{{ $t->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center; padding:25px; color:var(--warna-abu); font-size:13px;">Belum ada transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- 🔥 CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartPenjualan').getContext('2d');

const gradient = ctx.createLinearGradient(0, 0, 0, 220);
gradient.addColorStop(0, "rgba(37, 99, 235, 0.35)");
gradient.addColorStop(1, "rgba(37, 99, 235, 0.02)");

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(
            $grafik->map(fn($g) => \Carbon\Carbon::parse($g->tanggal)->format('d M'))
        ) !!},
        datasets: [{
            label: 'Pendapatan',
            data: {!! json_encode($grafik->pluck('total')) !!},
            borderColor: "#2563eb",
            borderWidth: 2.5,
            pointBackgroundColor: "#ffffff",
            pointBorderColor: "#2563eb",
            pointBorderWidth: 2.5,
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.45,
            fill: true,
            backgroundColor: gradient
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: { display:false },
            tooltip: {
                backgroundColor: '#1e293b',
                titleColor: '#fff',
                bodyColor: '#fff',
                padding: 10,
                cornerRadius: 8,
                usePointStyle: true,
                boxPadding: 5,
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.raw.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero:true,
                grid: { color: 'rgba(148, 163, 184, 0.08)' },
                ticks: {
                    font: { size: 11, weight: 500 },
                    color: '#64748b',
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11, weight: 500 }, color: '#64748b' }
            }
        }
    }
});
</script>

@endsection