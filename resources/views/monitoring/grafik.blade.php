@extends('layouts.app')

@section('content')

<style>
/* MAIN CARD */
.card {
    background: #f1f5f9;
    padding: 15px; /* ✅ Dikurangi agar tidak terlalu lebar */
    border-radius: 20px;
}

/* HEADER */
.header-box {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    padding: 15px; /* ✅ Dikurangi */
    border-radius: 18px;
    color: white;
    text-align: center;
    font-size: 22px;
    font-weight: 800;
    box-shadow: 0 12px 28px rgba(30, 58, 138, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 8px; /* ✅ Jarak bawah dikurangi */
}

/* SUB TITLE */
.sub-text {
    text-align: center;
    margin-top: 5px; /* ✅ Dikurangi */
    margin-bottom: 12px; /* ✅ Dikurangi */
    color: #64748b;
    font-size: 13px;
    font-weight: 500;
}

/* FILTER FORM - SESUAI GAMBAR */
.filter-box {
    background: #f1f5f9;
    padding: 0;
    border-radius: 0;
    box-shadow: none;
    max-width: 100%;
    margin: 0 auto 12px auto; /* ✅ Jarak bawah dikurangi */
    display: flex;
    flex-direction: column;
    gap: 8px; /* ✅ Jarak antar input dikurangi */
}

.filter-box input[type="date"] {
    width: 100%;
    padding: 10px 14px; /* ✅ Tinggi input dikurangi */
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    outline: none;
    background-color: #ffffff;
    font-size: 14px;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%2364748b" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 12px center; /* ✅ Posisi ikon disesuaikan */
    padding-right: 35px;
}

.filter-box input[type="date"]:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

.filter-box button {
    background-color: #2563eb;
    color: white;
    border: none;
    padding: 8px 18px; /* ✅ Ukuran tombol dikurangi */
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    align-self: flex-start;
    margin-top: 2px; /* ✅ Jarak atas dikurangi */
}

.filter-box button:hover {
    background-color: #1d4ed8;
}

.filter-box .reset-btn {
    background-color: #64748b;
    margin-left: 8px; /* ✅ Jarak antar tombol dikurangi */
}

.filter-box .reset-btn:hover {
    background-color: #475569;
}

/* STATS */
.stats {
    display: flex;
    justify-content: center;
    gap: 10px; /* ✅ Jarak antar kotak dikurangi */
    margin-bottom: 12px; /* ✅ Jarak bawah dikurangi */
    flex-wrap: wrap;
}

.stat-box {
    background: white;
    padding: 12px 10px; /* ✅ Padding dalam dikurangi */
    border-radius: 12px;
    min-width: 160px; /* ✅ Lebar minimal dikurangi */
    text-align: center;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    transition: 0.25s ease;
    border: 1px solid #e2e8f0;
    position: relative;
    overflow: hidden;
}

.stat-box::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #2563eb, #60a5fa);
}

.stat-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
}

.stat-box h4 {
    margin: 0;
    font-size: 18px; /* ✅ Ukuran angka dikurangi sedikit */
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 3px; /* ✅ Jarak bawah dikurangi */
}

.stat-box span {
    font-size: 11px; /* ✅ Ukuran teks dikurangi */
    font-weight: 500;
    color: #64748b;
}

/* CHART CARD */
.chart-wrapper {
    max-width: 1000px;
    margin: auto;
    background: white;
    padding: 15px; /* ✅ Padding dalam dikurangi */
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    position: relative;
    border: 1px solid #e2e8f0;
}

/* glow effect */
.chart-wrapper::before {
    content: "";
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    z-index: -1;
    border-radius: 22px;
    filter: blur(22px);
    opacity: 0.18;
}
</style>

<div class="card">

    {{-- HEADER --}}
    <div class="header-box">
        📊 Grafik Penjualan
    </div>

    <div class="sub-text">
        Visualisasi performa penjualan berdasarkan waktu transaksi
    </div>

    {{-- FORM FILTER TANGGAL - SESUAI GAMBAR --}}
    <form action="{{ url()->current() }}" method="GET" class="filter-box">
        <input type="date" name="dari_tanggal" id="dari_tanggal" value="{{ request('dari_tanggal') }}" placeholder="dd / mm / yyyy">

        <input type="date" name="sampai_tanggal" id="sampai_tanggal" value="{{ request('sampai_tanggal') }}" placeholder="dd / mm / yyyy">

        <div>
            <button type="submit">Filter</button>
            @if(request('dari_tanggal') || request('sampai_tanggal'))
                <a href="{{ url()->current() }}" class="reset-btn" style="padding: 8px 20px; border-radius: 8px; text-decoration: none; color: white;">Reset</a>
            @endif
        </div>
    </form>

    {{-- STATS --}}
    <div class="stats">
        <div class="stat-box">
            <h4>{{ $data->count() }}</h4>
            <span>Total Hari Transaksi</span>
        </div>

        <div class="stat-box">
            <h4>Rp {{ number_format($data->sum('total'),0,',','.') }}</h4>
            <span>Total Omzet</span>
        </div>

        <div class="stat-box">
            <h4>
                @if($data->isNotEmpty())
                    Rp {{ number_format($data->max('total'),0,',','.') }}
                @else
                    0
                @endif
            </h4>
            <span>Penjualan Tertinggi</span>
        </div>
    </div>

    {{-- CHART --}}
    <div class="chart-wrapper">
        <canvas id="chart" height="100"></canvas> <!-- ✅ Tinggi grafik dikurangi agar rapat -->
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($data->pluck('tanggal'));
const totals = @json($data->pluck('total'));

/* GRADIENT LINE */
const ctx = document.getElementById('chart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(59, 130, 246, 0.45)');
gradient.addColorStop(1, 'rgba(59, 130, 246, 0.02)');

// ✅ DIPERBAIKI: Mencegah error jika data kosong
if (labels.length > 0) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Penjualan',
                data: totals,

                borderColor: '#2563eb',
                backgroundColor: gradient,

                borderWidth: 3,
                tension: 0.45,
                fill: true,

                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointShadowBlur: 4,
                pointShadowColor: 'rgba(37, 99, 235, 0.2)',
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            // ✅ PENGATURAN AGAR TIDAK BERJARAK JAUH
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },

            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#0f172a',
                        font: {
                            size: 13,
                            weight: 'bold'
                        }
                    }
                },

                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 10,
                    boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
                }
            },

            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#64748b',
                        maxRotation: 0,
                        autoSkip: true,
                        maxTicksLimit: 20
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#e2e8f0' },
                    ticks: { color: '#64748b' }
                }
            }
        }
    });
} else {
    // ✅ Tampilkan pesan jika tidak ada data
    ctx.font = '14px sans-serif';
    ctx.fillStyle = '#64748b';
    ctx.textAlign = 'center';
    ctx.fillText('Tidak ada data penjualan pada rentang tanggal ini', ctx.canvas.width/2, ctx.canvas.height/2);
}
</script>

@endsection