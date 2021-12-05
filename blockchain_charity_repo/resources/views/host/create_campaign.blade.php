@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create_campaign.css') }}">
@endsection
@section('page-name', 'Thêm dự án')

@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('host.home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Create Campaign</a></li>
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
                    <label for="campaign_name">Tên dự án</label>
                    <input type="text" name="campaign_name" id="campaign_name" {{ old('name') }} class="form-control"
                        placeholder="Nhập tên dự án ...">
                    @error('campaign_name')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="target_contribution_amount">Số tiền dự kiến kêu gọi</label>
                    <input type="text" name="target_contribution_amount" id="target_contribution_amount"
                        value="{{ old('target_contribution_amount') }}" class="form-control"
                        placeholder="Số tiền ủng hộ tối thiểu (wei)...">
                    @error('target_contribution_amount')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6" >
                    <label for="minimum_contribution">Số tiền ủng hộ tối thiểu</label>
                    <input type="text" name="minimum_contribution" id="minimum_contribution"
                        value="{{ old('minimum_contribution') }}" class="form-control"
                        placeholder="Số tiền ủng hộ tối thiểu (wei)...">
                    @error('minimum_contribution')
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
                <div class="form-group col-6" >
                    <label for="description">Mô tả dự án</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                    @error('description')
                        <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group col-6" >
                    <button type="submit" class="btn btn-primary" onclick="App.createCampaign(); return false">Tạo Request Mở Campaign</button>
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
    <script src="{{ asset('js/host_create_campaign_blockchain.js') }}"></script>
    <!-- <script src="{{ asset('js/contract.js') }}"></script> -->
    <script src="{{ asset('js/web3.min.js') }}"></script>
    <script src="{{ asset('js/truffle-contract.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endpush
@stack('scripts')
