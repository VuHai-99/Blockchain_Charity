@extends('layouts.app')

@section('title', 'OTP');

@section('Css')
    <link rel="stylesheet" href="{{ asset(mix('css/verify_otp.css')) }}">
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center container">
        <div class="card py-5 px-3">
            <h3>Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra và nhập vào phía dưới.</h3>
            <form action="{{ route('verify.otp') }}" method="post">
                @csrf
                <div class="d-flex flex-row mt-5">
                    <input type="text" class="form-control" name="otp" maxlength="6" autofocus="">
                </div>
                <div class="form-group text-center mt-2">
                    <button class="btn btn-confirm">Xác nhận</button>
                </div>
            </form>
            <div class="text-center mt-2"><span class="d-block mobile-text">Bạn chưa nhận được mã?</span><span
                    class="font-weight-bold text-danger cursor"><a href="{{ route('resend.otp') }}">Gửi lại</a></span>
            </div>
        </div>
    </div>
@endsection
