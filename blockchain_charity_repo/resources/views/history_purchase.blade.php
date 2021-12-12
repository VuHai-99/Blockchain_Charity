@extends('layouts.default')
@php
use Carbon\Carbon;
@endphp

@section('title', 'Lịch sử mua hàng')

@section('css')
<link rel="stylesheet" href="{{asset('css/history_purchase.css')}}">
@endsection
@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @php
                $temp = explode('/', Request::url());
            @endphp
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('campaign') }}">Campaign</a></li>
            <li class="breadcrumb-item active"><a style="color:black" href="#">History Order</a></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <th>Tên hoạt động</th>
                <th>Mặt hàng</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Nơi mua</th>
                <th>Ngày mua</th>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->donation_activity_name }}</td>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->total_receipt }}</td>
                        <td>{{ $order->retailer_name }}</td>
                        <td>{{ Carbon::parse($order->date_of_payment)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
