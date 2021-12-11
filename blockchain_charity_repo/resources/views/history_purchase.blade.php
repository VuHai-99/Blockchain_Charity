@extends('layouts.default')
@php
use Carbon\Carbon;
@endphp

@section('title', 'Lịch sử mua hàng')

@section('content')
    <div class="row table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <th>Tên hoạt động</th>
                <th>Mặt hàng</th>
                <th>Số lượng</th>
                <th>Giá tiền</th>
                <th>Nơi mua</th>
                <th>Ngày mua</th>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>Hỗ trợ đồng bào miền trung</td>
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
