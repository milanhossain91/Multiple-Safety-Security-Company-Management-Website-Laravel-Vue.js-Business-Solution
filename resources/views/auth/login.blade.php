@extends('layout')
@section('title', 'Login')
@section('body_class', 'atsl-auth')
@section('content')
<div class="auth-card">
    <div class="auth-head">
        <div class="auth-logo"><i class="fas fa-layer-group"></i></div>
        <h1>{{ \App\Models\Setting::get('site_name', 'ATSL') }} CMS</h1>
        <p>Sign in to your dashboard</p>
    </div>
    <div class="auth-body">
        @if (session('error') || session('success'))
            <div class="alert alert-{{ session('error') ? 'danger' : 'success' }} py-2">{{ session('error') ?? session('success') }}</div>
        @endif
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group mb-0">
                <input type="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" autofocus required>
                @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>
            <div class="form-group mb-0">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-right-to-bracket mr-1"></i> Sign In</button>
        </form>
    </div>
</div>
@endsection
