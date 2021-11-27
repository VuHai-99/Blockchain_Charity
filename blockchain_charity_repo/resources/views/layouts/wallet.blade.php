@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/my_wallet.css') }}">
@endsection
@section('title', 'Ví của bạn')
@section('pageBreadcrumb')
    <div class="group-button-top">
        <a href="{{ route('home') }}"
            class="btn btn-ct-primary  {{ Request::routeIs('home') ? 'active-primary' : '' }} action" role="button">
            Home</a>
        <a href="{{ route('wallet') }}"
            class="btn btn-ct-primary {{ Request::routeIs('wallet') ? 'active-primary' : 'disabled' }} action"
            role="button">My Wallet</a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="wallet col-md-4">
            <div class="card " style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('images/icons/wallet.jpg') }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Số tiền của bạn</h5>
                    <p class="card-text">{{ Auth::user()->amount_of_money ? Auth::user()->amount_of_money : 0 }} $</p>
                    <a href="#" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <div class="col-md-8 key">
            <form id="form-change-key">
                <div class="form-group">
                    <label for="">Public key</label>
                    <input type="text" value="{{ old('public_key', Auth::user()->user_address) }}" class="form-control"
                        readonly name="public_key">
                    @error('public_key')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group private-key">
                    <label for="">Private key</label>
                    <input type="password" value="{{ old('private_key', Auth::user()->private_key) }}" readonly
                        class="form-control" name="private_key">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    <i class="fa fa-eye-slash" aria-hidden="true" data-toggle="modal" data-target="#form-password"></i>
                </div>
                @error('private_key')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button class="btn btn-primary" id="btn-change-key">Change key</button>
            </form>
            <div class="modal" id="form-password">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Nhập mật khẩu của bạn</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="" method="post" id="confirm-password">
                                <input type="password" name="password" class="form-control" required autofocus>
                                <p class="text-danger error-password"></p>
                                <button class="btn btn-primary mt-2" type="submit">Submit</button>
                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <button class="hidden" data-toggle="modal" data-target="#form-otp" id="control-modal-otp"></button>
            <div class="modal" id="form-otp">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Nhập mã OTP</h4>
                            <button type="button" class="close-form-otp" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p class="text-infor">Mã OTP đã được gửi đến mail của bạn. Vui long kiểm tra và nhập vào
                                bên dưới.</p>
                            <form action="" method="post" id="confirm-otp">
                                <input type="text" name="otp" class="form-control" required autofocus>
                                <p class="text-danger error-otp"></p>
                                <button class="btn btn-primary mt-2" type="submit">Submit</button>
                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger close-form-otp" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/page_wallet.js') }}"></script>
@endsection
