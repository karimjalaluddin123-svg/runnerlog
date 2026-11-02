@extends('layout.app')
@section('title','Profile — RunnerLog')
@section('content')
@include('layout.dashboard-shell-start')
<main class="main">
    <header class="topbar"><div><p>ACCOUNT</p><h1>Profile & settings</h1></div></header>
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="form-error">{{ $errors->first() }}</div>
    @endif
    <div class="dashboard-grid">
        <section class="card profile-summary">
            <div class="avatar profile-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
            <h2>{{ auth()->user()->name }}</h2><p>{{ auth()->user()->email }}</p>
        </section>
        <form class="card form-card" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <h2>Profile information</h2>
            <div class="form-grid">
                <div><label>Name</label><input class="input" name="name" value="{{ old('name',auth()->user()->name) }}"></div>
                <div><label>Email</label><input class="input" type="email" name="email" value="{{ old('email',auth()->user()->email) }}"></div>
                <div><label>Current password</label><input class="input" type="password" name="password" placeholder="Required to change password"></div>
                <div><label>New password</label><input class="input" type="password" name="new_password"></div>
                <div class="span2"><label>Confirm new password</label><input class="input" type="password" name="new_password_confirmation"></div>
            </div>
            <button class="primary-button" style="max-width:220px">Save changes</button>
        </form>
    </div>
</main>
</div>
@endsection
