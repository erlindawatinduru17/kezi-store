@extends('layouts.app')

@section('content')

<style>
.container {
    max-width: 500px;
    margin: auto;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 12px;
}

.input-group {
    margin-bottom: 15px;
}

input {
    width: 100%;
    padding: 10px;
}

/* FOTO */
.preview {
    text-align: center;
    margin-bottom: 15px;
}

.preview img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}
</style>

<div class="container">

    <div class="card">

        <h3>Edit Profil</h3>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- ERROR --}}
        @if($errors->any())
            <div style="color:red; margin-bottom:10px;">
                @foreach($errors->all() as $e)
                    <div>- {{ $e }}</div>
                @endforeach
            </div>
        @endif

        {{-- 🔥 FORM UTAMA (PROFILE + FOTO) --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- FOTO --}}
            <div class="preview">
                <img id="previewImg"
                     src="{{ Auth::user()->foto 
                        ? asset('foto/'.Auth::user()->foto) 
                        : 'https://ui-avatars.com/api/?name='.Auth::user()->nama }}">
            </div>

            <div class="input-group">
                <label>Foto Profil</label>
                <input type="file" name="foto" onchange="previewFoto(event)">
            </div>

            {{-- NAMA --}}
            <div class="input-group">
                <label>Nama</label>
                <input type="text" name="nama" value="{{ Auth::user()->nama }}">
            </div>

            {{-- EMAIL --}}
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}">
            </div>

            {{-- PASSWORD --}}
            <div class="input-group">
                <label>Password Baru (opsional)</label>
                <input type="password" name="password">
            </div>

            <div class="input-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation">
            </div>

            <button class="btn btn-primary">
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>

{{-- 🔥 PREVIEW FOTO --}}
<script>
function previewFoto(event) {
    let reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewImg').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection