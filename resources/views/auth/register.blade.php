@extends('layout.app')
@section('title', 'Create account — RunnerLog')
@section('bodyClass', 'auth-page')
@section('content')
<div class="auth-shell">
  <section class="auth-visual"><div class="brand brand-light"><span class="brand-mark">R</span> RUNNERLOG</div><div class="orbit"><span></span></div><p class="auth-line">Every run tells a story.<br><strong>Make yours count.</strong></p></section>
  <section class="auth-card-wrap">
    <form class="auth-card" method="POST" action="/register">
      @csrf
      <div class="auth-tabs"><a href="/login">Log in</a><a class="active">Create account</a></div>
      <h1>Start your journey</h1><p class="subtitle">Create an account and track every kilometre.</p>
      @if ($errors->any()) <div class="form-error">{{ $errors->first() }}</div> @endif
      <label>Full name</label><input class="input" name="name" value="{{ old('name') }}" required autofocus>
      <label>Email</label><input class="input" type="email" name="email" value="{{ old('email') }}" required>
      <label>Password</label><input class="input" type="password" name="password" required>
      <label>Confirm password</label><input class="input" type="password" name="password_confirmation" required>
      <button class="primary-button" type="submit">Create RunnerLog account <span>→</span></button>
      <p class="auth-foot">Already have an account? <a href="/login">Log in</a></p>
    </form>
  </section>
</div>
@endsection
