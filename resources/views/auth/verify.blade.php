@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Vui lòng xác thực email của bạn') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Một liên kết xác thực đã được gửi đến email của bạn. Vui lòng kiểm tra.') }}
                            </div>
                        @endif

                        {{ __('Trước khi tiếp tục, vui lòng xác nhận email của bạn.') }}
                        {{ __('Nếu bạn chưa nhận được thông báo. Click tại đây.') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('Gửi lại yêu cầu.') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
