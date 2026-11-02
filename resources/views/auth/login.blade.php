@extends('layout.app')
@section('title', 'Log in — RunnerLog')
@section('bodyClass', 'auth-page')
@section('content')
<div class="auth-shell">
  <section class="auth-visual">
    <div class="brand brand-light"><span class="brand-mark">R</span> RUNNERLOG</div>
    <div class="orbit"><span></span></div>
    <p class="auth-line">Every run tells a story.<br><strong>Make yours count.</strong></p>
  </section>
  <section class="auth-card-wrap">
    <form class="auth-card" method="POST" action="/login">
      @csrf
      <a class="mobile-brand" href="/"><span class="brand-mark">R</span> RUNNERLOG</a>
      <div class="auth-tabs"><a class="active">Log in</a><a href="/register">Create account</a></div>
      <h1>Welcome back</h1>
      <p class="subtitle">Keep moving. Your next run starts here.</p>
      @if ($errors->any()) <div class="form-error">{{ $errors->first() }}</div> @endif
      <label>Email</label>
      <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="alex@runnerlog.com" required autofocus>
      <div class="label-row"><label>Password</label><a href="#">Forgot password?</a></div>
      <input class="input" type="password" name="password" placeholder="••••••••" required>
      <label class="check"><input type="checkbox" name="remember" value="1"> Remember me</label>
      <button class="primary-button" type="submit">Log in to RunnerLog <span>→</span></button>
      <p class="auth-foot">New to RunnerLog? <a href="/register">Create an account</a></p>
    </form>
  </section>
</div>
@endsection
