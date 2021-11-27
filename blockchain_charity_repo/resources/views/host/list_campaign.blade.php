@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')

@section('pageBreadcrumb')
    <div class="group-button-top">
        <a href="{{ route('home') }}" class="btn btn-ct-primary action" role="button">
            Home</a>
        <a href="{{ route('wallet') }}" class="btn btn-ct-primary active-primary action" role="button">List Campaign</a>
        <a href="{{ route('host.list.request') }}" class="btn btn-ct-primary action" role="button">List Request</a>
    </div>
@endsection

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
                            <span>by</span> <span class="host-name">{{ $campaign->user->name }}</span>
                        </div>
                        <div class="coin">
                            {{ $campaign->current_balance }} (wei)/ mục tiêu
                            {{ $campaign->target_contribution_amount }}(wei)
                            <div class="goal">
                                <div class="coin-current"></div>
                            </div>
                        </div>
                        <div class="descripton">
                            {{ $campaign->description }}... <a class="read-more"
                                href="{{ route('host.campaign.detail', $campaign->campaign_address) }}">xem thêm</a>
                        </div>
                        <div class="donate">
                            <a class="btn btn-donate"
                                href="{{ route('host.campaign.detail', $campaign->campaign_address) }}">DONATE</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection
