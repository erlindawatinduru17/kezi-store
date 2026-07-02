@extends('layouts.app')

@section('content')

<style>

/* ====== WRAPPER ====== */
.card {
    background: #f1f5f9;
    padding: 24px;
    border-radius: 20px;
    zoom: 100%; /* Dikembalikan ke ukuran normal */
}

/* ====== HEADER ====== */
.page-header {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    padding: 28px 20px;
    border-radius: 18px;
    color: white;
    margin-bottom: 24px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);

    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-direction: column;
}

.page-header .store {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 6px;
    letter-spacing: 1px;
}

.page-header .title {
    font-size: 26px;
    font-weight: 800;
    letter-spacing: 1px;
}

/* ====== ACTION BAR ====== */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}

.filter {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter input {
    padding: 9px 12px;
    border-radius: 8px;
    border: 1px solid #dbeafe;
    outline: none;
    transition: 0.2s;
    font-size: 13px;
}

.filter input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
}

/* ====== BUTTON ====== */
.btn {
    padding: 9px 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
    text-decoration: none;
    font-size: 13px;
}

.btn:hover {
    transform: translateY(-1px);
    opacity: 0.95;
}

.btn-primary {
    background: #2563eb;
    color: white;
}

.btn-success {
    background: linear-gradient(135deg,#16a34a,#22c55e);
    color: white;
}

/* ====== SUMMARY ====== */
.summary {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.summary-box {
    background: white;
    padding: 18px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 8px 18px rgba(0,0,0,0.05);
    transition: 0.2s;
}

.summary-box:hover {
    transform: translateY(-2px);
}

.summary-box h3 {
    margin: 0;
    font-size: 20px;
    color: #0f172a;
}

.summary-box span {
    font-size: 13px;
    color: #64748b;
    margin-top: 6px;
    display: inline-block;
}

/* ====== TABLE ====== */
.table-wrapper{
    overflow-x:auto;
}

.table-modern {
    width: 100%;
    min-width: 800px;
    border-collapse: collapse;
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    font-size: 13px;
}

.table-modern thead {
    background: #eff6ff;
}

.table-modern th {
    padding: 14px 12px;
    font-size: 12px;
    text-transform: uppercase;
    color: #475569;
    text-align: left;
    white-space: nowrap;
    font-weight: 600;
}

.table-modern td {
    padding: 14px 12px;
    border-bottom: 1px solid #f1f5f9;
    color: #0f172a;
    white-space: nowrap;
    vertical-align: top;
}

.table-modern tbody tr:hover {
    background: #f8fafc;
}

/* ====== BADGE ====== */
.badge {
    background: #f97316;
    color: white;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 8px;
}

/* ====== PRODUK ====== */
.produk-list{
    line-height: 1.6;
    font-size: 13px;
}

/* ====== TOTAL ====== */
.total-text{
    color:#16a34a;
    font-weight:700;
    font-size:14px;
}

/* ====== PRINT ====== */
@media print {
    body * {
        visibility: hidden;
    }

    .card,
    .card * {
        visibility: visible;
    }

    .card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white;
        padding: 15px;
        zoom: 90%;
    }

    .top-bar {
        display: none;
    }

    .page-header {
        box-shadow: none;
        color: #000;
        background: none;
        border-bottom: 1px solid #ddd;
        border-radius: 0;
        padding: 15px 0;
    }

    .page-header .title {
        font-size: 22px;
        color: #111;
    }

    .page-header .store {
        font-size: 14px;
        color: #333;
    }

    .summary-box {
        box-shadow: none;
        border: 1px solid #eee;
    }

    .table-modern {
        font-size: 12px;
        box-shadow: none;
        border: 1px solid #eee;
    }

    .table-modern th,
    .table-modern td {
        padding: 10px 8px;
        border: 1px solid #eee;
    }
}

</style>

<div class="card">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="store">
            Toko Kez iStore
        </div>
        <div class="title">
            📊 Laporan Penjualan
        </div>
    </div>

    {{-- ACTION BAR --}}
    <div class="top-bar">
        <form method="GET" class="filter">
            <input type="date"
                   name="dari"
                   value="{{ request('dari') }}">
            <input type="date"
                   name="sampai"
                   value="{{ request('sampai') }}">
            <button class="btn btn-primary">
                🔍 Filter
            </button>
        </form>

        <button onclick="printLaporan()"
                class="btn btn-success">
            🖨️ Cetak Laporan
        </button>
    </div>

    {{-- SUMMARY --}}
    <div class="summary">
        <div class="summary-box">
            <h3>{{ $data->count() }}</h3>
            <span>Total Transaksi</span>
        </div>

        <div class="summary-box">
            <h3>Rp {{ number_format($total,0,',','.') }}</h3>
            <span>Total Omzet</span>
        </div>

        <div class="summary-box">
            <h3>Rp {{ number_format($data->max('total_jual') ?? 0,0,',','.') }}</h3>
            <span>Transaksi Tertinggi</span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode jual</th>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Produk</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ $item->kode_jual ?? '-' }}
                    @if($loop->first)
                        <span class="badge">Terbaru</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_jual)->format('d M Y') }}</td>
                <td>{{ $item->nama_pembeli ?? '-' }}</td>
                <td class="produk-list">
                    @foreach($item->details as $detail)
                        • {{ $detail->produk->nama_produk ?? '-' }}<br>
                    @endforeach
                </td>
                <td class="total-text">
                    Rp {{ number_format($item->total_jual,0,',','.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:30px 0; color:#64748b;">
                    Tidak ada data penjualan
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
function printLaporan() {
    window.print();
}
</script>

@endsection