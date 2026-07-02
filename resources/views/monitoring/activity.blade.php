@extends('layouts.app')

@section('content')

<style>

/* =========================
   GLOBAL
========================= */
body{
    color:#000;
    background:#f1f5f9;
    font-family:'Segoe UI', sans-serif;
}

/* =========================
   CARD
========================= */
.card{
    background:#ffffff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.06);
}

/* =========================
   HEADER
========================= */
.page-header{
    background:linear-gradient(135deg,#1e3a8a,#3b82f6);
    padding:20px;
    border-radius:16px;
    color:#fff;
    margin-bottom:20px;

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:24px;
    font-weight:800;
    letter-spacing:0.5px;

    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}

/* =========================
   ALERT
========================= */
.alert-success{
    background:#dcfce7;
    color:#000;
    padding:12px 15px;
    border-radius:10px;
    margin-bottom:18px;
    font-weight:600;
}

/* =========================
   FORM FILTER / PENCARIAN
========================= */
.search-date-wrapper {
    background: #f8fafc;
    padding: 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
    align-items: end;
}

.search-date-wrapper label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}

.search-date-wrapper input[type="date"],
.search-date-wrapper select {
    width: 100%;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    outline: none;
    transition: 0.2s;
    background: #fff;
}

.search-date-wrapper input:focus,
.search-date-wrapper select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px #dbeafe;
}

.btn-search {
    background: #3b82f6;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    height: 38px;
}

.btn-search:hover {
    background: #2563eb;
}

.btn-reset {
    background: #64748b;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    height: 38px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-reset:hover {
    background: #475569;
}

/* =========================
   TABLE
========================= */
.table-modern{
    width:100%;
    border-collapse:collapse;
    border-radius:16px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 8px 25px rgba(0,0,0,0.05);
}

.table-modern thead{
    background:#e2e8f0;
}

.table-modern th{
    padding:15px;
    font-size:13px;
    text-transform:uppercase;
    color:#000;
    letter-spacing:0.5px;
    font-weight:700;
}

.table-modern td{
    padding:15px;
    font-size:14px;
    color:#000;
    border-bottom:1px solid #f1f5f9;
}

.table-modern tbody tr:hover{
    background:#f8fafc;
    transition:0.2s;
}

/* =========================
   USER
========================= */
.user-name{
    font-weight:700;
    color:#000;
    font-size:15px;
}

.user-role{
    font-size:12px;
    color:#000;
    margin-top:3px;
}

/* =========================
   KETERANGAN
========================= */
.keterangan-box{
    background:#f1f5f9;
    color:#000;
    padding:10px 14px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
    display:inline-block;
    max-width:450px;
    line-height:1.6;
}

/* =========================
   BUTTON
========================= */
.btn-delete{
    background:#ef4444;
    color:#fff;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
    font-size:12px;
    font-weight:600;
    transition:0.2s;
}

.btn-delete:hover{
    background:#dc2626;
    transform:scale(1.05);
}

/* =========================
   EMPTY DATA
========================= */
.empty-data{
    text-align:center;
    padding:25px;
    color:#000;
    font-weight:600;
}

</style>


<div class="card">

    {{-- HEADER --}}
    <div class="page-header">
        📊 ACTIVITY LOG MONITORING SYSTEM
    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- FORM PENCARIAN (SUDAH SESUAI RUTE: monitoring.activity) --}}
    <form action="{{ route('monitoring.activity') }}" method="GET" class="search-date-wrapper">
        
        {{-- FILTER TANGGAL DARI --}}
        <div>
            <label>Dari Tanggal:</label>
            <input type="date" name="dari" value="{{ request('dari') }}">
        </div>

        {{-- FILTER TANGGAL SAMPAI --}}
        <div>
            <label>Sampai Tanggal:</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}">
        </div>

        {{-- FILTER BERDASARKAN USER --}}
        <div>
            <label>Pilih Pengguna:</label>
            <select name="user">
                <option value="">-- Semua Pengguna --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id_user }}" 
                        {{ request('user') == $u->id_user ? 'selected' : '' }}>
                        {{ $u->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TOMBOL AKSI --}}
        <div style="display:flex; gap:8px; align-items:flex-end;">
            <button type="submit" class="btn-search">
                🔍 Cari Data
            </button>
            <a href="{{ route('monitoring.activity') }}" class="btn-reset">
                🔄 Reset
            </a>
        </div>

    </form>


    {{-- TABLE --}}
    <table class="table-modern">

        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">User</th>
                <th width="45%">Keterangan Aktivitas</th>
                <th width="20%">Waktu</th>
                <th width="10%">Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($logs as $key => $log)

            <tr>

                {{-- NOMOR --}}
                <td>{{ $key + 1 }}
                </td>


                {{-- USER --}}
                <td>
                    <div class="user-name">
                        {{ optional($log->user)->nama ?? 'System' }}
                    </div>
                    <div class="user-role">
                        {{ optional($log->user)->jabatan ?? '-' }}
                    </div>
                </td>


                {{-- KETERANGAN --}}
                <td>
                    
                        @if(str_contains(strtolower($log->aktivitas), 'login'))
                            User melakukan login ke dalam sistem
                        @elseif(str_contains(strtolower($log->aktivitas), 'logout'))
                            User keluar dari sistem
                        @elseif(str_contains(strtolower($log->aktivitas), 'tambah'))
                            User menambahkan data baru ke sistem
                        @elseif(str_contains(strtolower($log->aktivitas), 'edit'))
                            User mengubah data pada sistem
                        @elseif(str_contains(strtolower($log->aktivitas), 'hapus'))
                            User menghapus data dari sistem
                        @elseif(str_contains(strtolower($log->aktivitas), 'transaksi'))
                            User melakukan transaksi penjualan
                        @elseif(str_contains(strtolower($log->aktivitas), 'produk'))
                            User mengakses atau mengelola data produk
                        @elseif(str_contains(strtolower($log->aktivitas), 'laporan'))
                            User membuka halaman laporan sistem
                        @else
                            {{ $log->aktivitas ?? 'Aktivitas penggunaan sistem' }}
                        @endif
                    </div>
                </td>


                {{-- WAKTU --}}
                <td>
                    {{ \Carbon\Carbon::parse($log->created_at)
                        ->timezone('Asia/Jakarta')
                        ->format('d-m-Y H:i') }} WIB
                </td>


                {{-- ACTION --}}
                <td>
                    {{-- Tombol Hapus: SUDAH SESUAI RUTE (monitoring.delete) --}}
                    <form action="{{ route('monitoring.delete', $log->id_log) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus log ini?')"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            🗑 Hapus
                        </button>
                    </form>
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" class="empty-data">
                    Tidak ada data aktivitas
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection