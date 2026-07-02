@extends('layouts.app')

@section('content')

<style>

/* BACKGROUND */
.page-bg {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
    padding: 25px;
    border-radius: 20px;
}

/* HEADER */
.header-box {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    padding: 24px;
    border-radius: 18px;
    color: white;
    text-align: center;
    margin-bottom: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.page-title {
    font-size: 24px;
    font-weight: 800;
}

/* FILTER */
.filter-box {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.filter-box input {
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    width: 220px;
}

.btn {
    padding: 10px 15px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-weight: 600;
}

.btn-primary {
    background: #2563eb;
    color: white;
}

.btn-secondary {
    background: #64748b;
    color: white;
}

/* TOMBOL CETAK */
.btn-print {
    background: #16a34a;
    color: white;
}

/* SUMMARY */
.summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.summary-card {
    background: white;
    padding: 15px;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    border-left: 4px solid #2563eb;
}

.summary-card h4 {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

.summary-card p {
    margin: 6px 0 0;
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
}

/* CARD TABLE */
.card-modern {
    background: white;
    border-radius: 18px;
    padding: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.06);
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table-modern thead {
    background: #f1f5f9;
}

.table-modern th {
    padding: 14px;
    text-align: left;
    font-weight: 700;
    color: #334155;
    font-size: 13px;
}

.table-modern td {
    padding: 14px;
    border-bottom: 1px solid #e5e7eb;
}

.table-modern tbody tr:hover {
    background: #f8fafc;
}

/* BADGE KODE */
.badge-code {
    background: #e0f2fe;
    color: #0369a1;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* FORMAT JUMLAH */
.amount {
    font-weight: 700;
    color: #16a34a;
}

.text-muted {
    color: #64748b;
}

/* MODE CETAK */
@media print {
    body * {
        visibility: hidden;
    }
    .page-bg, .page-bg * {
        visibility: visible;
    }
    .page-bg {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white;
        padding: 0;
    }
    .filter-box, .btn {
        display: none;
    }
}

</style>

<div class="page-bg">

    {{-- HEADER --}}
    <div class="header-box">
        <div class="page-title">💰 Penerimaan Kas</div>
    </div>

    {{-- FILTER TANGGAL + TOMBOL --}}
    <form method="GET" action="{{ route('keuangan.penerimaan_kas') }}" class="filter-box">
        <input type="date" name="from" value="{{ request('from') }}">
        <input type="date" name="to" value="{{ request('to') }}">
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('keuangan.penerimaan_kas') }}" class="btn btn-secondary">Reset</a>
        <button type="button" onclick="printData()" class="btn btn-print">🖨️ Cetak</button>
    </form>

    {{-- RINGKASAN DATA --}}
    <div class="summary">
        <div class="summary-card">
            <h4>Total Transaksi</h4>
            <p>{{ count($data) }}</p>
        </div>
        <div class="summary-card">
            <h4>Total Penerimaan</h4>
            <p>Rp {{ number_format($data->sum('jmlh_terimakas'), 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:10px;border-radius:10px;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABEL DATA --}}
    <div class="card-modern">
        <div style="overflow-x:auto;">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Terima Kas</th>
                        <th>Kode Jual</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="badge-code">
                            {{ $item->kode_terimakas }}
                        </span>
                    </td>
                    <td>{{ optional($item->penjualan)->kode_jual ?? '-' }}</td>
                    <td class="text-muted">
                        {{ \Carbon\Carbon::parse($item->tgl_terimakas)->format('d M Y') }}
                    </td>
                    <td class="amount">
                        Rp {{ number_format($item->jmlh_terimakas, 0, ',', '.') }}
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:20px;">
                        Tidak ada data penerimaan kas
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- SCRIPT CETAK --}}
<script>
function printData() {
    window.print();
}
</script>

@endsection