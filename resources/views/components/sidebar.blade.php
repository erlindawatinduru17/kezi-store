{{-- ==============================================
     KOMPONEN SIDEBAR - Kez iStore
     Mode: Tampilkan Ikon Saja Saat Ditutup
=============================================== --}}

<style>
/* ================= SIDEBAR MODERN ================= */
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: linear-gradient(180deg, #0f172a, #1e293b);
    color: #e2e8f0;
    padding: 20px;
    overflow-y: auto;
    box-shadow: 4px 0 20px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
    z-index: 1000;
}

/* MODE MINI: HANYA IKON */
.sidebar.mini {
    width: 70px;
    padding: 20px 10px;
}

/* Sembunyikan tulisan dan judul saat mode mini */
.sidebar.mini h2,
.sidebar.mini .menu a span,
.sidebar.mini .dropdown-btn span,
.sidebar.mini .dropdown-btn i.fa-chevron-down {
    display: none;
}

/* Sesuaikan posisi menu saat mode mini */
.sidebar.mini .menu a,
.sidebar.mini .dropdown-btn {
    justify-content: center;
    padding: 12px 0;
}

/* Tampilkan submenu ke samping saat mode mini */
.sidebar.mini .dropdown-content {
    position: absolute;
    left: 70px;
    top: 0;
    background: #1e293b;
    width: 190px;
    padding: 10px;
    border-radius: 0 8px 8px 0;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.15);
}

/* TITLE */
.sidebar h2 {
    text-align: center;
    color: #ffffff;
    font-size: 20px;
    margin-bottom: 25px;
    font-weight: 700;
    transition: opacity 0.2s;
}
/* ================= LOGO HEADER ================= */
.sidebar-header{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    margin-bottom:25px;
    padding-bottom:15px;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

.sidebar-logo{
    width:50px;
    height:50px;
    object-fit:cover;
    border-radius:12px;
    background:#fff;
    padding:3px;
    flex-shrink:0;
}

.sidebar-title{
    color:#fff;
    font-size:22px;
    font-weight:700;
    white-space:nowrap;
}

/* MODE MINI */
.sidebar.mini .sidebar-title{
    display:none;
}

.sidebar.mini .sidebar-header{
    justify-content:center;
}

.sidebar.mini .sidebar-logo{
    width:42px;
    height:42px;
}

/* HP */
@media(max-width:768px){
    .sidebar-header{
        justify-content:flex-start;
    }

    .sidebar-title{
        display:block !important;
    }
}
/* MENU */
.menu a,
.dropdown-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-radius: 10px;
    color: #cbd5e1;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
    cursor: pointer;
    margin-bottom: 5px;
    white-space: nowrap;
}

.menu a:hover,
.dropdown-btn:hover {
    background: rgba(59, 130, 246, 0.15);
    color: #ffffff;
}

/* MENU AKTIF */
.menu a.active {
    background: #2563eb;
    color: #ffffff;
    font-weight: 600;
}

