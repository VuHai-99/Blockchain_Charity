@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection

@section('pageBreadcrumb')
    <div class="group-button-top">
        <a href="{{ route('hostws.campaign') }}" class="btn btn-ct-primary active-primary action float-right" role="button">List Campaign</a>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">List Request</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="list-events">
        <div class="event-happend">
            <h3>Request to open Campaign</h3>
            @foreach ($listRequest as $request)
                <form method="POST" action="{{ route('hostws.cancel.request.openCampaign', $request->request_id) }}">
                    @csrf
                    <div class="event-item row">
                        <div class="image">
                            <img src="https://images.squarespace-cdn.com/content/v1/5572e6e3e4b013344d656d71/1511784011833-2J9DC8R6DL7A7KNSTY63/request-box.jpg?format=1500w"
                                alt="">
                        </div>
                        <div class="information">
                            <div class="campaign-name">Tên dự án: {{ $request->campaign_name }}</div>
                            <div class="campaign-address">Địa chỉ: {{ $request->campaign_address }}</div>
                            <div class="coin">
                                Số tiền: {{ $request->amount }} (wei)
                                <br>
                                Mục tiêu: {{ $request->target_contribution_amount }}(wei)
                            </div>
                            <div class="descripton">
                                <p class="text-description">Mô tả: {{ $request->description }}</p>
                                Date start: {{ $request->date_start }}
                                <br>
                                Date end: {{ $request->date_end }}
                            </div>
                            <div class="cancel">
                                <button class="btn btn-cancel" type="submit">CANCEL</button>
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
