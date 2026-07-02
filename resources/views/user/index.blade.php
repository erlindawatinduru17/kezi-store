@extends('layouts.app')

@section('content')

<style>

/* WRAPPER */
.user-wrapper {
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
}

.page-title {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
}

/* BUTTON */
.btn {
    padding: 9px 14px;
    border-radius: 10px;
    border: none;
    background: #3b82f6;
    color: #fff;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s ease;
}

.btn:hover {
    background: #2563eb;
    transform: translateY(-2px);
}

.btn-sm {
    padding: 6px 10px;
    font-size: 12px;
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
    background: #f1f5f9;
}

.table-modern th {
    padding: 16px 14px;
    font-size: 13px;
    text-align: left;
    color: #64748b;
    font-weight: 600;
}

/* BODY */
.table-modern td {
    padding: 16px 14px;
    font-size: 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #0f172a;
    vertical-align: middle;
}

/* HOVER */
.table-modern tbody tr:hover {
    background: #f8fafc;
}

/* USER AVATAR */
.img-user {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #e5e7eb;
}

/* BADGE */
.badge {
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 500;
}

.badge-admin {
    background: #dbeafe;
    color: #1d4ed8;
}

.badge-kasir {
    background: #dcfce7;
    color: #166534;
}

/* ALERT */
.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 15px;
    font-size: 13px;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 15px;
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
    width: 450px;
    margin: 80px auto;
    padding: 25px;
    border-radius: 18px;
    animation: zoomIn 0.25s ease;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

@keyframes zoomIn {
    from { transform: scale(0.85); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    font-weight: 700;
    color: #0f172a;
}

.close {
    cursor: pointer;
    font-size: 24px;
    color: #94a3b8;
}

/* FORM ✅ Jarak diperpendek */
.modal input,
.modal select {
    width: 100%;
    padding: 8px 10px; /* Lebih kecil */
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    margin-bottom: 10px; /* Jarak antar input dikurangi */
    outline: none;
    transition: 0.2s;
    font-size: 14px;
}

.modal input:focus,
.modal select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px #dbeafe;
}

.note {
    font-size: 11px; /* Lebih kecil */
    color: #64748b;
}

</style>

<div class="user-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-title">
            👤 Data User
        </div>
        <button onclick="openModal('tambah')" class="btn">
            + Tambah User
        </button>
    </div>

    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- PESAN ERROR --}}
    @if($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TABLE ✅ Kolom Aksi sudah dihapus --}}
    <table class="table-modern">
        <thead>
            <tr>
                <th>ID</th>
                <th>FOTO</th>
                <th>NAMA</th>
                <th>USERNAME</th>
                <th>EMAIL</th>
                <th>JABATAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $user)
            <tr>
                <td>{{ $user->id_user }}</td>

                {{-- ✅ Foto bisa dari folder mana saja tanpa mengubah struktur --}}
                <td>
                    <img src="{{ $user->foto_url }}" alt="Foto {{ $user->nama }}" class="img-user" loading="lazy">
                </td>

                <td><strong>{{ $user->nama }}</strong></td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge {{ $user->jabatan == 'admin' ? 'badge-admin' : 'badge-kasir' }}">
                        {{ ucfirst($user->jabatan) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:30px; color:#64748b;">
                    Tidak ada data user
                </td>
            @endforelse
        </tbody>
    </table>
</div>


{{-- MODAL TAMBAH USER ✅--}}
<div id="modalUser" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah User</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>

        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
            <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Password" required>

            <select name="jabatan" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="admin" {{ old('jabatan') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kasir" {{ old('jabatan') == 'kasir' ? 'selected' : '' }}>Kasir</option>
            </select>

            <p style="margin:8px 0 4px 0; font-weight:500; font-size:13px;">Sumber Foto:</p>

            {{-- Unggah dari perangkat --}}
            <input type="file" name="foto_file" accept="image/*" style="padding:6px 8px;">
            <p class="note" style="margin:-4px 0 8px 0;">Unggah dari perangkat → disimpan di folder default</p>

            {{-- Atau masukkan alamat dari folder lain / internet --}}
            <input type="text" name="foto_url" placeholder="Atau masukkan alamat foto" value="{{ old('foto_url') }}">
            <p class="note" style="margin:-4px 0 10px 0;">Contoh: <code>uploads/foto_user/nama.jpg</code> atau <code>https://...</code></p>

            <button type="submit" class="btn" style="width:100%; margin-top:5px; padding:10px;">
                Simpan
            </button>
        </form>
    </div>
</div>
<script>
function openModal() {
    document.getElementById('modalUser').style.display = 'block';
}

function closeModal() {
    document.getElementById('modalUser').style.display = 'none';
}

window.onclick = function(e) {
    const modal = document.getElementById('modalUser');
    if (e.target === modal) modal.style.display = "none";
}

// Buka modal jika ada error
@if($errors->any())
    openModal();
@endif
</script>

@endsection