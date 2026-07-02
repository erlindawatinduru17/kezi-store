@extends('layouts.app')

@section('content')

<style>

/* ================= MAIN CARD ================= */
.card{
    background:#ffffff;
    padding:30px;
    border-radius:22px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    border:1px solid #e5e7eb;
}

/* ================= HEADER ================= */
.page-header{
    background:linear-gradient(135deg,#1e3a8a,#3b82f6);
    padding:22px 25px;
    border-radius:18px;
    margin-bottom:25px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    color:white;
    box-shadow:0 8px 20px rgba(59,130,246,0.25);
}

.page-title{
    font-size:24px;
    font-weight:800;
    letter-spacing:0.5px;
}

/* ================= INFO GRID ================= */
.info-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:18px;
    margin-bottom:25px;
}

.info-card{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:16px;
    padding:18px;
    transition:0.2s;
}

.info-card:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

.info-label{
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    color:#64748b;
    margin-bottom:6px;
}

.info-value{
    font-size:16px;
    font-weight:700;
    color:#111827;
}

/* ================= BADGE ================= */
.badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:999px;
    font-size:12px;
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

/* ================= TABLE ================= */
.table-wrapper{
    overflow-x:auto;
    border-radius:18px;
    border:1px solid #e5e7eb;
}

.table-modern{
    width:100%;
    border-collapse:collapse;
    background:white;
}

.table-modern thead{
    background:#f8fafc;
}

.table-modern th{
    padding:16px;
    font-size:12px;
    font-weight:800;
    text-transform:uppercase;
    color:#64748b;
    letter-spacing:0.5px;
    border-bottom:1px solid #e5e7eb;
}

.table-modern td{
    padding:16px;
    font-size:14px;
    color:#111827;
    border-bottom:1px solid #f1f5f9;
}

.table-modern tbody tr:hover{
    background:#f8fafc;
}

.total-text{
    color:#16a34a;
    font-weight:800;
}

/* ================= FOOTER TOTAL ================= */
tfoot td{
    background:#f8fafc;
    font-weight:800;
    font-size:15px;
}

/* ================= BUTTON ================= */
.action-box{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:25px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 18px;
    border:none;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
    text-decoration:none;
    transition:0.2s;
}

.btn:hover{
    transform:translateY(-2px);
}

.btn-secondary{
    background:#64748b;
    color:white;
}

.btn-primary{
    background:#2563eb;
    color:white;
    box-shadow:0 6px 15px rgba(37,99,235,0.25);
}

/* ================= EMPTY ================= */
.empty-data{
    text-align:center;
    padding:30px;
    color:#64748b;
    font-weight:600;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){

    .card{
        padding:20px;
    }

    .page-header{
        flex-direction:column;
        gap:10px;
        text-align:center;
    }

    .page-title{
        font-size:20px;
    }

    .table-modern th,
    .table-modern td{
        padding:12px;
        font-size:13px;
    }

    .btn{
        width:100%;
        text-align:center;
    }

}

</style>

<div class="card">

    {{-- ================= HEADER ================= --}}
    <div class="page-header">

        <div class="page-title">
            📄 Detail Penjualan
        </div>

        <div>
            {{-- ✅ UBAH: id_jual → kode_jual --}}
            <span class="badge badge-success">
                ID : {{ $data->kode_jual }}
            </span>
        </div>

    </div>

    {{-- ================= INFO GRID ================= --}}
    <div class="info-grid">

        <div class="info-card">
            <div class="info-label">Kasir</div>
            <div class="info-value">
                {{ $data->user->nama ?? 'Admin' }}
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">Nama Pembeli</div>
            <div class="info-value">
                {{ $data->nama_pembeli ?? '-' }}
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">Nomor HP</div>
            <div class="info-value">
                {{ $data->no_hp ?? '-' }}
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">Tanggal Penjualan</div>
            <div class="info-value">
                {{ \Carbon\Carbon::parse($data->tanggal_jual)->format('d M Y') }}
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">Metode Pembayaran</div>
            <div class="info-value">
                {{ $data->metode_bayar ?? '-' }}
            </div>
        </div>

        <div class="info-card">
            <div class="info-label">Status Pembayaran</div>
            <div class="info-value">

                @if($data->status_bayar == 'Selesai' || $data->status_bayar == 'Lunas')

                    <span class="badge badge-success">
                        ✔ Lunas
                    </span>

                @else

                    <span class="badge badge-warning">
                        ⏳ Pending
                    </span>

                @endif

            </div>
        </div>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="table-wrapper">

        <table class="table-modern">

            <thead>

                <tr>
                    <th width="5%">No</th>
                    <th>Produk</th>
                    <th width="20%">Harga</th>
                    <th width="10%">Qty</th>
                    <th width="20%">Subtotal</th>
                </tr>

            </thead>

            <tbody>

                @forelse($data->details ?? [] as $d)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $d->produk->nama_produk ?? '-' }}
                    </td>

                    <td>
                        Rp {{ number_format($d->harga,0,',','.') }}
                    </td>

                    <td>
                        {{ $d->jumlah }}
                    </td>

                    <td class="total-text">
                        Rp {{ number_format($d->subtotal,0,',','.') }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="empty-data">
                        Tidak ada detail penjualan
                    </td>

                </tr>

                @endforelse

            </tbody>

            <tfoot>

                <tr>

                    <td colspan="4">
                        TOTAL PEMBAYARAN
                    </td>

                    <td class="total-text">
                        Rp {{ number_format($data->total_jual,0,',','.') }}
                    </td>

                </tr>

            </tfoot>

        </table>

    </div>

    {{-- ================= ACTION BUTTON ================= --}}
    <div class="action-box">

        <a href="{{ route('penjualan.index') }}"
           class="btn btn-secondary">

            ← Kembali

        </a>

        {{-- ✅ UBAH: id_jual → kode_jual --}}
        <a href="{{ route('penjualan.nota', $data->kode_jual) }}"
           target="_blank"
           class="btn btn-primary">

            🖨 Cetak Nota

        </a>

    </div>

</div>

@endsection