@extends('layouts.default')

@section('css')
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
@endsection

@section('content')
    <nav class="row navbar menu-category">
        <ul class="navbar-nav col-md-5 col-sm-12 col-xs-12">
            @foreach ($categories as $cate)
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('search.category', [$cate->slug, $donationActivityAddress]) }}">{{ $cate->category_name }}</a>
                </li>
            @endforeach
        </ul>
        <div id="search" class="col-md-5 col-sm-12 col-xs-12">
            <form action="{{ route('shopping', $donationActivityAddress) }}" method="GET">
                <input type="text" name="product_name" placeholder="Nhập tên sản phẩm">
                <input type="submit" value="Tìm kiếm">
            </form>
        </div>
        <div id="cart" class="col-md-2 col-sm-4 col-xs-4">
            <a href="{{ route('order.show', $donationActivityAddress) }}">
                <i class="fa fa-cart-plus" aria-hidden="true"> {{ count($orders) }}</i> &nbsp;
            </a>
        </div>
    </nav>
    <section id="body">
        <div class="container-fluid">
            <div class="row">
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
                                                                    <img width="120px" src="{{ asset($product->image) }}"
                                                                        alt="">
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
                                                                <input type="hidden" name="donation_activity_address"
                                                                    value="{{ $donationActivityAddress }}">
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ $product->product_id }}">
                                                                <input type="hidden" name="price"
                                                                    value="{{ $product->price }}">
                                                                <input type="hidden" name="retailer_address"
                                                                    value="{{ $product->retailer_address }}">
                                                                <div class="form-group">
                                                                    Chọn số lượng: <input min="0" type="number"
                                                                        max="{{ $product->quantity }}" name="quantity">
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

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('retailer/js/shopping.js') }}"></script>
    @if (Session::has('messages'))
        <script>
            toastr.success(" {{ Session::get('messages') }} ");
        </script>
    @endif
@endsection
