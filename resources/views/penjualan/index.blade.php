@extends('layouts.app')

@section('content')

<style>

/* ===============================
   PAGE
================================= */

.page-bg{
    background: linear-gradient(135deg,#eef6ff,#f8fafc);
    padding:14px;
    border-radius:18px;

    /* AGAR MUAT SCREENSHOT */
    zoom:85%;
}

/* ===============================
   HEADER
================================= */

.header-box{
    background: linear-gradient(135deg,#1e3a8a,#2563eb);
    padding:16px 20px;
    border-radius:18px;
    margin-bottom:14px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.header-title h2{
    margin:0;
    font-size:22px;
    font-weight:800;
}

.header-title p{
    margin:3px 0 0;
    font-size:11px;
    opacity:.9;
}

/* ===============================
   FILTER
================================= */

.filter-box{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
    margin-bottom:14px;
    align-items:end;
}

.filter-group{
    display:flex;
    flex-direction:column;
    gap:4px;
}

.filter-group label{
    font-size:10px;
    font-weight:600;
    color:#334155;
}

.filter-box input{
    padding:8px 10px;
    border-radius:8px;
    border:1px solid #dbeafe;
    background:white;
    min-width:150px;
    outline:none;
    font-size:11px;
}

.filter-box input:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,.15);
}

/* ===============================
   BUTTON
================================= */

.btn-modern{
    border:none;
    padding:8px 10px;
    border-radius:8px;
    color:white;
    font-size:10px;
    font-weight:600;
    cursor:pointer;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:4px;
    transition:.2s;
}

.btn-modern:hover{
    transform:translateY(-1px);
}

.btn-blue{
    background:#2563eb;
}

.btn-gray{
    background:#64748b;
}

.btn-red{
    background:#ef4444;
}

.btn-green{
    background:#22c55e;
}

/* ===============================
   SUMMARY
================================= */

.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:10px;
    margin-bottom:14px;
}

.summary-card{
    background:white;
    border-radius:14px;
    padding:14px;
    box-shadow:0 8px 20px rgba(0,0,0,.05);
    border-left:4px solid #2563eb;
}

.summary-card h5{
    margin:0;
    color:#64748b;
    font-size:10px;
}

.summary-card h3{
    margin-top:5px;
    font-size:18px;
    color:#0f172a;
    font-weight:800;
}

/* ===============================
   TABLE
================================= */

