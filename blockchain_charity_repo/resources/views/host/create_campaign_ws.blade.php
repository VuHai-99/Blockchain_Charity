@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create_campaign.css') }}">
@endsection
@section('page-name', 'Thêm dự án')

@section('pageBreadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.home') }}">Home</a></li>
            <li class="breadcrumb-item "><a style="color:black" href="#">Create Campaign</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row wrap-form">
        <form method="POST" action="{{ route('hostws.validate.openCampaign.request') }}">
            @csrf
            <div class="form-group">
                <label for="campaign_name">Tên dự án</label>
                <input type="text" name="campaign_name" id="campaign_name" {{ old('name') }} class="form-control"
                    placeholder="Nhập tên dự án ...">
                @error('campaign_name')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="target_contribution_amount">Số tiền dự kiến kêu gọi</label>
                <input type="text" name="target_contribution_amount" id="target_contribution_amount"
                    value="{{ old('target_contribution_amount') }}" class="form-control"
                    placeholder="Số tiền ủng hộ tối thiểu (wei)...">
                @error('target_contribution_amount')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="minimum_contribution">Số tiền ủng hộ tối thiểu</label>
                <input type="text" name="minimum_contribution" id="minimum_contribution"
                    value="{{ old('minimum_contribution') }}" class="form-control"
                    placeholder="Số tiền ủng hộ tối thiểu (wei)...">
                @error('minimum_contribution')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_start">Ngày bắt đầu</label>
                <input type="date" name="date_start" id="date_start" value="{{ old('date_start') }}"
                    class="form-control" placeholder="Ngày bắt đầu dự án (d-m-Y) ...">
                @error('date_start')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_end">Ngày kết thúc</label>
                <input type="date" name="date_end" id="date_end" {{ old('date_end') }} class="form-control"
                    placeholder="Ngày kết thúc dự án (d-m-Y) ...">
                @error('date_end')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Mô tả dự án</label>
                <textarea name="description" id="description" class="form-control"></textarea>
                @error('description')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            <input id="user_address" name="user_address" value="{{ Auth::user()->user_address }}" hidden>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm </button>
            </div>
        </form>
    </div>
@endsection
