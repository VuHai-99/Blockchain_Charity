@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend_event.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')
@section('content')
    <div class="row create-project">
        <button class="btn">Tạo sự kiện</button>
        <button class="btn">Giao dịch</button>
    </div>
    <div class="list-events">
        <div class="event-happend">
            @for ($i = 0; $i < 10; $i++)
                <div class="event-item row">
                    <div class="image">
                        <a href="{{ route('campaign.detail', 1) }}"><img
                                src="https://tuyengiao.vn/Uploads/2021/9/20/29/tu-viec-thien-nguyen-cua-cac-nghe-si-den-chuyen-minh-bach-trong-sao-ke.jpg"
                                alt=""></a>
                    </div>
                    <div class="information">
                        <div class="campaign-name">Hỗ trợ đông bào lũ lụt miền Trung</div>
                        <div class="host">
                            <span>by</span> <span class="host-name">Phạm Văn Thiện</span>
                        </div>
                        <div class="coin">
                            $40000 coin/ mục tiêu $5000 coin
                            <div class="goal">
                                <div class="coin-current"></div>
                            </div>
                        </div>
                        <div class="descripton">
                            Dự án thiện nguyện được thành lập với mục đích cứu trợ cho nhân dân
                            miền Trung bị ảnh hưởng nặng nề trong cơn bão số 10 vừa qua. Với sự ủng hộ của rất nhiều mạnh
                            thường... <a class="read-more" href="{{ route('campaign.detail', 1) }}">xem thêm</a>
                        </div>
                        <div class="donate">
                            <button class="wrap-inp">
                                <span>$</span>
                                <input type="number" name="donate" class="inp-donate">
                            </button>
                            <input type="submit" class="btn btn-donate" value="DONATE">
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/host_list_project_blockchain.js') }}"></script>
<!-- <script src="{{ asset('js/contract.js') }}"></script> -->
<script src="{{ asset('js/web3.min.js') }}"></script>
<script src="{{ asset('js/truffle-contract.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
@endpush
@stack('scripts')
