@extends('layouts.app')

@section('title', 'Đăng kí')

@section('Css')
    <link rel="stylesheet" href="{{ asset(mix('css/register.css')) }}">
@endsection

@section('content')
    <div class="wrap-form">
        <form action="{{ route('register.custom') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="wrap">
                <div class="wrap-item">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input name="name" value="{{ old('name') }}" class="form-control" placeholder="Full name"
                            type="text">
                    </div>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="wrap-item">
                    <div class="form-group input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" value="{{ old('email') }}" class="form-control" placeholder="Email address"
                            type="email">
                    </div>
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="wrap">
                <div class="wrap-item">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                        </div>
                        <input name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Phone number"
                            type="text">
                    </div>
                    @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="wrap-item">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                        </div>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                            placeholder="Address">
                    </div>
                    @error('address')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="wrap">
                <div class="wrap-item">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" name="password" placeholder="Create password" type="password">
                    </div>
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="wrap-item">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control" name="password_confirmation" placeholder="Repeat password"
                            type="password">
                    </div>
                </div>
            </div>
            <div class="select-role">
                <p>Lựa chọn tài khoản</p>
                <div class="group-radio">
                    <div class="item-select">
                        <input type="radio" name="role" id="donator" value="0" @if (old('role') == 0) checked="checked" @endif>
                        <label for="donator">Donator</label>
                    </div>
                    <div class="item-select">
                        <input type="radio" name="role" id="host" value="1" @if (old('role') == 1) checked="checked" @endif>
                        <label for="host">Organizer</label>
                    </div>
                </div>
                @error('role')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="upload-file" @if (!($errors->has('image_1') || $errors->has('image_2'))) style="display:none" @endif>
                <input type="file" name="image_card_front" value="{{ old('image_card_front') }}" id="img1" hidden>

                <div class="frame-image" id="frame1">
                    <img src="{{ asset('images/background_upload_file.png') }}" id="card1">
                    <p class="ml-2">Ảnh căn cước mặt trước</p>
                </div>
                @error('image_card_front')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <input type="file" name="image_card_back" value="{{ old('image_card_back') }}" id="img2" hidden>
                <div class="frame-image" id="frame2">
                    <img src="{{ asset('images/background_upload_file.png') }}" id="card2">
                    <p class="ml-2">Ảnh căn cước mặt sau</p>
                </div>
                @error('image_card_back')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

            </div>
            <div class=" form-group
                        text-center">
                <button type="submit" class="btn btn-primary btn-submit"> Create Account </button>
            </div>
            <p class="text-center">Have an account? <a id="link-login" href="{{ route('login') }}">Log In</a> </p>
        </form>
        @if ($errors->any())
            @foreach ($errors as $error)
                <p>{{ $error->message }}</p>
            @endforeach
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/page_register.js') }}"></script>
@endsection