/* DROPDOWN */
.dropdown-content {
    margin-left: 10px;
    margin-top: 5px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.dropdown-content.show {
    max-height: 300px;
}

/* SUBMENU */
.dropdown-content a {
    padding-left: 35px;
    font-size: 13px;
    position: relative;
    color: #cbd5e1;
}

.dropdown-content a::before {
    content: "";
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    width: 6px;
    height: 6px;
    background: #64748b;
    border-radius: 50%;
}

.dropdown-content a:hover {
    background: rgba(59, 130, 246, 0.12);
    color: #ffffff;
}

/* IKON */
.sidebar i {
    width: 18px;
    text-align: center;
    font-size: 16px;
}

/* RESPONSIF HP */
@media (max-width: 768px) {
    .sidebar {
        left: -260px;
        width: 260px;
    }
    .sidebar.buka {
        left: 0;
    }
    /* Di HP tidak pakai mode mini */
    .sidebar.mini {
        width: 260px;
        padding: 20px;
    }
    .sidebar.mini h2,
    .sidebar.mini .menu a span,
    .sidebar.mini .dropdown-btn span,
    .sidebar.mini .dropdown-btn i.fa-chevron-down {
        display: inline-block;
    }
}
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
    <img src="{{ asset('images/sa.png') }}" alt="Logo Kez iStore" class="sidebar-logo">
    <span class="sidebar-title">Kez iStore</span>
</div>
    
    <div class="menu">
        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        {{-- MASTER DATA --}}
        @auth
        @if(Auth::user()->isAdmin())
        <div class="dropdown-btn">
            <i class="fa-solid fa-database"></i>
            <span>Master Data</span>
            <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 12px;"></i>
        </div>
        <div class="dropdown-content {{ request()->is('user*') || request()->is('kategori*') || request()->is('produk*') ? 'show' : '' }}">
            <a href="{{ route('user.index') }}" class="{{ request()->is('user*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-group"></i> <span>User</span>
            </a>
            <a href="{{ route('kategori.index') }}" class="{{ request()->is('kategori*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> <span>Kategori</span>
            </a>
            <a href="{{ route('produk.index') }}" class="{{ request()->is('produk*') ? 'active' : '' }}">
                <i class="fa-solid fa-box"></i> <span>Produk</span>
            </a>
        </div>
        @endif
        @endauth

        {{-- PENJUALAN --}}
        @auth
        @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
        <div class="dropdown-btn">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>Penjualan</span>
            <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 12px;"></i>
        </div>
        <div class="dropdown-content {{ request()->is('transaksi*') || request()->is('penjualan*') ? 'show' : '' }}">
            <a href="{{ route('transaksi.index') }}" class="{{ request()->is('transaksi*') ? 'active' : '' }}">
                <i class="fa-solid fa-cash-register"></i> <span>Transaksi Kasir</span>
            </a>
            <a href="{{ route('penjualan.index') }}" class="{{ request()->is('penjualan*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i> <span>Riwayat Penjualan</span>
            </a>
        </div>
        @endif
        @endauth

        {{-- KEUANGAN --}}
        @auth
        @if(Auth::user()->isAdmin())
        <div class="dropdown-btn">
            <i class="fa-solid fa-wallet"></i>
            <span>Keuangan</span>
            <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 12px;"></i>
        </div>
        <div class="dropdown-content {{ request()->is('keuangan*') ? 'show' : '' }}">
            <a href="{{ route('keuangan.penerimaan_kas') }}" class="{{ request()->is('keuangan/penerimaan-kas') ? 'active' : '' }}">
                <i class="fa-solid fa-sack-dollar"></i> <span>Penerimaan Kas</span>
            </a>
        </div>
        @endif
        @endauth

        {{-- LAPORAN --}}
        @auth
        @if(Auth::user()->isAdmin())
        <div class="dropdown-btn">
            <i class="fa-solid fa-chart-line"></i>
            <span>Laporan</span>
            <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 12px;"></i>
        </div>
        <div class="dropdown-content {{ request()->is('laporan*') ? 'show' : '' }}">
            <a href="{{ route('laporan.penjualan') }}" class="{{ request()->is('laporan/penjualan') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-column"></i> <span>Laporan Penjualan</span>
            </a>
            <a href="{{ route('laporan.produk_terlaris') }}" class="{{ request()->is('laporan/produk-terlaris') ? 'active' : '' }}">
                <i class="fa-solid fa-ranking-star"></i> <span>Produk Terlaris</span>
            </a>
        </div>
        @endif
        @endauth

        {{-- MONITORING --}}
        @auth
        @if(Auth::user()->isAdmin())
        <div class="dropdown-btn">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Monitoring</span>
            <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 12px;"></i>
        </div>
        <div class="dropdown-content {{ request()->is('monitoring*') ? 'show' : '' }}">
            <a href="{{ route('monitoring.activity') }}" class="{{ request()->is('monitoring/activity') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i> <span>Activity Log</span>
            </a>
            <a href="{{ route('monitoring.grafik') }}" class="{{ request()->is('monitoring/grafik') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-area"></i> <span>Grafik Penjualan</span>
            </a>
            <a href="{{ route('monitoring.produk_terlaris') }}" class="{{ request()->is('monitoring/produk-terlaris') ? 'active' : '' }}">
                <i class="fa-solid fa-fire"></i> <span>Produk Terlaris</span>
            </a>
        </div>
        @endif
        @endauth
    </div>
</div>