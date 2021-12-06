@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')

@section('pageBreadcrumb')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('donator.home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">List Campaign</a></li>
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
                            src="{{ (!empty($campaign->main_pic)) ? url($campaign->main_pic->file_path) : url('images/CharityCampaignMainPicDefault.png') }}"
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
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{($campaign->current_balance / $campaign->target_contribution_amount >= 100) ? 100 : ($campaign->current_balance / $campaign->target_contribution_amount)}}%"
                                        aria-valuenow="{{ $campaign->current_balance }}" aria-valuemin="0"
                                        aria-valuemax="{{$campaign->target_contribution_amount}}"></div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="descripton">
                            {{ $campaign->description }}... <a class="read-more"
                                href="{{ route('donator.campaign.detail', $campaign->campaign_address) }}">xem thêm</a>
                        </div>
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