.table-card{
    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.table-wrapper{
    overflow-x:auto;
}

.table-modern{
    width:100%;
    border-collapse:collapse;
    min-width:950px;
}

.table-modern thead{
    background:#f1f5f9;
}

.table-modern th{
    padding:10px;
    text-align:center;
    font-size:10px;
    color:#334155;
    font-weight:700;
    white-space:nowrap;
}

.table-modern td{
    padding:10px;
    border-bottom:1px solid #e2e8f0;
    vertical-align:middle;
    white-space:nowrap;
    font-size:11px;
}

.table-modern tbody tr:hover{
    background:#f8fafc;
}

/* ===============================
   USER
================================= */

.user-box{
    display:flex;
    align-items:center;
    gap:8px;
}

.user-avatar{
    width:32px;
    height:32px;
    border-radius:50%;
    background:linear-gradient(135deg,#2563eb,#60a5fa);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    font-size:11px;
}

.user-info{
    display:flex;
    flex-direction:column;
}

.user-name{
    font-weight:700;
    color:#0f172a;
    font-size:11px;
}

.user-role{
    font-size:9px;
    color:#64748b;
}

/* ===============================
   BADGE
================================= */

.badge{
    padding:4px 8px;
    border-radius:999px;
    font-size:9px;
    font-weight:700;
}

.badge-success{
    background:#dcfce7;
    color:#166534;
}

.badge-warning{
    background:#fef3c7;
    color:#92400e;
}

/* ===============================
   TOTAL
================================= */

.total-price{
    font-weight:800;
    color:#16a34a;
    font-size:11px;
}

/* ===============================
   DATE
================================= */

.date-box{
    display:flex;
    flex-direction:column;
    gap:2px;
}

.date-main{
    font-weight:700;
    color:#0f172a;
    font-size:10px;
}

.date-time{
    font-size:9px;
    color:#64748b;
}

/* ===============================
   ACTION
================================= */

.action-group{
    display:flex;
    gap:4px;
    justify-content:center;
}

/* ===============================
   EMPTY
================================= */

.empty-box{
    text-align:center;
    padding:30px;
    color:#64748b;
    font-size:12px;
}

/* ===============================
   RESPONSIVE
================================= */

@media(max-width:1200px){

    .page-bg{
        zoom:75%;
    }

}

@media(max-width:992px){

    .page-bg{
        zoom:70%;
    }

}

</style>

<div class="page-bg">

    <!-- ===============================
         HEADER
    ================================= -->

    <div class="header-box">

        <div class="header-title">

            <h2>
                🧾 Riwayat Penjualan
            </h2>

            <p>
                Daftar seluruh transaksi penjualan toko
            </p>

        </div>

    </div>

    <!-- ===============================
         FILTER
    ================================= -->

    <form method="GET"
          action="{{ route('penjualan.index') }}"
          class="filter-box">

        <div class="filter-group">

            <label>Dari Tanggal</label>

            <input type="date"
                   name="from"
                   value="{{ request('from') }}">

        </div>

        <div class="filter-group">

            <label>Sampai Tanggal</label>

            <input type="date"
                   name="to"
                   value="{{ request('to') }}">

        </div>

        <button class="btn-modern btn-blue">

            🔍 Filter

        </button>

        <a href="{{ route('penjualan.index') }}"
           class="btn-modern btn-gray">

            ↺ Reset

        </a>

    </form>

    <!-- ===============================
         SUMMARY
    ================================= -->

    <div class="summary-grid">

        <div class="summary-card">

            <h5>Total Transaksi</h5>

            <h3>

                {{ count($data) }}

            </h3>

        </div>

        <div class="summary-card">

            <h5>Total Omzet</h5>

            <h3>

                Rp {{ number_format($data->sum('total_jual'),0,',','.') }}

            </h3>

        </div>

    </div>

    <!-- ===============================
         TABLE
    ================================= -->

    <div class="table-card">

        <div class="table-wrapper">

            <table class="table-modern">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Kode Jual</th>
                        <th>Kasir</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $item)

                    <tr>

                        <!-- NO -->
                        <td align="center">

                            {{ $loop->iteration }}

                        </td>

                        <!-- KODE -->
                        <td>

                            <strong style="color:#2563eb">

                                {{ $item->kode_jual }}

                            </strong>

                        </td>

                        <!-- USER -->
                        <td>

                            <div class="user-box">

                                <div class="user-avatar">

                                    {{ strtoupper(substr($item->user->name ?? 'A',0,1)) }}

                                </div>

                                <div class="user-info">

                                    <span class="user-name">

                                        {{ $item->user->name ?? 'Admin' }}

                                    </span>

                                    <span class="user-role">

                                        Kasir

                                    </span>

                                </div>

                            </div>

                        </td>

                        <!-- PEMBELI -->
                        <td>

                            {{ $item->nama_pembeli ?? '-' }}

                        </td>

                        <!-- TANGGAL -->
                        <td>

                            <div class="date-box">

                                <span class="date-main">

                                    {{ \Carbon\Carbon::parse($item->tanggal_jual)->translatedFormat('d M Y') }}

                                </span>

                                <span class="date-time">

                                    🕒 {{ \Carbon\Carbon::parse($item->tanggal_jual)->format('H:i') }}

                                </span>

                            </div>

                        </td>

                        <!-- TOTAL -->
                        <td>

                            <span class="total-price">

                                Rp {{ number_format($item->total_jual,0,',','.') }}

                            </span>

                        </td>

                        <!-- METODE -->
                        <td>

                            {{ $item->metode_bayar }}

                        </td>

                        <!-- STATUS -->
                        <td align="center">

                            @if($item->status_bayar == 'Lunas')

                                <span class="badge badge-success">

                                    ✔ Lunas

                                </span>

                            @else

                                <span class="badge badge-warning">

                                    ⏳ Pending

                                </span>

                            @endif

                        </td>

                        <!-- AKSI -->
                        <td>

                            <div class="action-group">

                                {{-- ✅ DIPERBAIKI: Pakai kode_jual sebagai kunci --}}
                                <!-- DETAIL -->
                                <a href="{{ route('penjualan.show',$item->kode_jual) }}"
                                   class="btn-modern btn-blue"
                                   style="padding:6px 8px;">

                                    👁

                                </a>

                                <!-- PRINT -->
                                <a href="{{ route('penjualan.nota',$item->kode_jual) }}"
                                   target="_blank"
                                   class="btn-modern btn-gray"
                                   style="padding:6px 8px;">

                                    🖨

                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('penjualan.delete',$item->kode_jual) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn-modern btn-red"
                                            style="padding:6px 8px;">

                                        🗑

                                    </button>

                                </form>

                                {{-- ✅ TAMBAHAN: TOMBOL VERIFIKASI JIKA BELUM LUNAS --}}
                                @if($item->status_bayar != 'Lunas')
                                <a href="{{ route('penjualan.verifikasi',$item->kode_jual) }}"
                                   class="btn-modern btn-green"
                                   style="padding:6px 8px;"
                                   title="Verifikasi Pembayaran">

                                    ✔
                                </a>
                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10">

                            <div class="empty-box">

                                📭 Tidak ada data penjualan

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection