@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create_campaign.css') }}">
@endsection
@section('page-name', 'Thêm dự án')

@section('pageBreadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.home') }}">Home</a></li>
        <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.campaign') }}">List Campaign</a></li>
        <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.campaign.detail', $campaign->campaign_address) }}">Campaign</a></li>
        <li class="breadcrumb-item "><a style="color:black" href="{{ route('hostws.donationActivity.detail',['blockchainAddress' => $campaign->campaign_address,'donationActivityAddress'=>$donationActivity->donation_activity_address]) }}">Donation Activity Detail</a></li>
        <li class="breadcrumb-item "><a style="color:black" href="#">Edit Donation Activity</a></li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <form action="{{  route('hostws.donationActivity.update',$donationActivity->donation_activity_address) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="form-group col-6">
                    <label for="campaign_name">Tên dự án trực thuộc</label>
                    <input type="text" class="form-control"
                        value="{{$campaign->name}}" readonly>
                    
                </div>
                <div class="form-group col-6">
                    <label for="campaign_name">Tên dự án trực thuộc</label>
                    <input type="text" class="form-control"
                        value="{{$campaign->campaign_address}}" readonly>
                    
                </div>
                <div class="form-group col-6">
                    <label>Tên đợt từ thiện</label>
                    <input type="text" name="donation_activity_name" id="donation_activity_name" class="form-control"
                        value="{{$donationActivity->donation_activity_name}}" placeholder="Tên đợt từ thiện ">
                    @error('donation_activity_name')
                    <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label>Address đợt từ thiện</label>
                    <input type="text" class="form-control"
                        value="{{$donationActivity->donation_activity_address}}" readonly>
                </div>
                <div class="form-group col-6">
                    <label for="target_contribution_amount">Số tiền dự kiến kêu gọi</label>
                    <input type="text" name="target_contribution_amount" id="target_contribution_amount"
                        value="{{ $campaign->target_contribution_amount }}" class="form-control"
                        placeholder="Số tiền ủng hộ tối thiểu (wei)...">
                    @error('target_contribution_amount')
                    <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label>Số tiền ủng hộ tối thiểu</label>
                    <input type="text"
                        value="{{ $campaign->minimum_contribution }}" class="form-control"
                        placeholder="Số tiền ủng hộ tối thiểu (wei)..." readonly>
                </div>
                <div class="form-group col-6">
                    <label for="date_start">Ngày bắt đầu</label>
                    <input type="date" name="date_start" id="date_start"
                        value="{{(\Carbon\Carbon::parse($campaign->date_start))->format('Y-m-d')}}" class="form-control"
                        placeholder="Ngày bắt đầu dự án (d-m-Y) ...">
                    @error('date_start')
                    <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="date_end">Ngày kết thúc</label>
                    <input type="date" name="date_end" id="date_end"
                        value="{{(\Carbon\Carbon::parse($campaign->date_end))->format('Y-m-d')}}" class="form-control"
                        placeholder="Ngày kết thúc dự án (d-m-Y) ...">
                    @error('date_end')
                    <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-12">
                    <label for="description">Mô tả dự án</label>
                    <textarea name="description" id="description"
                        class="form-control">{{$campaign->description}}</textarea>
                    @error('description')
                    <p class="text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="donation_activity_main_pic">Ảnh chính</label>
                    <div class="controls">
                        <input type="file" name="donation_activity_main_pic" id="donation_activity_main_pic" class="form-control"
                            onChange="donationActivityMainPic(this)">
                        @error('donation_activity_main_pic')
                        <span class="text-error">{{$message}}</span>
                        @enderror
                        <!-- <img src="" id="mainPic"> -->
                        <img id="mainPic" src="{{ (isset($donation_activity_main_pic) == true) ? url($donation_activity_main_pic->file_path) : url('images/CharityCampaignMainPicDefault.png') }}" style="width: 100px; height:100px;">
                    </div>
                </div>
                <div class="form-group col-6">
                    <label for="donation_activity_multi_img">Nhiều ảnh thêm</label>
                    <div class="controls">
                        <input type="file" name="donation_activity_multi_img[]" class="form-control" multiple=""
                            id="donation_activity_multi_img">
                        @error('donation_activity_multi_img')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="row" id="preview_img">
                            @if(!empty($donation_activity_side_pic))
                            @foreach($donation_activity_side_pic as $side_pic)
                            <div class="col-md-6">
                                <div class="view z-depth-1">
                                    <img class="thumb" src="{{url($side_pic->file_path)}}" style="width: 80px; height: 80px;">
                                </div>
                            </div>
                            @endforeach
                            @endif
                            
                        </div>
                    </div>
                </div>
                <div class="form-group col-6">
                    <button type="submit" class="btn btn-primary">Update Donation Activity</button>
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

<script type="text/javascript">
    function donationActivityMainPic(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#mainPic').attr('src', e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<script>
    $(document).ready(function () {
        $('#donation_activity_multi_img').on('change', function () { //on file input change
            if (window.File && window.FileReader && window.FileList && window
                .Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data

                $.each(data, function (index, file) { //loop though each file
                    if (/(\.|\/)(gif|jpe?g|png)$/i.test(file
                        .type)) { //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function (file) { //trigger function on successful read
                            return function (e) {
                                var img = $('<img/>').addClass('thumb').attr('src',
                                        e.target.result).width(80)
                                    .height(80); //create image element 
                                $('#preview_img').append(
                                img); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

            } else {
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });
    });

</script>
<script>

</script>
@endpush
@stack('scripts')
