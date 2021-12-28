@extends('layouts.default')

@section('title', 'Sự kiện')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection

@section('content')
    <div class="list-events">
        <div class="event-happend">
            @foreach ($campaigns as $campaign)
                <div class="event-item row">
                    <div class="image">
                        <a href="{{ route('campaign.detail', $campaign->campaign_address) }}"><img
                                src="{{ asset('images/' . $campaign->file_path) }}" alt=""></a>
                    </div>
                    <div class="information">
                        <div class="campaign-name">{{ $campaign->name }}</div>
                        <div class="host">
                            <span>by</span> <span class="host-name">{{ $campaign->host_name }}</span>
                        </div>
                        <div class="coin">
                            @if ($campaign->current_balance >= pow(10, 17))
                                {{ number_format($campaign->current_balance / pow(10, 17)) }} (Ether)/ mục tiêu
                            @elseif($campaign->current_balance >= pow(10,8))
                                {{ number_format($campaign->current_balance / pow(10, 8)) }} (Gwei)/ mục tiêu
                            @else
                                {{ number_format($campaign->current_balance) }} (wei)/ mục tiêu
                            @endif
                            / mục tiêu
                            @if ($campaign->target_contribution_amount >= pow(10, 17))
                                {{ number_format($campaign->target_contribution_amount / pow(10, 17)) }} (Ether)
                            @elseif($campaign->target_contribution_amount >= pow(10,8))
                                {{ number_format($campaign->target_contribution_amount / pow(10, 8)) }} (Gwei)
                            @else
                                {{ number_format($campaign->target_contribution_amount) }} (wei)
                            @endif
                            <div class="goal">
                                <div class="coin-current"></div>
                            </div>
                        </div>
                        <div class="descripton" style="max-height: 50px; overflow: hidden;">
                            {{ $campaign->description }}
                        </div>
                        <a class="read-more" href="{{ route('campaign.detail', $campaign->campaign_address) }}">xem
                            thêm</a>
                        <div class="donate">
                            <a href="{{ route('login') }}" class="btn btn-donate"> Quyên góp </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/page_campaign_fe.js') }}"></script>
@endsection
