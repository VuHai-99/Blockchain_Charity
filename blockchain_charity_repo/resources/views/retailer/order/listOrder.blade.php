@extends('retailer.master')
@section('title', 'Quản lí đơn hàng')
@section('main')
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="panel panel-primary">
            <div class="panel-heading text-center">Quản lí đơn hàng</div>
            <div class="panel-body">
                <div class="col-md-12" id="confirmOrder">

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div><!--/.row-->
    
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/retailer_list_order_blockchain.js') }}"></script>
<!-- <script src="{{ asset('js/contract.js') }}"></script> -->
<script src="{{ asset('js/web3.min.js') }}"></script>
<script src="{{ asset('js/truffle-contract.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush
@stack('scripts')
