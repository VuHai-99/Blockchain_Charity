@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/host_list_project.css') }}">
@endsection

@section('content')
<div class="container-fluid management">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-left" id="hostValidate">
                    @if($host->validate_state == 0)
                        <form method="POST" action="{{ route('validate.tobehost.request') }}">
                            <input id="user_address" name="user_address" value="{{Auth::user()->user_address}}" hidden>
                            <h3 class="my-4 text-left">Validate Account</h3>
                            <p> Tài khoản host của bạn chưa được validate. </p>
                            <br>
                            <button class="btn btn-primary" type="submit">Request for Validation</button>
                        </form>
                    @elseif($host->validate_state == 1)
                        
                        <h3 class="my-4 text-left">Validate Account</h3>
                        <p> Tài khoản host của bạn đang được validate. </p>
                        <br>
                        <button class="btn btn-info text-dark" disabled>Waiting for Validation</button>
                    @elseif($host->validate_state == 2)
                        <h3 class="my-4 text-left">Validate Account</h3>
                        <p> Tài khoản host của bạn đã validate. </p>
                        <br>
                        <button class="btn btn-success text-dark" disabled>Successful Validation</button>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
