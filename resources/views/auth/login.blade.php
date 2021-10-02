@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('Css')
    <link rel="stylesheet" href="{{ asset(mix('css/login.css')) }}">
@endsection

@section('content')
    <div class="user_card">
        <div class="d-flex justify-content-center">
            <div class="brand_logo_container">
                <img src="{{ asset('images/image_login.jpg') }}" class="brand_logo" alt="Logo">
            </div>
        </div>
        <div class="d-flex justify-content-center form_container">
            <form action="{{ route('login.towfactor') }}" method="post">
                @csrf
                @if (Session::has('notify_otp'))
                    <p class="text-danger">{{ Session::get('notify_otp') }}</p>
                @endif
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="email" class="form-control input_user" value="{{ old('email', '') }}"
                        placeholder="username">
                </div>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <div class="input-group mb-2">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control input_pass" placeholder="password">
                </div>
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                @if (Session::has('error-login'))
                    <p class="text-danger">{{ Session::get('error-login') }}</p>
                @endif
                <div class="d-flex justify-content-center mt-3 login_container">
                    <button type="submit" name="button" class="btn login_btn">Login</button>
                </div>
            </form>
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-center links">
                Don't have an account? <a href="{{ route('register') }}" class="ml-2">Sign Up</a>
            </div>
            <div class="d-flex justify-content-center links">
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            </div>
        </div>
    </div>
@endsection
