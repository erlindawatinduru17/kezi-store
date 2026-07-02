@extends('layouts.app')

@section('content')

<style>

/* WRAPPER */
.page-wrapper {
    background: linear-gradient(135deg, #e0f2fe, #f8fafc);
    padding: 25px;
    border-radius: 18px;
}

/* CARD */
.card {
    background: white;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    max-width: 600px;
    margin: auto;
}

/* HEADER */
.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h2 {
    margin: 0;
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
}

.header p {
    margin: 5px 0 0;
    font-size: 13px;
    color: #64748b;
}

/* LABEL */
label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
}

/* INPUT */
input[type="text"] {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    outline: none;
    transition: 0.2s;
}

input[type="text"]:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}

/* BUTTON */
.btn {
    padding: 10px 14px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    transition: 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-warning:hover {
    background: #d97706;
}

.btn-secondary {
    background: #64748b;
    color: white;
}

.btn-secondary:hover {
    background: #475569;
}

/* BUTTON GROUP */
.btn-group {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

</style>

<div class="page-wrapper">

    <div class="card">

        {{-- HEADER --}}
        <div class="header">
            <h2>✏ Edit Kategori</h2>
            <p>Silakan ubah data kategori dengan benar</p>
        </div>

        {{-- FORM --}}
        <form action="{{ route('kategori.update',$data->id_kategori) }}" method="POST">
            @csrf

            <label>Nama Kategori</label>
            <input type="text"
                   name="nama_kategori"
                   value="{{ $data->nama_kategori }}"
                   required>

            {{-- BUTTON --}}
            <div class="btn-group">

                <button class="btn btn-warning">
                    💾 Update
                </button>

                <a href="{{ route('kategori.index') }}"
                   class="btn btn-secondary">
                    ← Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection