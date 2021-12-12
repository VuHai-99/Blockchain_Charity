@extends('layouts.default')

@section('title', 'Danh sách yêu cầu')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection

@section('pageBreadcrumb')
    <div class="group-button-top">
        <a href="{{ route('host.campaign') }}" class="btn btn-ct-primary active-primary action float-right" role="button">Dự án</a>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('host.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Yêu cầu</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="list-events">
        <div class="event-happend">
            <h3>Yêu cầu mở dự án</h3>
            @foreach ($listRequestOpenCampaign as $requestOpenCampaign)
                
                <div class="event-item row">
                    <div class="image">
                        <img src="https://images.squarespace-cdn.com/content/v1/5572e6e3e4b013344d656d71/1511784011833-2J9DC8R6DL7A7KNSTY63/request-box.jpg?format=1500w"
                            alt="" style="width:400px;height:300px;">
                    </div>
                    <div class="information">
                        <div class="campaign-name">Tên dự án: {{ $requestOpenCampaign->campaign_name }}</div>
                        <div class="campaign-address">Địa chỉ: {{ $requestOpenCampaign->campaign_address }}</div>
                        <div class="coin">
                            Số tiền: {{ $requestOpenCampaign->amount }} (wei)
                            <br>
                            Mục tiêu: {{ $requestOpenCampaign->target_contribution_amount }}(wei)
                        </div>
                        <div class="descripton">
                            <p class="text-description">Mô tả: {{ $requestOpenCampaign->description }}</p>
                            Ngày bắt đầu: {{ $requestOpenCampaign->date_start }}
                            <br>
                            Ngày kết thúc: {{ $requestOpenCampaign->date_end }}
                        </div>
                        <div class="cancel">
                            <button class="btn btn-cancel" onclick="App.cancelOpenCampaignRequest('{{ $requestOpenCampaign->request_id }}')">HỦY</button>
                        </div>
                    </div>
                   
                    
                </div>
                <br> <br>
                <br>
                <br>
            @endforeach
            <h3>Yêu cầu mở hoạt động từ thiện</h3>
            @foreach ($listRequestOpenDonationActivity as $requestOpenDonationActivity)
                
                <div class="event-item row">
                    <div class="image">
                        <img src="https://images.squarespace-cdn.com/content/v1/5572e6e3e4b013344d656d71/1511784011833-2J9DC8R6DL7A7KNSTY63/request-box.jpg?format=1500w"
                            alt="" style="width:400px;height:300px;">
                    </div>
                    <div class="information">
                        <div class="campaign-name">Trực thuộc dự án : {{ $requestOpenDonationActivity->campaign->name }}</div>
                        <div class="campaign-address">Địa chỉ dự án: {{ $requestOpenDonationActivity->campaign->campaign_address }}</div>
                        <div class="campaign-address">Địa điểm dự kiến: {{ $requestOpenDonationActivity->authority->authority_local_name }}</div>
                        <div class="campaign-address">Thời gian diễn ra dự kiến From: {{ $requestOpenDonationActivity->date_start }} To: {{ $requestOpenDonationActivity->date_end }}</div>
                        <div class="campaign-address">Mô tả: {{ $requestOpenDonationActivity->description }}</div>
                        <div class="cancel">
                            <button class="btn btn-cancel" onclick="App.cancelOpenDonationCampaignRequest('{{ $requestOpenDonationActivity->request_id}}','{{$requestOpenDonationActivity->campaign->campaign_address}}')">HỦY</button>
                        </div>
                    </div>
                </div>
                <br> <br>
                <br>
                <br>
            @endforeach
            <h3>Yêu cầu rút tiền</h3>
            @foreach ($listRequestCreateDonationActivityCashout as $requestCreateDonationActivityCashout)
                
                <div class="event-item row">
                    <div class="image">
                        <img src="https://images.squarespace-cdn.com/content/v1/5572e6e3e4b013344d656d71/1511784011833-2J9DC8R6DL7A7KNSTY63/request-box.jpg?format=1500w"
                            alt="" style="width:400px;height:300px;">
                    </div>
                    <div class="information">
                        <div class="campaign-name">Trực thuộc dự án : {{ $requestCreateDonationActivityCashout->donation_activity->campaign->name }}</div>
                        <div class="campaign-address">Địa chỉ dự án: {{ $requestCreateDonationActivityCashout->donation_activity->campaign->campaign_address }}</div>
                        <div class="campaign-address">Trong đợt từ thiện : {{ $requestCreateDonationActivityCashout->donation_activity->donation_activity_name }}</div>
                        <div class="campaign-address">Địa chỉ đợt từ thiện : {{ $requestCreateDonationActivityCashout->donation_activity->donation_activity_address }}</div>
                        <div class="campaign-address">Số tiền mặt muốn sử dụng : {{ $requestCreateDonationActivityCashout->amount }}(wei)</div>
                        <div class="cancel">
                            <button class="btn btn-cancel" onclick="App.cancelCreateDonationCampaignCashoutRequest('{{ $requestCreateDonationActivityCashout->request_id}}','{{$requestCreateDonationActivityCashout->donation_activity->campaign->campaign_address}}')">HỦY</button>
                        </div>
                    </div>
                   
                    
                </div>
                <br> <br>
                <br>
                <br>
            @endforeach
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/bn.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/host_list_request_blockchain.js') }}"></script>
<!-- <script src="{{ asset('js/contract.js') }}"></script> -->
<script src="{{ asset('js/web3.min.js') }}"></script>
<script src="{{ asset('js/truffle-contract.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@stack('scripts')
