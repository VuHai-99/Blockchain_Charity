@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create_campaign.css') }}">
@endsection
@section('page-name', 'Thêm donation activity')

@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.campaign') }}">List Campaign</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.campaign.detail', $donationActivity->campaign_address) }}">Campaign</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.donationActivity.detail', ['blockchainAddress'=>$donationActivity->campaign_address,'donationActivityAddress'=>$donationActivity->donation_activity_address]) }}">Donation Activity Detail</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Donation Activity Cashout Request</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{ route('hostws.validate.createDonationActivityCashout.request',$donationActivity->donation_activity_address) }}">
                @csrf
                <div class="row">

                <div class="form-group col-6">
                    <label for="donation_activity_name">Tên dự án</label>
                    <input type="text" name="donation_activity_name" id="donation_activity_name" class="form-control"
                        placeholder="Nhập tên đợt từ thiện" value="{{$donationActivity->campaign->name}}" readonly >
                    @error('donation_activity_name')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="donation_activity_name">Tên đợt từ thiện</label>
                    <input type="text" name="donation_activity_name" id="donation_activity_name" class="form-control" placeholder="Nhập tên đợt từ thiện" value="{{$donationActivity->donation_activity_name}}" readonly>
                    @error('donation_activity_name')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-12" >
                    <label for="cashout_value">Số tiền mặt muốn sử dụng</label>
                    <input type="text" name="cashout_value" id="cashout_value"
                        value="{{ old('cashout_value') }}" class="form-control"
                        placeholder="Số tiền mặt muốn sử dụng (wei)...">
                    @error('cashout_value')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <input name="donation_activity_address" id="donation_activity_address" class="form-control" value="{{$donationActivity->donation_activity_address}}" type="hidden">
                <input name="campaign_address" id="campaign_address" class="form-control" value="{{$donationActivity->campaign_address}}" type="hidden">
                <input name="validated_host_address" id="validated_host_address" class="form-control" value="{{Auth::user()->user_address}}" type="hidden">
                <div class="form-group col-6" >
                    <button class="btn btn-primary" type="submit">Tạo Request Cashout</button>
                </div>
                </div>
            </form>


        </div>
       
    </div>
    
@endsection

