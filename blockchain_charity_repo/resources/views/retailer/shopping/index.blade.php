<!DOCTYPE html>
<html>
{{-- <head> --}}

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('retailer/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('retailer/css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/theme/ag/argon.min.css?v=1.2.0" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script type="text/javascript">
        $(function() {
            var pull = $('#pull');
            menu = $('nav ul');
            menuHeight = menu.height();

            $(pull).on('click', function(e) {
                e.preventDefault();
                menu.slideToggle();
            });
        });

        $(window).resize(function() {
            var w = $(window).width();
            if (w > 320 && menu.is(':hidden')) {
                menu.removeAttr('style');
            }
        });
    </script>
</head>
{{-- </head> --}}

<body>
    <!-- header -->
    <header id="header">
        <div class="container">
            <div class="row">
                <div id="logo" class="col-md-3 col-sm-12 col-xs-12">
                    <h4>
                        <a href="{{ route('home') }}">
                            <img width="200px" src="{{ asset('frontend/img/home/logo.png') }}" alt="">
                        </a>
                        <nav><a id="pull" class="btn btn-danger" href="#">
                                <i class="fa fa-bars"></i>
                            </a></nav>
                    </h4>
                </div>
                <div id="search" class="col-md-5 col-sm-12 col-xs-12">
                    <form action="{{ route('shopping') }}" method="GET">
                        <input type="text" name="product_name" placeholder="Nhập tên sản phẩm">
                        <input type="submit" value="Tìm kiếm">
                    </form>
                </div>
                <div id="cart" class="col-md-1 col-sm-12 col-xs-12">
                    <a href="{{ route('order.show') }}">
                        <i class="fa fa-cart-plus" aria-hidden="true"> {{ count($orders) }}</i> &nbsp;
                    </a>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12" id="user">
                    @if (Auth::check())
                        <div class="dropdown">
                            <span id="user-name" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user-o text-light" aria-hidden="true"></i>
                                {{ Auth::user()->name }}

                            </span>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-file-text-o text-primary" aria-hidden="true"></i>
                                    &nbsp;
                                    Thông tin cá nhân
                                </a>
                                <div class="dropdown-divider"></div>
                                @if (Auth::user()->provider == '')
                                    <a class="dropdown-item" href="">
                                        <i class="fa fa-cogs text-danger" aria-hidden="true"></i>
                                        &nbsp;
                                        Đổi mật khẩu
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <img width="25px" src="{{ asset('frontend/img/home/icon-logout.jpg') }}" alt="">
                                    &nbsp; Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="login btn btn-primary">Đăng nhập</a>
                    @endif
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-sm bg-dark">
            <!-- Links -->
            <ul class="navbar-nav">
                @foreach ($categories as $cate)
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('search.category', $cate->slug) }}">{{ $cate->category_name }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </header>
    <!-- /header -->
    <!-- endheader -->

    <!-- main -->
    <section id="body">
        <div class="container-fluid">
            <div class="row">
                <!-- sidebar -->

                <!-- endsidebar -->
                <div id="main" class="col-md-12">
                    <div id="wrap-inner">
                        <div class="products" id="laptop">
                            @if (!count($products))
                                <p class="text-infor">Không có sản phẩm</p>
                            @endif
                            <div class="product-list row">
                                @foreach ($products as $product)
                                    <div class="product-item col-md-3 col-sm-6 col-xs-12">
                                        <a href=""><img src="{{ asset($product->image) }}" class="img-thumbnail"
                                                title="Xem chi tiết"></a>
                                        <br>
                                        {{ $product->product_name }}
                                        <br>
                                        <b>{{ number_format($product->price) }}</b> wei
                                        <br>
                                        {{ $product->retailer_name }}
                                        <br><br>
                                        <div>
                                            <button class="btn btn-cart" style="background: #ff6600; color:white"
                                                data-toggle="modal"
                                                data-target="#form-shopping-modal-{{ $product->product_id }}">
                                                Mua hàng
                                            </button>
                                            <div class="modal"
                                                id="form-shopping-modal-{{ $product->product_id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <div class="producut-infor">
                                                                <div class="image">
                                                                    <img width="120px"
                                                                        src="{{ asset($product->image) }}" alt="">
                                                                </div>
                                                                <p class="product-name">
                                                                    {{ $product->product_name }}</p>
                                                                <div class="price-product">
                                                                    <p>
                                                                        <span product-price="{{ $product->price }}"
                                                                            class="text-infor total_money">{{ number_format($product->price) }}
                                                                            wei
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <form action="{{ route('order') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ $product->product_id }}">
                                                                <input type="hidden" name="price"
                                                                    value="{{ $product->price }}">
                                                                <input type="hidden" name="retailer_address"
                                                                    value="{{ $product->retailer_address }}">
                                                                <div class="form-group">
                                                                    Chọn số lượng: <input min="0" type="number"
                                                                        max="{{ $product->quantity }}"
                                                                        name="quantity">
                                                                </div>
                                                                <button class="btn btn-add-cart">Thêm vào giỏ
                                                                    hàng</button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end main -->
            </div>
        </div>
        </div>
    </section>
    <!-- endmain -->

    <!-- footer -->
    <footer id="footer">
        <div id="footer-t">
            <div class="container">
                <div class="row">
                    <div id="logo-f" class="col-md-4 col-sm-12 col-xs-12 text-center">
                        <a href="#"><img width="300px" src="{{ asset('images/black_logo.png') }}"></a>
                    </div>
                    <div id="about" class="col-md-4 col-sm-12 col-xs-12">
                        <h3>About us</h3>
                        <p class="text-justify">Web bán hàng phục vụ cho mục đích từ thiện. Với phương châm cho đi yêu
                            thương là nhận lại hạnh phúc</p>
                    </div>
                    <div id="hotline" class="col-md-4 col-sm-12 col-xs-12">
                        <p><b>Tổng đài hỗ trợ</b> (Miễn phí gọi)</p>
                        <p>Gọi mua: <a href="tel:+1800.1068"><b>1800.1068</b></a> (7:30 - 22:00)</p>
                        <p>Kỹ thuật: <a href="tel:+1800.1763"><b>1800.1763</b></a> (7:30 - 22:00)</p>
                        <p>Khiếu nại: <a href="tel:+1800.1062"><b>1800.1062</b></a> (8:30 - 21:30)</p>
                        <p>Bảo hành: <a href="tel:+1800.1064"><b>1800.1064</b></a> (8:30 - 21:30)</p>
                    </div>
                </div>
            </div>

        </div>
    </footer>
    <!-- endfooter -->
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('retailer/js/shopping.js') }}"></script>
@if (Session::has('message'))
    <script>
        toastr.success(" {{ Session::get('message') }} ");
    </script>
@endif

</html>
