@extends('layouts.default')

@section('title', 'Chi tiết dự án')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/project_detail.css') }}">
@endsection

@section('id_custom', 'backend')

@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('campaign') }}">Dự án</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#" class="active">Chi tiết dự án</a></li>

        </ol>
    </nav>
@endsection

@section('content')

    <div class="row">
        <div class="information col-md-8">
            <h1><b>{{ $campaign->name }}</b></h1>
            <!--Accordion wrapper-->
            <div class="accordion md-accordion accordion-1" id="accordionEx23" role="tablist">
                <div class="card">
                    <div class="card-header blue lighten-3 z-depth-1" role="tab" id="heading96">
                        <h5 class="text-uppercase mb-0 py-1">
                            <a class="white-text font-weight-bold" data-toggle="collapse" href="#collapse96"
                                aria-expanded="true" aria-controls="collapse96">
                                Tổng quan dự án từ thiện
                            </a>
                        </h5>
                    </div>
                    <div id="collapse96" class="collapse show" role="tabpanel" aria-labelledby="heading96">
                        <div class="card-body">
                            <div class="row my-4">
                                <div class="col-md-12">
                                    <div class="view z-depth-1">
                                        <img src="{{ $mainPic ? url($mainPic->file_path) : url('images/CharityCampaignMainPicDefault.png') }}"
                                            alt="" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-sm-left">
                                        {{ $campaign->description }}
                                    </p>
                                </div>
                                @if ($sidePics)
                                    @foreach ($sidePics as $sidePic)
                                        <div class="col-md-6">
                                            <div class="view z-depth-1">
                                                <img src="{{ url($sidePic->file_path) }}" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-6">
                                        <div class="view z-depth-1">
                                            <img src="{{ url('images/CharityCampaignSidePicDefault.png') }}" alt=""
                                                class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="view z-depth-1">
                                            <img src="{{ url('images/CharityCampaignSidePicDefault.png') }}" alt=""
                                                class="img-fluid">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
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
                                    <h4 class="text-sm-left">Tên nhà từ thiện: <b>{{ $campaign->host_name }}</b></h4>
                                    <p class="text-sm-left">Địa chỉ : {{ $campaign->user_address }}</p>
                                    <p class="text-sm-left">Email : {{ $campaign->host_email }}</p>
                                    <p class="text-sm-left">Số điện thoại : {{ $campaign->host_phone }}</p>
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
        <div class="donator col-md-4">
            <div class="coin">
                <span class="coin-donated">
                    @if ($campaign->current_balance > pow(10, 17))
                        {{ number_format($campaign->current_balance / pow(10, 17)) }} (Ether)
                    @elseif($campaign->current_balance > pow(10,8))
                        {{ number_format($campaign->current_balance / pow(10, 8)) }} (Gwei)
                    @else
                        {{ number_format($campaign->current_balance) }} (wei)
                    @endif
                </span>/
                @if ($campaign->target_contribution_amount > pow(10, 17))
                    {{ number_format($campaign->target_contribution_amount / pow(10, 17)) }} (Ether)
                @elseif($campaign->target_contribution_amount > pow(10,8))
                    {{ number_format($campaign->target_contribution_amount / pow(10, 8)) }} (Gwei)
                @else
                    {{ number_format($campaign->target_contribution_amount) }} (wei)
                @endif
                <div class="goal">
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ $campaign->current_balance / $campaign->target_contribution_amount >= 1 ? 100 : ($campaign->current_balance * 100) / $campaign->target_contribution_amount }}%"
                            aria-valuenow="{{ $campaign->current_balance }}" aria-valuemin="0"
                            aria-valuemax="{{ $campaign->target_contribution_amount }}"></div>
                    </div>
                </div>
                <br>
                <div class="number-donator">
                    <!-- <span class="number">300 donations</span> -->
                    <span
                        class="amount">${{ $campaign->target_contribution_amount - $campaign->current_balance < 0 ? 0 : $campaign->target_contribution_amount - $campaign->current_balance < 0 }}
                        to go</span>
                </div>
                <div class="triangle triangle_bottom triangle_white">

                </div>
            </div>
            <div class="btn-donate">
                <input class="form-control" placeholder="Amount of donation" id="donation_amount" name="donate">
                <br>
                <button class="btn" type="submit" id="btn_donate">
                    Quyên góp ngay
                </button>
            </div>
            <hr>
            <div class="list-donator">
                <div class="title">
                    <div class="donate-once">
                        Quyên góp nhiều nhất
                    </div>
                    <div class="donate-monthly">
                        Quyên góp gần đây
                    </div>
                </div>
                <ul class="list-donator-item" id="monthly-donator">
                    @foreach ($userDonateMonthLy as $user)
                        <li class="item">
                            <div class="money"> {{ $user->amount }} wei</div>
                            <div class="donator-name ml-2">
                                {{ $user->name }} <br>
                            </div>
                            <div class="next">
                                <a href=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                            </div>
                        </li>
                    @endforeach
                    <li class="read-more"> <a href="{{ route('campaign.monthly.donator', $campaignAddress) }}">Xem
                            chi tiết</a></li>
                </ul>
                <ul class="list-donator-item" id="top-donator">
                    @foreach ($userTopDonate as $user)
                        <li class="item">
                            <div class="money"> {{ $user->total_donate }} wei</div>
                            <div class="donator-name ml-2">
                                {{ $user->name }} <br>
                            </div>
                            <div class="next">
                                <a href=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                            </div>
                        </li>
                    @endforeach
                    <li class="read-more"> <a href="{{ route('campaign.top.donator', $campaignAddress) }}">Xem chi
                            tiết</a></li>
                </ul>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('js/page_campaign_fe.js') }}"></script>
    <script src="{{ asset('js/page_project_detail.js') }}"></script>
@endsection
@stack('scripts')
