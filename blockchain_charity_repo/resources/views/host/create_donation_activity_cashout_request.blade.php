@extends('layouts.default')

@section('title', 'Tạo yêu cầu rút tiền')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create_campaign.css') }}">
@endsection
@section('page-name', 'Thêm donation activity')

@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('host.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('host.campaign') }}">Dự án</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('host.campaign.detail', $donationActivity->campaign_address) }}">Chi tiết dự án</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('host.donationActivity.detail', ['blockchainAddress'=>$donationActivity->campaign_address,'donationActivityAddress'=>$donationActivity->donation_activity_address]) }}">Chi tiết hoạt động</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Tạo yêu cầu rút tiền</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form>
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
                <div class="form-group col-6" >
                    <button type="submit" class="btn btn-primary" onclick="App.requestToCreateDonationActivityCashout(); return false">Tạo yêu cầu rút tiền</button>
                </div>
                </div>
            </form>
        </div>
       
    </div>
    
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/bn.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/host_create_donation_activity_cashout_request.js') }}"></script>

    <script src="{{ asset('js/web3.min.js') }}"></script>
    <script src="{{ asset('js/truffle-contract.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@stack('scripts')
