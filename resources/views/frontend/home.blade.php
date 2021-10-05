@extends('frontend.default')

@section('title', 'Home')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/_counter.css') }}">
@endsection

@section('content')
    <div class="reson_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h1><span>Mục đích</span></h1>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single_reson">
                        <div class="thum">
                            <div class="thum_1">
                                <img src="{{ asset('images/coins.png') }}" alt="">
                            </div>
                        </div>
                        <div class="help_content">
                            <h4>Minh bạch giao dịch</h4>
                            <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.
                            </p>
                            <a href="#" class="read_more">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_reson">
                        <div class="thum">
                            <div class="thum_1">
                                <img src="{{ asset('images/help.png') }}" alt="">
                            </div>
                        </div>
                        <div class="help_content">
                            <h4>Giúp đỡ</h4>
                            <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.
                            </p>
                            <a href="#" class="read_more">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_reson">
                        <div class="thum">
                            <div class="thum_1">
                                <img src="{{ asset('images/volunteer.png') }}" alt="">
                            </div>
                        </div>
                        <div class="help_content">
                            <h4>Tình nguyện viên</h4>
                            <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.
                            </p>
                            <a href="#" class="read_more">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="counter_area">
        <div class="container">
            <div class="counter_bg overlay">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="fa fa-calendar-check-o"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">120</h3>
                                <p>Finished Event</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="fa fa-heartbeat"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">120</h3>
                                <p>Finished Event</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="fa fa-gratipay"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">120</h3>
                                <p>Volunteer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">1200</h3>
                                <p>User</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
