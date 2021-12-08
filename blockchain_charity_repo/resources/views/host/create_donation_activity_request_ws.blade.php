@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create_campaign.css') }}">
@endsection
@section('page-name', 'Thêm donation activity')

@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('host.home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('host.campaign.detail',$campaign->campaign_address) }}">Campaign Detail</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Request Donation Activity</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{ route('hostws.validate.openDonationActivity.request',$campaign_address_) }}">
                @csrf
                <div class="row">

                <div class="form-group col-6">
                    <label for="donation_activity_name">Tên đợt từ thiện</label>
                    <input type="text" name="donation_activity_name" id="donation_activity_name" {{ old('name') }} class="form-control"
                        placeholder="Nhập tên đợt từ thiện" required>
                    @error('donation_activity_name')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="authority_address">Địa bàn từ thiện (gần nhất)</label>
                    <select name="authority_address" id="authority_address" required class="form-control">
                        <option value="" selected disabled>Chọn tỉnh thành</option>
                        @foreach($authorities as $authority)
                            <option value="{{$authority->authority_address}}" >{{$authority->authority_location_name}}</option>
                        @endforeach
                    </select>
                    @error('target_contribution_amount')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6" >
                    <label for="date_start">Ngày bắt đầu</label>
                    <input type="date" name="date_start" id="date_start" value="{{ old('date_start') }}"
                        class="form-control" placeholder="Ngày bắt đầu dự án (d-m-Y) ...">
                    @error('date_start')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6" >
                    <label for="date_end">Ngày kết thúc</label>
                    <input type="date" name="date_end" id="date_end" {{ old('date_end') }} class="form-control"
                        placeholder="Ngày kết thúc dự án (d-m-Y) ...">
                    @error('date_end')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-12" >
                    <label for="donation_activity_description">Mô tả đợt từ thiện</label>
                    <textarea required name="donation_activity_description" id="donation_activity_description" class="form-control"></textarea>
                    @error('donation_activity_description')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <input type="hidden" id="host_address" name="host_address"  value="{{Auth::user()->user_address}}">
                <input type="hidden" id="campaign_address" name="campaign_address"  value="{{$campaign->campaign_address}}">
                <input type="hidden" id="campaign_factory" name="campaign_factory"  value="{{ env('CAMPAIGN_FACTORY_ADDRESS') }}">
                <div class="form-group col-6" >
                    <button type="submit" class="btn btn-primary" type="submit">Tạo Request Mở Donation Activity</button>
                </div>
                </div>
            </form>


        </div>
       
    </div>
    
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@stack('scripts')
