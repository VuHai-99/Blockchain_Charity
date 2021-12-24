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
                <th>Xác nhận đơn hàng đăng lên blockchain</th>
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
                            <button
                                onclick="App.hostOrderDonationActivity('{{ $order->donation_activity_address }}','{{ $order->total_amount }}','{{ $order->retailer_address }}','{{ $order->receipt_url }}','{{ $order->donation_activity->campaign->campaign_address }}'); return false">Tạo
                                yêu cầu mua hàng</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/bn.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/confirm_order_blockchain_history_purchase.js') }}"></script>
    <!-- <script src="{{ asset('js/contract.js') }}"></script> -->
    <script src="{{ asset('js/web3.min.js') }}"></script>
    <script src="{{ asset('js/truffle-contract.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush
@stack('scripts')
