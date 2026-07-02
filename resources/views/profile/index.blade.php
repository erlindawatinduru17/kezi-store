@extends('layouts.app')

@section('content')

<style>
.profile-wrapper {
    background: linear-gradient(135deg, #dbeafe, #fce7f3);
    padding: 25px;
    border-radius: 16px;
}

.profile-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    max-width: 500px;
    margin: auto;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.profile-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-bottom: 15px;
}

.btn-group {
    display: flex;
    gap: 10px;
    justify-content: center;
}
</style>

<div class="profile-wrapper">

    <div class="profile-card">

        <img src="{{ Auth::user()->foto 
            ? asset('foto/'.Auth::user()->foto) 
            : 'https://ui-avatars.com/api/?name='.Auth::user()->nama }}" 
            class="profile-img">

        <h3>{{ Auth::user()->nama }}</h3>
        <p>{{ Auth::user()->email }}</p>

        <div class="btn-group">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fa fa-edit"></i> Edit Profil
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger">
                    Logout
                </button>
            </form>
        </div>

    </div>

</div>

@endsection