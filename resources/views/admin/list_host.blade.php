@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection
@section('page-name', 'Danh sách nhà từ thiện')
@section('content')
    <div class="list-host table-responsive">
        <h3>Danh sách Host</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <th>Tên Host</th>
                <th>Email</th>
                <th>Public Key</th>
                <th>Trạng thái</th>
            </thead>
            

            <tbody>
            @foreach($users as $user)
                @if($user->role == 1)
                    <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->public_key }}</td>
                    <td class="host_validation_check" id="{{ $user->public_key }}"></td>
                    </tr>
                @endif

            @endforeach
            </tbody>
        </table>

        <h3>Danh sách Donator</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <th>Tên Donator</th>
                <th>Email</th>
                <th>Public Key</th>
            </thead>
            

            <tbody>
            @foreach($users as $user)
                @if($user->role == 0)
                    <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->public_key }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/admin_list_host_blockchain.js') }}"></script>
<!-- <script src="{{ asset('js/contract.js') }}"></script> -->
<script src="{{ asset('js/web3.min.js') }}"></script>
<script src="{{ asset('js/truffle-contract.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@stack('scripts')