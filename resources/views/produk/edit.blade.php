@extends('layouts.app')

@section('content')

<style>
/* --------------------------
   STYLE UTAMA
--------------------------- */
.page-wrapper {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 30px 0;
}

.card-edit {
    background: #ffffff;
    max-width: 750px;
    margin: 0 auto;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    position: relative;
    overflow: hidden;
}

/* Dekorasi sudut */
.card-edit::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 0 0 0 100%;
}

/* --------------------------
   HEADER
--------------------------- */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f2f5;
}

.page-title {
    font-size: 26px;
    font-weight: 800;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 10px;
}

.page-title::before {
    content: "✏️";
    font-size: 24px;
}

.btn {
    padding: 10px 18px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-kembali {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-kembali:hover {
    background: #f1f5f9;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.btn-simpan {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
}

.btn-simpan:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.35);
}

/* --------------------------
   ALERT
--------------------------- */
.alert {
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-info {
    background: #fffbeb;
    color: #92400e;
    border-left: 4px solid #f59e0b;
}

.alert-success {
    background: #ecfdf5;
    color: #065f46;
    border-left: 4px solid #10b981;
}

/* --------------------------
   FORM
--------------------------- */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}

.form-input,
.form-select {
    padding: 12px 16px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    font-size: 15px;
    transition: all 0.3s ease;
    background: #fdfdfe;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    background: #ffffff;
}

.form-input[readonly] {
    background: #f3f4f6;
    color: #6b7280;
    cursor: not-allowed;
}

.input-info {
    font-size: 12px;
    color: #9ca3af;
    margin-top: 2px;
}

/* --------------------------
   UPLOAD FOTO
--------------------------- */
.foto-container {
    display: flex;
    align-items: center;
    gap: 25px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed #cbd5e1;
}

.img-preview {
    width: 110px;
    height: 110px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    border: 3px solid #ffffff;
}

.file-input {
    flex: 1;
}

/* --------------------------
   FOOTER
--------------------------- */
.form-footer {
    text-align: right;
    margin-top: 35px;
    padding-top: 20px;
    border-top: 1px solid #f0f2f5;
}

/* Responsif untuk layar kecil */
@media (max-width: 600px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    .foto-container {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<div class="page-wrapper">
    <div class="card-edit">

        {{-- HEADER --}}
        <div class="page-header">
            <h1 class="page-title">Edit Data Produk</h1>
            <a href="{{ route('produk.index') }}" class="btn btn-kembali">
                ← Kembali ke Daftar
            </a>
        </div>

        {{-- ALERT --}}
        @if(session('info'))
            <div class="alert alert-info">
                ⚠️ {{ session('info') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('produk.update', $data->id_produk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">

                {{-- ID PRODUK --}}
                <div class="form-group">
                    <label class="form-label">Kode Produk</label>
                    <input type="text" name="id_produk" value="{{ $data->id_produk }}" class="form-input" readonly>
                    <span class="input-info">Kode tidak dapat diubah</span>
                </div>

                {{-- NAMA PRODUK --}}
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ $data->nama_produk }}" class="form-input" required maxlength="255">
                </div>

                {{-- HARGA --}}
                <div class="form-group">
                    <label class="form-label">Harga Produk</label>
                    <input type="number" name="harga" value="{{ $data->harga }}" class="form-input" required min="100" max="99999999.99" step="0.01">
                    <span class="input-info">Maksimal: Rp 99.999.999,99</span>
                </div>

                {{-- STOK --}}
                <div class="form-group">
                    <label class="form-label">Jumlah Stok</label>
                    <input type="number" name="stok" value="{{ $data->stok }}" class="form-input" required min="0">
                </div>

                {{-- KATEGORI --}}
                <div class="form-group full-width">
                    <label class="form-label">Kategori Produk</label>
                    <select name="kode_kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kode_kategori }}"
                                {{ $data->kode_kategori == $k->kode_kategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- FOTO --}}
                <div class="form-group full-width">
                    <label class="form-label">Foto Produk</label>
                    <div class="foto-container">
                        <img src="{{ $data->gambar ? asset('storage/'.$data->gambar) : 'https://via.placeholder.com/110?text=Tanpa+Foto' }}"
                             alt="Foto Produk" class="img-preview">

                        <div class="file-input">
                            <input type="file" name="gambar" accept="image/*" class="form-input">
                            <span class="input-info">Kosongkan jika tidak ingin mengganti foto. Format: JPG, PNG (maks 2MB)</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- TOMBOL SIMPAN --}}
            <div class="form-footer">
                <button type="submit" class="btn btn-simpan">
                    💾 Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection