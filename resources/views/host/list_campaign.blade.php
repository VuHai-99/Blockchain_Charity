@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')
@section('content')
    <div class="row create-project">
        <button class="btn">Tạo sự kiện</button>
        <button class="btn">Giao dịch</button>
    </div>
    <div class="list-events">
        <div class="event-happend">
            @foreach ($campaigns as $campaign)
                <div class="event-item row">
                    <div class="image">
                        <a href="{{ route('host.campaign.detail', $campaign->campaign_address) }}"><img
                                src="https://tuyengiao.vn/Uploads/2021/9/20/29/tu-viec-thien-nguyen-cua-cac-nghe-si-den-chuyen-minh-bach-trong-sao-ke.jpg"
                                alt=""></a>
                    </div>
                    <div class="information">
                        <div class="campaign-name">{{ $campaign->name }}</div>
                        <div class="host">
                            <span>by</span> <span class="host-name">{{$campaign->host_address}}</span>
                        </div>
                        <div class="coin">
                            {{$campaign->current_balance}} (wei)/ mục tiêu {{$campaign->target_contribution_amount}}(wei)
                            <div class="goal">
                                <div class="coin-current"></div>
                            </div>
                        </div>
                        <div class="descripton">
                            {{$campaign->description}}... <a class="read-more" href="{{ route('host.campaign.detail',  $campaign->campaign_address) }}">xem thêm</a>
                        </div>
                        <div class="donate">
                            <a class="btn btn-donate" href="{{ route('host.campaign.detail',  $campaign->campaign_address) }}">DONATE</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/host_list_project_blockchain.js') }}"></script>
    <!-- <script src="{{ asset('js/contract.js') }}"></script> -->
    <script src="{{ asset('js/web3.min.js') }}"></script>
    <script src="{{ asset('js/truffle-contract.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
    <script src="{{ asset('js/page_campaign.js') }}"></script>
@endpush
@stack('scripts')
