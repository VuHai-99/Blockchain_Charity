@extends('layouts.default')

@section('title', 'Danh sách yêu cầu')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection

@section('pageBreadcrumb')
    <div class="group-button-top">
        <a href="{{ route('hostws.campaign') }}" class="btn btn-ct-primary active-primary action float-right"
            role="button">Dự án</a>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Yêu cầu</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="list-events">
        <div class="event-happend">
            <h3>Yêu cầu mở dự án</h3>
            @foreach ($listRequestOpenCampaign as $requestOpenCampaign)
                <form method="POST"
                    action="{{ route('hostws.cancel.request.openCampaign', $requestOpenCampaign->request_id) }}">
                    @csrf
                    <div class="event-item row">
                        <div class="image">
                            <img src="https://images.squarespace-cdn.com/content/v1/5572e6e3e4b013344d656d71/1511784011833-2J9DC8R6DL7A7KNSTY63/request-box.jpg?format=1500w"
                                alt="" style="width:400px;height:300px;">
                        </div>
                        <div class="information">
                            <div class="campaign-name">Tên dự án: {{ $requestOpenCampaign->campaign_name }}</div>
                            <div class="campaign-address">Địa chỉ: {{ $requestOpenCampaign->campaign_address }}</div>
                            <div class="coin">
                                Số tiền:
                                @if ($requestOpenCampaign->amount > pow(10, 17))
                                    {{ number_format($requestOpenCampaign->amount / pow(10, 17)) }}
                                    (Ether)
                                @elseif($requestOpenCampaign->amount > pow(10,8))
                                    {{ number_format($requestOpenCampaign->amount / pow(10, 8)) }}
                                    (Gwei)
                                @else
                                    {{ number_format($requestOpenCampaign->amount) }} (wei)
                                @endif
                                <br>
                                Mục tiêu:
                                @if ($requestOpenCampaign->target_contribution_amount > pow(10, 17))
                                    {{ number_format($requestOpenCampaign->target_contribution_amount / pow(10, 17)) }}
                                    (Ether)
                                @elseif($requestOpenCampaign->target_contribution_amount > pow(10,8))
                                    {{ number_format($requestOpenCampaign->target_contribution_amount / pow(10, 8)) }}
                                    (Gwei)
                                @else
                                    {{ number_format($requestOpenCampaign->target_contribution_amount) }} (wei)
                                @endif
                            </div>
                            <div class="descripton">
                                <p class="text-description">Mô tả: {{ $requestOpenCampaign->description }}</p>
                                Ngày bắt đầu: {{ $requestOpenCampaign->date_start }}
                                <br>
                                Ngày kết thúc: {{ $requestOpenCampaign->date_end }}
                            </div>
                            <div class="cancel">
                                <button class="btn btn-cancel" type="submit">HỦY</button>
                            </div>
                        </div>


                    </div>
                </form>
                <br> <br>
                <br>
                <br>
            @endforeach
            <h3>Yêu cầu mở hoạt động từ thiện</h3>
            @foreach ($listRequestOpenDonationActivity as $requestOpenDonationActivity)
                <form method="POST"
                    action="{{ route('hostws.cancel.request.openDonationActivity', $requestOpenDonationActivity->request_id) }}">
                    @csrf
                    <div class="event-item row">
                        <div class="image">
                            <img src="https://images.squarespace-cdn.com/content/v1/5572e6e3e4b013344d656d71/1511784011833-2J9DC8R6DL7A7KNSTY63/request-box.jpg?format=1500w"
                                alt="" style="width:400px;height:300px;">
                        </div>
                        <div class="information">
                            <div class="campaign-name">Trực thuộc dự án :
                                {{ $requestOpenDonationActivity->campaign->name }}</div>
                            <div class="campaign-address">Địa chỉ dự án:
                                {{ $requestOpenDonationActivity->campaign->campaign_address }}</div>
                            <div class="campaign-address">Địa điểm dự kiến:
                                {{ $requestOpenDonationActivity->authority->authority_local_name }}</div>
                            <input type="hidden" id="campaign_address" name="campaign_address"
                                value="{{ $requestOpenDonationActivity->campaign->campaign_address }}">
                            <div class="campaign-address">Thời gian diễn ra dự kiến From:
                                {{ $requestOpenDonationActivity->date_start }} To:
                                {{ $requestOpenDonationActivity->date_end }}</div>
                            <div class="campaign-address">Mô tả: {{ $requestOpenDonationActivity->description }}</div>
                            <div class="cancel">
                                <button class="btn btn-cancel" type="submit">HỦY</button>
                            </div>
                        </div>


                    </div>
                </form>
                <br> <br>
                <br>
                <br>
            @endforeach
            <h3>Yêu cầu rút tiền</h3>
            @foreach ($listRequestCreateDonationActivityCashout as $requestCreateDonationActivityCashout)
                <form method="POST"
                    action="{{ route('hostws.cancel.request.createDonationActivityCashout', $requestCreateDonationActivityCashout->request_id) }}">
                    @csrf
                    <div class="event-item row">
                        <div class="image">
                            <img src="https://images.squarespace-cdn.com/content/v1/5572e6e3e4b013344d656d71/1511784011833-2J9DC8R6DL7A7KNSTY63/request-box.jpg?format=1500w"
                                alt="" style="width:400px;height:300px;">
                        </div>
                        <div class="information">
                            <div class="campaign-name">Trực thuộc dự án :
                                {{ $requestCreateDonationActivityCashout->donation_activity->campaign->name }}</div>
                            <div class="campaign-address">Địa chỉ dự án:
                                {{ $requestCreateDonationActivityCashout->donation_activity->campaign->campaign_address }}
                            </div>
                            <div class="campaign-address">Trong đợt từ thiện :
                                {{ $requestCreateDonationActivityCashout->donation_activity->donation_activity_name }}
                            </div>
                            <input type="hidden" id="campaign_address" name="campaign_address"
                                value="{{ $requestCreateDonationActivityCashout->donation_activity->campaign->campaign_address }}">
                            <div class="campaign-address">Địa chỉ đợt từ thiện :
                                {{ $requestCreateDonationActivityCashout->donation_activity->donation_activity_address }}
                            </div>
                            <div class="campaign-address">Số tiền mặt muốn sử dụng :
                                {{ $requestCreateDonationActivityCashout->amount }}(wei)</div>
                            <div class="cancel">
                                <button class="btn btn-cancel" type="submit">HỦY</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br> <br>
                <br>
                <br>
            @endforeach
            <h3>Yêu cầu mua hàng</h3>
            @foreach ($listRequestCreateDonationActivityOrder as $requestCreateDonationActivityOrder)
                <form method="POST"
                action="{{ route('hostws.cancel.request.createDonationActivityOrder', $requestCreateDonationActivityOrder->request_id) }}">
                        @csrf
                    <div class="event-item row">
                        <div class="image">
                            <img src="https://images.squarespace-cdn.com/content/v1/5572e6e3e4b013344d656d71/1511784011833-2J9DC8R6DL7A7KNSTY63/request-box.jpg?format=1500w"
                                alt="" style="width:400px;height:300px;">
                        </div>
                        <div class="information">
                            <div class="campaign-name">Trực thuộc dự án :
                                {{ $requestCreateDonationActivityOrder->donation_activity->campaign->name }}</div>
                            <div class="campaign-address">Địa chỉ dự án:
                                {{ $requestCreateDonationActivityOrder->donation_activity->campaign->campaign_address }}
                            </div>
                            <input type="hidden" id="campaign_address" name="campaign_address"
                                value="{{ $requestCreateDonationActivityOrder->donation_activity->campaign->campaign_address }}">
                            <div class="campaign-address">Trong đợt từ thiện :
                                {{ $requestCreateDonationActivityOrder->donation_activity->donation_activity_name }}</div>
                            <div class="campaign-address">Địa chỉ đợt từ thiện :
                                {{ $requestCreateDonationActivityOrder->donation_activity->donation_activity_address }}
                            </div>
                            <div class="campaign-address">Tên nhà bán lẻ :
                                {{ $requestCreateDonationActivityOrder->retailer->name }}
                            </div>
                            <div class="campaign-address">Địa chỉ nhà bán lẻ :
                                {{ $requestCreateDonationActivityOrder->retailer_address}}
                            </div>
                            <div class="campaign-address">Hóa đơn mua hàng :
                                {{ $requestCreateDonationActivityOrder->url}}
                            </div>
                            <div class="campaign-address">Tổng hóa đơn :
                                @if ($requestCreateDonationActivityOrder->amount > pow(10, 17))
                                    {{ number_format($requestCreateDonationActivityOrder->amount / pow(10, 17)) }}
                                    (Ether)
                                @elseif($requestCreateDonationActivityOrder->amount > pow(10,8))
                                    {{ number_format($requestCreateDonationActivityOrder->amount / pow(10, 8)) }}
                                    (Gwei)
                                @else
                                    {{ number_format($requestCreateDonationActivityOrder->amount) }} (wei)
                                @endif
                                <div class="cancel">
                                    <button class="btn btn-cancel" type="submit">HỦY</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
                <br> <br>
                <br>
                <br>
            @endforeach
        </div>
    </div>
@endsection
