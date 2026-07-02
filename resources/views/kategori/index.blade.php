@extends('layouts.app')

@section('content')

<style>

/* WRAPPER */
.kategori-wrapper {
    background: linear-gradient(135deg, #e0f2fe, #f8fafc);
    padding: 25px;
    border-radius: 18px;
}

/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    background: white;
    padding: 15px 18px;
    border-radius: 14px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.page-title {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* BUTTON */
.btn {
    border: none;
    border-radius: 10px;
    padding: 8px 14px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-primary {
    background: #3b82f6;
    color: #fff;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-warning {
    background: #f59e0b;
    color: #fff;
}

.btn-danger {
    background: #ef4444;
    color: #fff;
}

.btn-sm {
    padding: 6px 10px;
    font-size: 12px;
}

/* ALERT */
.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 15px;
    font-weight: 600;
}

/* TABLE CARD */
.table-container {
    background: white;
    padding: 15px;
    border-radius: 16px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.06);
}

.table-modern {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 12px;
    font-size: 14px;
}

.table-modern thead {
    background: #f1f5f9;
}

.table-modern th {
    padding: 14px;
    text-align: left;
    font-size: 12px;
    color: #475569;
    text-transform: uppercase;
}

.table-modern td {
    padding: 14px;
    border-bottom: 1px solid #e5e7eb;
    color: #0f172a;
}

.table-modern tbody tr:hover {
    background: #f8fafc;
    transition: 0.2s;
}

/* KODE */
.kode {
    color: #2563eb;
    font-weight: 700;
}

/* INPUT EDIT */
.input-edit {
    width: 100%;
    border: none;
    background: transparent;
    font-weight: 500;
    padding: 6px;
    border-radius: 8px;
    transition: 0.2s;
}

.input-edit:focus {
    background: #eff6ff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
}

/* ACTION BUTTON GROUP */
.action-group {
    display: flex;
    justify-content: flex-end;
    gap: 6px;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(5px);
    z-index: 999;
}

.modal-content {
    background: white;
    width: 420px;
    max-width: 90%;
    margin: 90px auto;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    animation: pop 0.25s ease;
}

@keyframes pop {
    from { transform: scale(0.85); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.close {
    cursor: pointer;
    font-size: 22px;
    font-weight: bold;
}

/* FORM */
.modal input {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    margin-bottom: 12px;
}

.modal label {
    font-size: 13px;
    color: #475569;
    font-weight: 600;
}

</style>

<div class="kategori-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-title">
            🏷 Data Kategori
        </div>

        <button onclick="openModal()" class="btn btn-primary">
            ➕ Tambah Kategori
        </button>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-container">

        <table class="table-modern">

            <thead>
                <tr>
                    <th></th>
                    <th>Kode</th>
                    <th>Nama Kategori</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $index => $k)
                <tr>

                    <td></td>

                    {{-- ✅ PERBAIKAN UTAMA: RAPIKAN SEMUA FORMAT KODE --}}
                    <td style="color:#2563eb;font-weight:600;">
                        @php
                            // Jika isinya angka saja → ubah jadi KTG-00x
                            if(is_numeric($k->kode_kategori)){
                                echo 'KTG-' . str_pad($k->kode_kategori, 3, '0', STR_PAD_LEFT);
                            }
                            // Jika sudah ada KTG- → tampilkan apa adanya
                            else {
                                echo $k->kode_kategori;
                            }
                        @endphp
                    </td>

                    <td>
                        <form action="{{ route('kategori.update',$k->kode_kategori) }}" method="POST" id="form{{ $k->kode_kategori }}">
                            @csrf
                            @method('PUT') {{-- ✅ WAJIB ADA SESUAI ROUTE --}}
                            <input type="text"
                                   name="nama_kategori"
                                   value="{{ $k->nama_kategori }}"
                                   class="input-edit">
                        </form>
                    </td>

                    <td>
                        <div class="action-group">

                            <button type="submit"
                                form="form{{ $k->kode_kategori }}"
                                class="btn btn-warning btn-sm">
                                ✏
                            </button>

                            <form action="{{ route('kategori.delete',$k->kode_kategori) }}"
                                  method="POST">
                                @csrf @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus data ini?')">
                                    🗑
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:20px;">
                        Tidak ada data kategori
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

{{-- MODAL --}}
<div id="modalTambah" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h3>Tambah Kategori</h3>
            <span onclick="closeModal()" class="close">&times;</span>
        </div>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf

            <label>Kode</label>
            <input type="text" value="Auto Generated" disabled>

            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" required>

            <button class="btn btn-primary" style="width:100%;">
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
    if (e.target === modal) {
        modal.style.display = "none";
    }
}
</script>

@endsection