 @extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection
@section('page-name', 'Danh sách yêu cầu mở dự án')
@section('content')
<div class="container-fluid management">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-left">
                    <h3 class="my-4 text-left">List tất cả yêu cầu mở đợt từ thiện</h3>
                </div>
            </div>
            <div class="col-md-12" id="recentRequestCreateDonationActivity">

            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="{{ asset('js/bn.js') }}"></script> -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/admin_list_create_donationActivity_request_blockchain.js') }}"></script>
<!-- <script src="{{ asset('js/contract.js') }}"></script> -->
<script src="{{ asset('js/web3.min.js') }}"></script>
<script src="{{ asset('js/truffle-contract.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@stack('scripts')