@extends('layouts.app')

@section('title', 'Đăng kí')

@section('Css')
    <link rel="stylesheet" href="{{ asset(mix('css/register.css')) }}">
@endsection

@section('content')
    <div class="wrap-form">
        <form action="{{ route('register.custom') }}" method="post">
            @csrf
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="name" value="{{ old('name') }}" class="form-control" placeholder="Full name" type="text">
            </div>
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                </div>
                <input name="email" value="{{ old('email') }}" class="form-control" placeholder="Email address"
                    type="email">
            </div>
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                </div>
                <input name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Phone number"
                    type="text">
            </div>
            @error('phone')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                </div>
                <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                    placeholder="Address">
            </div>
            @error('address')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input class="form-control" name="password" placeholder="Create password" type="password">
            </div>
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input class="form-control" name="password_confirmation" placeholder="Repeat password" type="password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> Create Account </button>
            </div>
            <p class="text-center">Have an account? <a id="link-login" href="{{ route('login') }}">Log In</a> </p>
        </form>
    </div>
@endsection
