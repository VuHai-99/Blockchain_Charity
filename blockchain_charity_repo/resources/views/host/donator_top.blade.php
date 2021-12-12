@extends('layouts.default')
@section('title', 'Danh sách người quyên góp nhiều nhất')
@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @php
                $temp = explode('/', Request::url());
            @endphp
             <li class="breadcrumb-item "><a style="color:black" href="{{ route('home') }}">Trang chủ</a></li>
             <li class="breadcrumb-item "><a style="color:black" href="{{ route('campaign') }}">Dự án</a></li>
             <li class="breadcrumb-item "><a style="color:black" href="#">Danh sách nhà tài trợ</a></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <th>Tên người quyên góp</th>
                <th>Địa chỉ</th>
                <th>Số tiền</th>
            </thead>
            <tbody>
                @foreach ($donators as $donator)
                    <tr>
                        <td>{{ $donator->name }}</td>
                        <td>{{ $donator->home_address }}</td>
                        <td>{{ $donator->total_donate }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
