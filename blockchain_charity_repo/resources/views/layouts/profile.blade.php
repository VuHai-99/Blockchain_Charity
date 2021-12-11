@inject('enumUser', 'App\Enums\EnumUser')
@extends('layouts.default')

@section('page-name', 'Thông tin cá nhân')

@section('pageBreadcrumb')
    <div class="group-button-top">
        <a href="{{ route('home') }}"
            class="btn btn-ct-primary  {{ Request::routeIs('home') ? 'active-primary' : '' }} action" role="button">
            Home</a>
        <a href="{{ route('wallet') }}" class="btn btn-ct-primary active-primary action" role="button">Profile</a>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Edit Profile</h4>
                    <p class="card-category nomargin">Complete your profile</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Username</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ Auth::user()->name }}">
                                </div>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Email address</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ Auth::user()->email }}">
                                </div>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Adress</label>
                                    <input type="text" name="home_address" class="form-control"
                                        value="{{ Auth::user()->home_address }}">
                                </div>
                                @error('home_address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ Auth::user()->phone }}">
                                </div>
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @if (Auth::user()->role == $enumUser::ROLE_HOST)
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset(Auth::user()->image_card_front) }}" alt="">
                                </div>
                                <div class="col-md-4">
                                    <img src="{{ asset(Auth::user()->image_card_back) }}" alt="">
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <button class="btn btn-primary pull-right" data-toggle="modal"
                        data-target="#modal-change-password">Change Password</button>

                    <div class="modal" id="modal-change-password">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Change Password</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form action="{{ route('user.change.password') }}" method="post"
                                        id="form-change-password">
                                        @csrf
                                        <div class="form-group">
                                            <label for="old-password">Old Password</label>
                                            <input type="password" id="old-password" name="password" class="form-control"
                                                placeholder="Enter old password..." required>
                                            <p class="text-danger error-old-password"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm-password">New Password</label>
                                            <input type="password" min="8" id="new-password" name="confirm_password"
                                                class="form-control" placeholder="Enter new password..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="old-password">Password Confirm</label>
                                            <input type="password" id="confirm-password" name="password"
                                                class="form-control" placeholder="Enter password confirm..." required>
                                            <p class="text-danger error-confirm-password"></p>
                                        </div>
                                    </form>
                                    <a href="{{ route('password.request') }}" class="nav-link">Forgot password
                                        ?</a>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"
                                            id="btn-change-password">Submit</button>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger close-modal"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-avatar">
                    <a href="javascript:;">
                        <img class="img"
                            src="data:image/jpeg;base64,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" />
                    </a>
                </div>
                <div class="card-body">
                    <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                    <h4 class="card-title">Alec Thompson</h4>
                    <p class="card-description">
                        Don't be scared of the truth because we need to restart the human foundation in truth And I love you
                        like Kanye loves Kanye I love Rick Owens’ bed design but the back is...
                    </p>
                    <a href="javascript:;" class="btn btn-primary btn-round">Follow</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/page_profile.js') }}"></script>
@endsection
