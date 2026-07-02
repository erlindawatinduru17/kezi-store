@extends('layouts.app')

@section('content')

<style>
.container-card {
    background: #f1f5f9;
    padding: 24px;
    border-radius: 20px;
    zoom: 100%; /* Ukuran normal */
}

/* HEADER PREMIUM */
.header {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
    padding: 24px;
    border-radius: 18px;
    margin-bottom: 20px;
    text-align: center;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

.header h2 {
    margin: 0;
    font-size: 22px;
    font-weight: 800;
}

.header small {
    display: block;
    margin-top: 6px;
    opacity: 0.9;
    font-size: 14px;
}

/* FILTER */
.filter {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.filter input {
    padding: 9px 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    background: white;
    font-size: 13px;
}

/* BUTTON */
.btn {
    padding: 9px 16px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    font-size: 13px;
}

.btn:hover {
    background: #1e40af;
}

/* BUTTON CETAK */
.btn-print {
    background: linear-gradient(135deg,#16a34a,#22c55e);
}

/* ACTION BAR */
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    gap: 12px;
    flex-wrap: wrap;
}

/* SUMMARY */
.summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 20px;
}

.box {
    background: white;
    padding: 18px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.05);
    border-left: 4px solid #3b82f6;
}

.box h3 {
    margin: 0;
    font-size: 14px;
    color: #64748b;
}

.box p {
    margin: 8px 0 0;
    font-size: 20px;
    font-weight: bold;
    color: #0f172a;
}

/* TABLE WRAPPER */
.table-wrapper{
    overflow-x:auto;
}

/* TABLE */
.table-modern {
    width: 100%;
    min-width: 800px;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
    background: white;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    font-size: 13px;
}

.table-modern thead {
    background: #f8fafc;
}

.table-modern th {
    padding: 12px;
    font-size: 12px;
    text-transform: uppercase;
    color: #64748b;
    font-weight: 600;
    white-space: nowrap;
}

.table-modern td {
    padding: 12px;
    border-bottom: 1px solid #f1f5f9;
    white-space: nowrap;
}

.table-modern tbody tr:hover {
    background: #f9fafb;
}

/* BADGE */
.badge {
    background: linear-gradient(135deg, #f59e0b, #f97316);
    color: white;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11px;
    margin-left: 6px;
    font-weight: 600;
}

/* TOP 1 */
.top1 {
    font-weight: 700;
    color: #16a34a;
    font-size: 14px;
}

/* PRINT STYLE */
@media print {
    body * {
        visibility: hidden;
    }

    .container-card,
    .container-card * {
        visibility: visible;
    }

    .container-card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white;
        padding: 15px;
        zoom: 90%;
    }

    .filter,
    .btn {
        display: none;
    }

    .header {
        box-shadow: none;
        background: none;
        color: #000;
        border-bottom: 1px solid #ddd;
    }

    .header h2 {
        font-size: 20px;
    }

    .table-modern {
        font-size: 11px;
        box-shadow: none;
        border: 1px solid #eee;
    }

    .table-modern th,
    .table-modern td {
        padding: 8px;
        border: 1px solid #eee;
    }
}

</style>

<div class="container-card">

    {{-- HEADER --}}
    <div class="header">
        <h2>Toko Kez iStore</h2>
        <h2>🏆 Laporan Produk Terlaris</h2>
    </div>

    {{-- FILTER + CETAK --}}
    <div class="action-bar">

        <form method="GET" class="filter">

            <input type="date"
                   name="dari"
                   value="{{ request('dari') }}">

            <input type="date"
                   name="sampai"
                   value="{{ request('sampai') }}">

            <button class="btn">
                🔍 Filter
            </button>

        </form>

        <!-- TOMBOL CETAK -->
        <button onclick="printLaporan()"
                class="btn btn-print">

            🖨️ Cetak

        </button>

    </div>

    {{-- SUMMARY --}}
    <div class="summary">

        <div class="box">
            <h3>Total Omset</h3>
            <p>
                Rp {{ number_format($total ?? 0,0,',','.') }}
            </p>
        </div>

        <div class="box">
            <h3>Total Produk</h3>
            <p>
                {{ count($produk) }}
            </p>
        </div>

        <div class="box">
            <h3>Produk Terlaris</h3>
            <p>
                {{ $produk[0]->nama_produk ?? '-' }}
            </p>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">

        <table class="table-modern">

            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Terjual</th>
                    <th>Omset</th>
                </tr>
            </thead>

            <tbody>
            @forelse($produk as $p)
            <tr>
                <td>
                    <b>{{ $loop->iteration }}</b>
                    @if($loop->first)
                        <span class="badge">TOP 1</span>
                    @endif
                </td>
                <td class="{{ $loop->first ? 'top1' : '' }}">
                    {{ $p->nama_produk }}
                </td>
                <td>
                    {{ $p->kategori->nama_kategori ?? '-' }}
                </td>
                <td>
                    Rp {{ number_format($p->harga,0,',','.') }}
                </td>
                <td>
                    <b>{{ $p->total_terjual }}</b>
                </td>
                <td>
                    <b style="color:#16a34a;">
                        Rp {{ number_format($p->total_terjual * $p->harga,0,',','.') }}
                    </b>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:30px; color:#64748b;">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
            </tbody>

        </table>

    </div>

</div>

<!-- SCRIPT CETAK -->
<script>
function printLaporan() {
    window.print();
}
</script>

@endsection