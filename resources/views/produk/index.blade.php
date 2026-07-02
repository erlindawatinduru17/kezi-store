@extends('layouts.app')

@section('content')

<style>

/* BACKGROUND WRAPPER */
.produk-wrapper {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
    padding: 25px;
    border-radius: 20px;
}

/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    padding: 10px 0;
}

.page-title {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: .3px;
}

/* BUTTON */
.btn {
    border: none;
    border-radius: 10px;
    padding: 9px 14px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s ease;
}

.btn-primary { background:#3b82f6; color:white; }
.btn-warning { background:#f59e0b; color:white; }
.btn-danger { background:#ef4444; color:white; }

.btn:hover {
    transform: translateY(-2px);
    opacity: 0.95;
}

/* FORM PENCARIAN */
.search-box {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 15px;
}

.search-input {
    padding: 9px 14px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    width: 250px;
    font-size: 13px;
    outline: none;
    transition: 0.2s;
}

.search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px #dbeafe;
}

/* TABLE CARD */
.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(0,0,0,0.05);
}

/* HEADER TABLE */
.table-modern thead {
    background: #f2f3f3;
}

.table-modern th {
    padding: 16px 14px;
    font-size: 13px;
    text-align: left;
    color: #64748b;
    font-weight: 600;
}

/* BODY TABLE */
.table-modern td {
    padding: 16px 14px;
    font-size: 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #0f172a;
    vertical-align: middle;
}

/* HOVER ROW */
.table-modern tbody tr {
    transition: 0.2s;
}

.table-modern tbody tr:hover {
    background: #f8fafc;
}

/* BADGE STOK - DIPERBARUI */
.badge {
    padding: 5px 12px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 500;
}
.badge-aman { 
    background: #dcfce7; 
    color: #166534; 
}
.badge-menipis { 
    background: #fef3c7; 
    color: #92400e; 
}
.badge-habis { 
    background: #fee2e2; 
    color: #991b1b; 
}

/* IMAGE */
.img-table {
    width: 52px;
    height: 52px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

/* HARGA */
.price {
    color: #166534;
    font-weight: 600;
}

/* ALERT */
.alert-success {
    background:#dcfce7; 
    color:#166534;
    padding:10px 14px;
    border-radius:10px;
    margin-bottom:15px;
    font-size: 13px;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    z-index: 999;
}

.modal-content {
    background: #fff;
    width: 430px;
    margin: 80px auto;
    padding: 25px;
    border-radius: 18px;
    animation: zoomIn 0.25s ease;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

@keyframes zoomIn {
    from { transform: scale(0.85); opacity:0 }
    to { transform: scale(1); opacity:1 }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-weight: 700;
    color: #0f172a;
}

.close {
    cursor: pointer;
    font-size: 22px;
    color: #94a3b8;
}

/* FORM */
.modal input,
.modal select {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    margin-bottom: 12px;
    outline: none;
    transition: 0.2s;
}

.modal input:focus,
.modal select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px #dbeafe;
}

</style>

<div class="produk-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <div class="page-title">
            📦 Data Produk
        </div>

        <button onclick="openModal()" class="btn btn-primary">
            + Tambah Produk
        </button>
    </div>

    <!-- ALERT -->
    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- FORM PENCARIAN -->
    <div class="search-box">
        <input type="text" id="cariProduk" class="search-input" placeholder="🔍 Cari nama produk...">
    </div>

    <!-- TABLE -->
    <table class="table-modern" id="tabelProduk">

        <thead>
            <tr>
                <th>ID PRODUK</th>
                <th>NAMA PRODUK</th>
                <th>HARGA</th>
                <th>STOK</th>
                <th>KATEGORI</th>
                <th>FOTO</th>
                <th>AKSI</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $p)
            <tr>

                <td style="color:#2563eb; font-weight:600;">
                    {{ $p->id_produk }}
                </td>

                <td style="font-weight:500;" class="nama-produk">
                    {{ $p->nama_produk }}
                </td>

                <td class="price">
                    Rp {{ number_format($p->harga, 0, ',', '.') }}
                </td>

                <td>
                    {{-- Logika pengecekan stok --}}
                    @php
                        $batasMenipis = 5; // Bisa diubah sesuai kebutuhan
                    @endphp

                    @if($p->stok == 0)
                        <span class="badge badge-habis">❌ Habis</span>
                    @elseif($p->stok <= $batasMenipis)
                        <span class="badge badge-menipis">⚠️ Menipis ({{ $p->stok }})</span>
                    @else
                        <span class="badge badge-aman">✅ Tersedia ({{ $p->stok }})</span>
                    @endif
                </td>

                <td>
                    {{ $p->kategori->nama_kategori ?? '-' }}
                </td>

                <td>
                    <img src="{{ $p->gambar ? asset('storage/'.$p->gambar) : 'https://via.placeholder.com/52' }}"
                         alt="Foto Produk" class="img-table">
                </td>

                <td>
                    <a href="{{ route('produk.edit', $p->id_produk) }}"
                       class="btn btn-warning" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; border-radius:8px;">
                        ✏
                    </a>

                    <form action="{{ route('produk.delete', $p->id_produk) }}" method="POST" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; border-radius:8px;"
                            onclick="return confirm('Yakin ingin menghapus produk ini?')">
                            🗑
                        </button>
                    </form>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:30px; color:#64748b;">
                    Tidak ada data produk
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>

</div>

<!-- MODAL TAMBAH PRODUK -->
<div id="modalTambah" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h3>Tambah Produk</h3>
            <span onclick="closeModal()" class="close">&times;</span>
        </div>

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="nama_produk" placeholder="Nama Produk" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <input type="number" name="stok" placeholder="Stok" required>

            <select name="kode_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->kode_kategori }}">
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <input type="file" name="gambar" accept="image/*">

            <button class="btn btn-primary" style="width:100%; margin-top:10px;">
                Simpan
            </button>
        </form>

    </div>
</div>

<script>
function openModal() {
    document.getElementById('modalTambah').style.display = 'block';
}
function closeModal() {
    document.getElementById('modalTambah').style.display = 'none';
}
window.onclick = function(e) {
    let modal = document.getElementById('modalTambah');
    if (e.target === modal) modal.style.display = "none";
}

// FITUR PENCARIAN
document.getElementById('cariProduk').addEventListener('keyup', function() {
    let kataKunci = this.value.toLowerCase();
    let baris = document.querySelectorAll('#tabelProduk tbody tr');

    baris.forEach(function(row) {
        let nama = row.querySelector('.nama-produk').textContent.toLowerCase();
        if (nama.includes(kataKunci)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

@endsection