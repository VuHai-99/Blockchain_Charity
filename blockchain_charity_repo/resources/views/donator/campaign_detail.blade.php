@extends('layouts.default')

@section('title', 'Chi tiết dự án')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/project_detail.css') }}">
@endsection

@section('id_custom', 'backend')

@section('pageBreadcrumb')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('donator.home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('donator.campaign') }}">List Campaign</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Campaign Detail</a></li>
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
                                        <img src="{{ (!empty($campaign_main_pic)) ? url($campaign_main_pic->file_path) : url('images/CharityCampaignMainPicDefault.png') }}"
                                            alt="" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-sm-left">
                                        {{ $campaign->description }}
                                    </p>
                                </div>
                                @if(!empty($campaign_side_pic))
                                @foreach($campaign_side_pic as $side_pic)
                                <div class="col-md-6">
                                    <div class="view z-depth-1">
                                        <img src="{{url($side_pic->file_path)}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-md-6">
                                    <div class="view z-depth-1">
                                        <img src="{{url('images/CharityCampaignSidePicDefault.png')}}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="view z-depth-1">
                                        <img src="{{url('images/CharityCampaignSidePicDefault.png')}}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if($campaign->host_address == Auth::user()->user_address)
                        <div class="card-footer text-center">
                            <a href="{{ route('host.campaign_detail.edit',$campaign->campaign_address) }}" class="btn btn-warning" role="button">Edit Campaign Information</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header blue lighten-3 z-depth-1" role="tab" id="heading97">
                        <h5 class="text-uppercase mb-0 py-1">
                            <a class="collapsed font-weight-bold white-text" data-toggle="collapse" href="#collapse97"
                                aria-expanded="false" aria-controls="collapse97">
                                Quá Trình Từ Thiện
                            </a>
                        </h5>
                    </div>
                    <div id="collapse97" class="collapse" role="tabpanel" aria-labelledby="heading97">
                        <div class="card-body">
                            <div class="row my-4">
                                <div class="col-md-12">
                                    <h4 class="font-weight-bold mb-3 black-text"><a href="#">Từ Thiện Đợt 1</a></h4>
                                    <h4 class="font-weight-bold mb-3 black-text"><a href="#">Từ Thiện Đợt 2</a></h4>
                                    <h4 class="font-weight-bold mb-3 black-text"><a href="#">Từ Thiện Đợt 3</a></h4>
                                </div>
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
                                    <h4 class="text-sm-left">Name: <b>{{$campaign->user->name}}</b></h4>
                                    <p class="text-sm-left">Address : {{$campaign->host_address}}</p>
                                    <p class="text-sm-left">Email : {{$campaign->user->email}}</p>
                                    <p class="text-sm-left">Phone : {{$campaign->user->phone}}</p>
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
                <span class="coin-donated">{{ $campaign->current_balance }} (wei)</span>/
                {{ $campaign->target_contribution_amount }}(wei)
                <div class="goal">
                <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{($campaign->current_balance / $campaign->target_contribution_amount >= 100) ? 100 : ($campaign->current_balance / $campaign->target_contribution_amount)}}%"
                            aria-valuenow="{{ $campaign->current_balance }}" aria-valuemin="0"
                            aria-valuemax="{{$campaign->target_contribution_amount}}"></div>
                    </div>
                </div>
                <br>
                <div class="number-donator">
                    <span class="number">300 donations</span>
                    <span class="amount">$2000 to go</span>
                </div>
                <div class="triangle triangle_bottom triangle_white">

                </div>
            </div>
            <div class="btn-donate">
                <input placeholder="Amount of donation" id="donation_amount" name="donation_amount">
                <button class="btn" onclick="App.donateCampaign('{{ $campaign->campaign_address }}')">DONATE
                    NOW</button>
            </div>
            <div class="list-donator">
                <div class="title">
                    <div class="donate-once">
                        <a href="">Top Donator</a>
                    </div>
                    <div class="donate-monthly">
                        <a href="">Donate Monthly</a>
                    </div>
                </div>
                <ul class="list-donator-item">
                    @for ($i = 0; $i < 15; $i++)
                        <li class="item">
                            <div class="money"> ${{ 10 * (15 - $i) }} coins</div>
                            <div class="donator-name">Phạm Văn Thiện</div>
                            <div class="next">
                                <a href=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                            </div>
                        </li>
                    @endfor
                    <li class="read-more"> <a href="{{ route('campaign.donator') }}">Xem chi tiết</a></li>
                </ul>
            </div>
        </div>
    </div>

    <hr>
    <h4 class="text-reference">Các sự kiện liên quan</h4>
    <div class="reference">
        <div class="event-reference col-3">
            <a href="">
                <div class="wrap-image">
                    <img src="https://media-cdn.laodong.vn/Storage/NewsPortal/2020/10/14/844930/Thuy-Tien-2.jpg"
                        alt="Thủy Tiên từ thiện tại Quảng Trị">
                </div>
            </a>
            <p class="title">Hỗ trợ đồng bào ở Nghệ An gặp lũ lụt năm 2020</p>
        </div>
        <div class="event-reference col-3">
            <a href="">
                <div class="wrap-image">
                    <img src="https://media-cdn.laodong.vn/Storage/NewsPortal/2020/10/14/844930/Thuy-Tien-2.jpg"
                        alt="Thủy Tiên từ thiện tại Đà Nẵng">
                </div>
            </a>
            <p class="title">Hỗ trợ đồng bào ở Nghệ An gặp lũ lụt năm 2020</p>
        </div>
        <div class="event-reference col-3">
            <a href="">
                <div class="wrap-image">
                    <img src="https://media-cdn.laodong.vn/Storage/NewsPortal/2020/10/14/844930/Thuy-Tien-2.jpg"
                        alt="Thủy Tiên từ thiện tại Quảng Bình">
                </div>
            </a>
            <p class="title">Hỗ trợ đồng bào ở Nghệ An gặp lũ lụt năm 2020</p>
        </div>
        <div class="event-reference col-3">
            <a href="">
                <div class="wrap-image">
                    <img src="https://media-cdn.laodong.vn/Storage/NewsPortal/2020/10/14/844930/Thuy-Tien-2.jpg"
                        alt="Thủy Tiên từ thiện tại Hà Tĩnh">
                </div>
            </a>
            <p class="title">Hỗ trợ đồng bào ở Nghệ An gặp lũ lụt năm 2020</p>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/bn.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/donator_specific_campaign_blockchain.js') }}"></script>
    <!-- <script src="{{ asset('js/contract.js') }}"></script> -->
    <script src="{{ asset('js/web3.min.js') }}"></script>
    <script src="{{ asset('js/truffle-contract.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@stack('scripts')
