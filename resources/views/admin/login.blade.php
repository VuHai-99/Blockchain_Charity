@extends('layouts.default')

@section('title', 'Đăng nhập')

@section('css')
    <link rel="stylesheet" href="{{ asset(mix('css/login.css')) }}">
@endsection

@section('content')
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="{{ route('admin.login.verify') }}"
                            method="post">
                            @csrf
                            <h3 class="text-center title">Login</h3>
                            @if (Session::has('notify_otp'))
                                <p class="text-danger">{{ Session::get('notify_otp') }}</p>
                            @endif
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="email" id="username" class="form-control"
                                    value="{{ old('email', '') }}">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            @if (Session::has('error-login'))
                                <p class="text-danger">{{ Session::get('error-login') }}</p>
                            @endif
                            <div class="form-group group-button">
                                <input type="submit" class="btn btn-primary btn-login" value="LOGIN">
                            </div>
                            <div class="group-text">
                                Don't have an account ? <a href="{{ route('register') }}">Sign up</a>
                                <br>
                                <a href="">Forgot your password ?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
