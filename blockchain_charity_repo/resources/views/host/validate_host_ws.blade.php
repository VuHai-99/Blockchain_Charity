@extends('layouts.default')

@section('title', 'Xác thực nhà từ thiện')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection

@section('pageBreadcrumb')
    <div class="group-button-top">
        <a href="{{ route('home') }}"
            class="btn btn-ct-primary  {{ Request::routeIs('hostws.home') ? 'active-primary' : '' }} action" role="button">
            Trang chủ</a>
        <a href="{{ route('wallet') }}"
            class="btn btn-ct-primary {{ Request::routeIs('hostws.validate.host') ? 'active-primary' : 'disabled' }} action"
            role="button">Xác nhận tài khoản</a>
    </div>
@endsection

@section('content')
    <div class="container-fluid management">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left" id="hostValidate">
                        @if ($host->validate_state == 0)
                            <form method="POST" action="{{ route('hostws.validate.tobehost.request') }}">
                                @csrf
                                <input id="user_address" name="user_address" value="{{ Auth::user()->user_address }}"
                                    hidden>
                                <h3 class="my-4 text-left">Xác nhận tài khoản</h3>
                                <p> Tài khoản của bạn chưa được xác nhận. </p>
                                <br>
                                <button class="btn btn-primary" type="submit">Yêu cầu xác nhận</button>
                            </form>
                        @elseif($host->validate_state == 1)

                            <h3 class="my-4 text-left">Xác nhận tài khoản</h3>
                            <p> Tài khoản của bạn đang được xác nhận. </p>
                            <br>
                            <button class="btn btn-info text-dark" disabled>Chờ xác nhận</button>
                        @elseif($host->validate_state == 2)
                            <h3 class="my-4 text-left">Xác nhận tài khoản</h3>
                            <p> Tài khoản của bạn đã xác nhận. </p>
                            <br>
                            <button class="btn btn-success text-dark" disabled>Xác nhận thành công</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
