@extends('layouts.default')

@section('title', 'Chi tiết dự án')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/project_detail.css') }}">
@endsection

@section('id_custom', 'backend')

@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @php
                $temp = explode('/', Request::url());
            @endphp
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.campaign') }}">List Campaign</a>
            </li>
            <li class="breadcrumb-item "><a style="color:black"
                    href="{{ route('hostws.campaign.detail', $temp[6]) }}">Campaign</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Donation Activity Detail</a></li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="row">
        <div class="information col-md-12">
            <h1><b>Dự Án: {{ $campaign->name }}</b></h1>
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
                                                <img src="{{ isset($campaign_main_pic) == true ? url($campaign_main_pic->file_path) : '' }}"
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
                                                From {{ $donationActivity->date_start }} To
                                                {{ $donationActivity->date_end }}
                                            </p>
                                            <p class="text-sm-left">
                                                <strong class="text-sm-left">Địa Điểm: </strong>
                                                {{ $donationActivity->authority->authority_location_name }}
                                            </p>
                                        </div>
                                        <br>
                                        @if (!empty($campaign_side_pic))
                                            @foreach ($campaign_side_pic as $side_pic)
                                                <div class="col-md-6">
                                                    <div class="view z-depth-1">
                                                        <img src="{{ url($side_pic->file_path) }}" alt=""
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                            </div>
                        </div>
                        @if ($donationActivity->host_address == Auth::user()->user_address)
                            <div class="card-footer text-center">
                                <a href="" class="btn btn-warning" role="button">Edit Donation Activity Information</a>
                            </div>
                        @endif
                    </div>
                    @if ($donationActivity->host_address == Auth::user()->user_address)
                        <div class="card-footer text-center">
                            <a href="{{ route('hostws.donation_activity_detail.edit', $donationActivity->donation_activity_address) }}"
                                class="btn btn-warning" role="button">Edit Donation Activity Information</a>
                        </div>
                    @endif
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
                <div class="card">
                    <div class="card-header blue lighten-3 z-depth-1" role="tab" id="heading97">
                        <h5 class="text-uppercase mb-0 py-1">
                            <a class="collapsed font-weight-bold white-text" data-toggle="collapse" href="#collapse97"
                                aria-expanded="false" aria-controls="collapse97">
                                Tổng các tài sản khuyên góp sử dụng cho đợt từ thiện
                            </a>
                        </h5>
                        <h3>Hoạt động mua hàng</h3>
                        @if ($orders)
                            @foreach ($orders as $index => $order)
                                <a href="{{ route('order.history', $order->order_id) }}" class="nav-link">Đơn hàng
                                    {{ ++$index }}</a>
                            @endforeach
                        @else
                            Chưa có đơn hàng
                        @endif
                    </div>
                    <div id="collapse97" class="collapse" role="tabpanel" aria-labelledby="heading97">
                        <div class="card-body">
                            <div class="row my-4">
                                <div class="col-md-12">
                                    @if (isset($donationActivityOrders) == true || isset($donationActivityCashouts) == true)
                                        @if (isset($donationActivityCashouts) == true)
                                            @foreach ($donationActivityCashouts as $cashout)
                                                <p class="text-sm-left">
                                                    <strong class="text-sm-left">Tiền mặt: </strong>
                                                    {{ $cashout->cashout_amount }}(wei)
                                                </p>
                                            @endforeach
                                        @endif
                                        @if (isset($donationActivityOrders) == true)
                                            @foreach ($donationActivityOrders as $order)

                                            @endforeach
                                        @endif
                                    @else
                                        <h4 class="font-weight-bold mb-3 black-text">Chưa có tài sản từ thiện nào.</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($donationActivity->host_address == Auth::user()->user_address)
                            <div class="card-footer text-center">
                                <a href="{{ route('shopping', $donationActivityAddress) }}" class="btn btn-warning"
                                    role="button">Request to create
                                    Donation Activity Order</a>
                                <a href="{{ route('hostws.donationActivity.cashout.create.request', $donationActivity->donation_activity_address) }}"
                                    class="btn btn-warning" role="button">Request to create Donation Activity CashOut</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header blue lighten-3 z-depth-1" role="tab" id="heading98">
                        <h5 class="text-uppercase mb-0 py-1">
                            <a class="collapsed font-weight-bold white-text" data-toggle="collapse" href="#collapse98"
                                aria-expanded="false" aria-controls="collapse98">
                                Cá nhân / Tổ Chức Từ Thiện
                            </a>
                        </h5>
                    </div>
                    <div id="collapse98" class="collapse" role="tabpanel" aria-labelledby="heading98">
                        <div class="card-body">
                            <div class="row my-4">
                                <div class="col-md-8">
                                    <h4 class="text-sm-left">Name: <b>{{ $campaign->user->name }}</b></h4>
                                    <p class="text-sm-left">Address : {{ $donationActivity->host_address }}</p>
                                    <p class="text-sm-left">Email : {{ $campaign->user->email }}</p>
                                    <p class="text-sm-left">Phone : {{ $campaign->user->phone }}</p>
                                </div>
                                <div class="col-md-4 mt-3 pt-2">
                                    <div class="view z-depth-1">
                                        <img src="https://mdbootstrap.com/img/Photos/Others/nature.jpeg" alt=""
                                            class="img-fluid">
                                    </div>
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
