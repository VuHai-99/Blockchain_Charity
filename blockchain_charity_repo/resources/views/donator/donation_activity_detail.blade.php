@extends('layouts.default')

@section('title', 'Chi tiết hoạt động từ thiện')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/project_detail.css') }}">
@endsection

@section('id_custom', 'backend')

@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('donator.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('donator.campaign') }}">Dự án</a></li>
            @if (Auth::user()->wallet_type == 0)
                <li class="breadcrumb-item "><a style="color:black"
                        href="{{ route('donator.campaign.detail', $donationActivity->campaign_address) }}">Chi tiết dự
                        án</a></li>
            @else
                <li class="breadcrumb-item "><a style="color:black"
                        href="{{ route('donatorws.campaign.detail', $donationActivity->campaign_address) }}">Chi tiết dự
                        án</a></li>
            @endif
            <li class="breadcrumb-item "><a style="color:black" href="#">Chi tiết hoạt động từ thiện</a></li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="row">
        <div class="information col-md-12">
            <h1><b>Dự Án: {{ $donationActivity->campaign_name }}</b></h1>
            <h3>Hoạt động: {{ $donationActivity->donation_activity_name }}</h3>
            <br>
            <br>
            <!--Accordion wrapper-->
            <div class="accordion md-accordion accordion-1" id="accordionEx23" role="tablist">
                <div class="card">
                    <div class="card-header blue lighten-3 z-depth-1" role="tab" id="heading96">
                        <h5 class="text-uppercase mb-0 py-1">
                            <a class="white-text font-weight-bold" data-toggle="collapse" href="#collapse96"
                                aria-expanded="true" aria-controls="collapse96">
                                Thông tin
                            </a>
                        </h5>
                    </div>
                    <div id="collapse96" class="collapse show" role="tabpanel" aria-labelledby="heading96">
                        <div class="card-body">
                            <div class="row my-4">
                                <div class="col-md-12">
                                    <div class="view z-depth-1">
                                        <img src="{{ isset($donation_activity_main_pic) == true ? url($donation_activity_main_pic->file_path) : '' }}"
                                            alt="" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-sm-left">
                                        <strong class="text-sm-left">Thông tin: </strong>
                                        {{ $donationActivity->donation_activity_description }}
                                    </p>
                                    <p class="text-sm-left">
                                        <strong class="text-sm-left">Thời gian: </strong>
                                        From {{ $donationActivity->date_start }} To {{ $donationActivity->date_end }}
                                    </p>
                                    <p class="text-sm-left">
                                        <strong class="text-sm-left">Địa Điểm: </strong>
                                        {{ $donationActivity->authority->authority_local_name }}
                                    </p>
                                </div>
                                <br>
                                @if (!empty($donation_activity_side_pic))
                                    @foreach ($donation_activity_side_pic as $side_pic)
                                        <div class="col-md-6">
                                            <div class="view z-depth-1">
                                                <img src="{{ url($side_pic->file_path) }}" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header blue lighten-3 z-depth-1" role="tab" id="heading97">
                        <h5 class="text-uppercase mb-0 py-1">
                            <a class="collapsed font-weight-bold white-text" data-toggle="collapse" href="#collapse97"
                                aria-expanded="false" aria-controls="collapse97">
                                Tổng các tài sản khuyên góp sử dụng cho đợt từ thiện
                            </a>
                        </h5>
                    </div>
                    <div id="collapse97" class="collapse" role="tabpanel" aria-labelledby="heading97">
                        <div class="card-body">
                            <div class="row my-4">
                                <div class="col-md-12">
                                    @if ($listCashOut)
                                        <h3 class="full-left">Sử dụng tiền mặt</h3>
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tổng số tiền mặt</th>
                                                    <th scope="col">Authority Confirm</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($listCashOut as $cashout)
                                                    <tr>
                                                        <td class="text-center">
                                                            @if ($cashout->cashout_amount > pow(10, 17))
                                                                {{ number_format($cashout->cashout_amount / pow(10, 17)) }}
                                                                (Ether)
                                                            @elseif($cashout->cashout_amount > pow(10,8))
                                                                {{ number_format($cashout->cashout_amount / pow(10, 8)) }}
                                                                (Gwei)
                                                            @else
                                                                {{ number_format($cashout->cashout_amount) }} (wei)
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($cashout->authority_confirmation == 1)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    @endif
                                    @if ($orders)
                                        <br>
                                        <h3 class="full-left">Hoạt động mua hàng</h3>
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tổng tiền</th>
                                                    <th scope="col">Hóa Đơn</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($orders)
                                                    @foreach ($orders as $index => $order)
                                                        <tr>
                                                            <td class="text-center">
                                                                Đơn hàng {{ ++$index }}
                                                                <!-- <a href="{{ route('order.history', $order->order_id) }}"
                                                                                                                            class="nav-link">Đơn hàng {{ ++$index }}</a> -->
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $order->total_receipt }} (wei)
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route('order.history', $order->order_id) }}"
                                                                    class="nav-link">Link</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    Chưa có đơn hàng
                                                @endif


                                            </tbody>
                                        </table>
                                    @else
                                        <h4 class="font-weight-bold mb-3 black-text">Chưa có tài sản từ thiện nào.</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--Accordion wrapper-->
        </div>
    </div>

@endsection
