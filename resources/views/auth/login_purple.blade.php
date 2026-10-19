@extends('layouts.author.auth.app')

@section('title')
    {{ __('Login') }}
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/login-purple.css') }}">

@endpush
@section('main_content')
<div class="baari-soft-login-section min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card baari-glass-card baari-login-card shadow-lg border-0 p-4 p-md-5 animate-fade-in">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/images/login/login-avatar.png') }}" alt="Avatar" class="rounded-circle shadow baari-avatar">
            <h2 class="fw-bold mt-3 text-light">
                {{ __(config('pages.login_title','Welcome to')) }}
                <span class="text-accent">{{ get_option('general')['title'] ?? 'SOFT BAARI' }}</span>
            </h2>
            <h6 class="text-white-50">{{ __(config('pages.login_sub_title','Please login to your account')) }}</h6>
        </div>

        <form method="POST" action="{{ route('login') }}" class="ajaxform_instant_reload">
            @csrf

            <div class="mb-3 position-relative">
                <input type="email" name="email" class="form-control rounded-3 ps-5 baari-input email" placeholder="{{ __(config('pages.login_email_text','Enter Email')) }}" value="{{ old('email', $remembered_email ?? '') }}">
                <span class="input-icon">
                    <img src="{{ asset('assets/images/icons/user.png') }}" alt="user">
                </span>
            </div>

            <div class="mb-3 position-relative">
                <input type="password" name="password" class="form-control rounded-3 ps-5 pe-5 baari-input password" placeholder="{{ __(config('pages.login_pasword_text','Enter Password')) }}" value="{{ old('password', $remembered_password ?? '') }}">
                <span class="input-icon">
                    <img src="{{ asset('assets/images/icons/lock.png') }}" alt="lock">
                </span>
                <span class="toggle-password">
                    <img src="{{ asset('assets/images/icons/show.svg') }}" alt="show" class="show-icon" style="display: none;">
                    <img src="{{ asset('assets/images/icons/Hide.svg') }}" alt="hide" class="hide-icon">
                </span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <input type="checkbox" name="remember" class="form-check-input" {{ $remembered_email ? 'checked' : '' }}>
                    <label class="form-check-label text-light">{{ __(config('pages.remember_me_text','Remember me')) }}</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none small text-accent">
                    {{ __(config('pages.forgot_password_text','Forgot Password?')) }}
                </a>
            </div>

            <button type="submit" class="btn btn-accent w-100 py-2 rounded-3 fw-semibold text-white">
                {{ __(config('pages.login_btn_text','Login')) }}
            </button>

            <div class="mt-4 text-center">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <button type="button" class="baari-role-btn bg-gradient-teal" onclick="fillup('author@baari.com','author@baari')">Super Admin</button>
                    <button type="button" class="baari-role-btn bg-gradient-orange" onclick="fillup('admin@baari.com','admin@baari')">Admin</button>
                    <button type="button" class="baari-role-btn bg-gradient-brown" onclick="fillup('staff@baari.com','staff@baari')">Staff</button>
                </div>
            </div>
        </form>
    </div>
</div>

<input type="hidden" data-model="Login" id="auth">

@endsection

@push('js')
<script src="{{ asset('assets/js/auth.js') }}"></script>

@endpush

