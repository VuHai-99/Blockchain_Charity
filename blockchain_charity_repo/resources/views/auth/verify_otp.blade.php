@extends('layouts.app')

@section('title', 'OTP');

@section('Css')
    <link rel="stylesheet" href="{{ asset(mix('css/verify_otp.css')) }}">
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center container">
        <div class="card py-5 px-3">
            <p>Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra và nhập vào phía dưới.</p>
            <form action="{{ route('verify.otp') }}" method="post" id="form-verify-otp">
                @csrf
                <div class="d-flex flex-row mt-5">
                    <input type="text" class="form-control" name="otp" maxlength="6" autofocus="">
                </div>
            </form>
            <p class="notify text-danger"></p>
            <div class="form-group text-center mt-2">
                <button type="submit" class="btn btn-confirm">Xác nhận</button>
            </div>
            <p class="notify text-danger"></p>
            <div class="text-center mt-2"><span class="d-block mobile-text">Bạn chưa nhận được mã?</span><span
                    class="font-weight-bold text-danger cursor"><a href="{{ route('resend.otp') }}">Gửi lại</a></span>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/page_verify_otp.js') }}"></script>
@endsection
