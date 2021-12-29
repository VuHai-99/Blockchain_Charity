@extends('layouts.default')

@section('title', 'Danh sách dự án')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')

@section('pageBreadcrumb')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('donator.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Dự án</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="list-events">
        <div class="event-happend">
            @foreach ($campaigns as $campaign)
                <div class="event-item row">
                    <div class="image">
                        <a href="{{ route('donator.campaign.detail', $campaign->campaign_address) }}"><img
                                src="{{ !empty($campaign->main_pic) ? url($campaign->main_pic->file_path) : url('images/CharityCampaignMainPicDefault.png') }}"
                                alt=""></a>
                    </div>
                    <div class="information">
                        <div class="campaign-name">{{ $campaign->name }}</div>
                        <div class="host">
                            <span>by</span> <span class="host-name">{{ $campaign->user->name }}</span>
                        </div>
                        <div class="coin">
                            @if ($campaign->current_balance > pow(10, 17))
                                {{ number_format($campaign->current_balance / pow(10, 17)) }} (Ether)/ mục tiêu
                            @elseif($campaign->current_balance > pow(10,8))
                                {{ number_format($campaign->current_balance / pow(10, 8)) }} (Gwei)/ mục tiêu
                            @else
                                {{ number_format($campaign->current_balance) }} (wei)/ mục tiêu
                            @endif
                            @if ($campaign->target_contribution_amount > pow(10, 17))
                                {{ number_format($campaign->target_contribution_amount / pow(10, 17)) }} (Ether)/ mục
                                tiêu
                            @elseif($campaign->target_contribution_amount > pow(10,8))
                                {{ number_format($campaign->target_contribution_amount / pow(10, 8)) }} (Gwei)/ mục tiêu
                            @else
                                {{ number_format($campaign->target_contribution_amount) }} (wei)/ mục tiêu
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
                        </div>
                        <div class="description">
                            {{ $campaign->description }}
                        </div>
                        ... <a class="read-more"
                            href="{{ route('donator.campaign.detail', $campaign->campaign_address) }}">xem thêm</a>
                        <div class="donate">
                            <a class="btn btn-donate"
                                href="{{ route('donator.campaign.detail', $campaign->campaign_address) }}">DONATE</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
@endsection
