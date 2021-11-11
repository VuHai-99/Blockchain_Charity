@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection
@section('page-name', 'Danh sách sự kiện')
@section('content')
    <div class="row list-campaign">
        @for ($i = 0; $i < 8; $i++)
            <div class="campaign">
                <div class="image">
                    <img src="https://www.globalgiving.org/pfil/54432/pict_featured.jpg" alt="">
                </div>
                <div class="information">
                    <div class="address">
                        An Lão / Quảng Trị
                    </div>
                    <div class="host">
                        <a href="#" class="host-name">Tổ chức thiện nguyện Việt Nam</a>
                    </div>
                    <div class="action">
                        <button class="btn donate"><a href="{{ route('donator.campaign.detail', 1) }}"> Donate <a></button>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/donator_list_project_blockchain.js') }}"></script>
<!-- <script src="{{ asset('js/contract.js') }}"></script> -->
<script src="{{ asset('js/web3.min.js') }}"></script>
<script src="{{ asset('js/truffle-contract.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@stack('scripts')
