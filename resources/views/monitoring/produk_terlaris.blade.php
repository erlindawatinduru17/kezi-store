@extends('layouts.app')

@section('content')

<style>

/* ===== WRAPPER ===== */
.page-wrapper {
    background: #f1f5f9;
    padding: 15px;
    border-radius: 16px;
}

/* ===== HEADER ===== */
.page-header {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
    padding: 18px;
    border-radius: 14px;
    margin-bottom: 15px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.12);

    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.page-title {
    font-size: 18px;
    font-weight: 800;
}

.page-subtitle {
    font-size: 11px;
    opacity: 0.9;
    margin-top: 4px;
}

/* ===== FILTER ===== */
.filter-box {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}

.filter-box input {
    padding: 7px 10px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    background: white;
    font-size: 12px;
}

.btn {
    padding: 7px 12px;
    border-radius: 8px;
    border: none;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.btn-primary {
    background: #2563eb;
    color: white;
}

/* ===== KPI ===== */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(140px,1fr));
    gap: 10px;
    margin-bottom: 14px;
}

.kpi-card {
    background: white;
    padding: 12px;
    border-radius: 12px;
    box-shadow: 0 5px 12px rgba(0,0,0,0.05);
    border-left: 4px solid #3b82f6;
}

.kpi-title {
    font-size: 10px;
    color: #64748b;
}

.kpi-value {
    font-size: 15px;
    font-weight: bold;
    color: #0f172a;
    margin-top: 4px;
}

/* ===== CHART CARD ===== */
.chart-card {
    background: white;
    border-radius: 14px;
    padding: 14px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.05);

    max-width: 500px;
    margin: auto;
}

/* ===== TITLE ===== */
.chart-title {
    text-align: center;
    font-size: 15px;
    font-weight: 700;
}

.chart-subtitle {
    text-align: center;
    font-size: 10px;
    color: #64748b;
    margin-bottom: 10px;
}

/* ===== CHART ===== */
.chart-area {
    height: 180px;
    position: relative;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){

    .kpi-grid {
        grid-template-columns: 1fr;
    }

    .chart-card {
        max-width: 100%;
    }

    .chart-area {
        height: 200px;
    }

}

</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">

        <div class="page-title">
            🏆 Grafik Produk Terlaris
        </div>
        </div>

    </div>

    {{-- FILTER --}}
    <form method="GET" class="filter-box">

        <input type="date"
               name="dari"
               value="{{ request('dari') }}">

        <input type="date"
               name="sampai"
               value="{{ request('sampai') }}">

        <button class="btn btn-primary">
            Filter
        </button>

    </form>

    {{-- KPI --}}
    <div class="kpi-grid">

        <div class="kpi-card">
            <div class="kpi-title">Total Produk</div>

            <div class="kpi-value">
                {{ count($data) }}
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-title">Produk Terlaris</div>

            <div class="kpi-value">
                {{ $data[0]->produk->nama_produk ?? '-' }}
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-title">Total Terjual</div>

            <div class="kpi-value">
                {{ $data->sum('total_terjual') }}
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="chart-card">

        <div class="chart-title">
            Top Produk
        </div>

        <div class="chart-subtitle">
            Grafik produk terjual
        </div>

        <div class="chart-area">
            <canvas id="chartProduk"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chartProduk');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [

            @foreach($data as $item)
                "{{ $item->produk->nama_produk ?? '-' }}",
            @endforeach

        ],

        datasets: [{

            label: 'Total',

            data: [

                @foreach($data as $item)
                    {{ $item->total_terjual }},
                @endforeach

            ],

            backgroundColor: [
                '#3b82f6',
                '#60a5fa',
                '#93c5fd',
                '#1d4ed8',
                '#2563eb'
            ],

            borderRadius: 6,
            barThickness: 16,
            hoverBackgroundColor: '#1e40af'

        }]
    },

    options: {

        responsive: true,
        maintainAspectRatio: false,

        plugins: {

            legend: {
                display: false
            },

            tooltip: {
                backgroundColor: '#0f172a',
                titleColor: '#fff',
                bodyColor: '#fff',
                padding: 8,
                cornerRadius: 6
            }

        },

        scales: {

            x: {

                grid: {
                    display: false
                },

                ticks: {
                    color: '#475569',
                    font: {
                        size: 9
                    }
                }

            },

            y: {

                beginAtZero: true,

                ticks: {
                    precision: 0,
                    color: '#475569',
                    font: {
                        size: 9
                    }
                },

                grid: {
                    color: '#e2e8f0'
                }

            }

        }

    }

});

</script>

@endsection