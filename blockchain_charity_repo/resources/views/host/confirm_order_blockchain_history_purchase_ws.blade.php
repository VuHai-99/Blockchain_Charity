@extends('layouts.default')
@php
use Carbon\Carbon;
@endphp

@section('title', 'Lịch sử mua hàng')
@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @php
                $temp = explode('/', Request::url());
            @endphp
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('campaign') }}">Dự án</a></li>
            <li class="breadcrumb-item active"><a style="color:black" href="#">Lịch sử mua hàng</a></li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <th>Địa chỉ hoạt động</th>
                <th>URL</th>
                <th>Nhà cung ứng</th>
                <th>Tổng tiền</th>
                <th>Xác nhận đơn hàng trên blockchain</th>
                <th >Xác nhận hàng đã nhận</th>
            </thead>
            <tbody>
                @foreach ($order_donation_activities as $order)
                    <tr>
                        <td>{{ $order->donation_activity_address }}</td>
                        <td>{{ $order->receipt_url }}</td>
                        <td>{{ $order->retailer_address }}</td>
                        <td>
                            @if ($order->total_amount > pow(10, 17))
                                {{ number_format($order->total_amount / pow(10, 17)) }} (Ether)
                            @elseif($order->total_amount > pow(10,8))
                                {{ number_format($order->total_amount / pow(10, 8)) }} (Gwei)
                            @else
                                {{ number_format($order->total_amount) }} (wei)
                            @endif
                        </td>

                        <td>
                            @if($order->order_state == 3)
                            <form method="POST" action="{{ route('hostws.shopping.send.order.request.blockchain') }}">
                                @csrf
                                <input id="campaign_address" name="campaign_address" value="{{$order->donation_activity->campaign_address}}" hidden>
                                <input id="donation_activity_address" name="donation_activity_address" value="{{$order->donation_activity_address}}" hidden>
                                <input id="retailer_address" name="retailer_address" value="{{$order->retailer_address}}" hidden>
                                <input id="receipt_url" name="receipt_url" value="{{$order->receipt_url}}" hidden>
                                <input id="total_amount" name="total_amount" value="{{$order->total_amount}}" hidden>
                                <button class="btn btn-primary" type="submit">Tạo yêu cầu mua hàng</button>
                            </form>
                            @else
                            <button type="button" class="btn btn-success" disabled>Đã xác nhận</button>
                            @endif
                            
                        </td>
                        <td>
                            @if($order->order_state == 2)
                                <button type="button" class="btn btn-success" disabled>Đã xác nhận</button>
                            @elseif($order->order_state == 3)

                            @elseif($order->order_state == 4)
                                <button type="button" class="btn btn-info" disabled>Đợi kiểm duyệt</button>
                            @else
                                <form method="POST" action="{{ route('hostws.confirm.received.donationActivity.order') }}">
                                    @csrf
                                    <input id="donation_activity_address" name="donation_activity_address" value="{{$order->donation_activity_address}}" hidden>
                                    <input id="order_code" name="order_code" value="{{$order->order_code}}" hidden>
                                    <input id="receipt_url" name="receipt_url" value="{{$order->receipt_url}}" hidden>
                                    <button class="btn btn-primary" type="submit">Xác nhận</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

