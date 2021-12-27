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
                        href="{{ route('host.shopping.cart.byCategory', [ $donationActivityAddress,$cate->slug]) }}">{{ $cate->category_name }}</a>
                </li>
            @endforeach
        </ul>
        <div id="search" class="col-md-5 col-sm-12 col-xs-12">
            <form action="{{ route('host.shopping.cart', $donationActivityAddress) }}" method="GET">
                <input type="text" name="product_name" placeholder="Nhập tên sản phẩm">
                <input type="submit" value="Tìm kiếm">
            </form>
        </div>
        <div id="cart" class="col-md-2 col-sm-4 col-xs-4">
            <a href="{{ route('host.shopping.order.show', $donationActivityAddress) }}">
                <i class="fa fa-cart-plus" aria-hidden="true"> {{ count($orders) }}</i> &nbsp;
            </a>
        </div>
    </nav>
    <section id="body">
        <div class="container-fluid">
            <div class="row">
                <!-- sidebar -->

                <!-- endsidebar -->
                <div id="main" class="col-md-12">
                    <div id="wrap-inner">
                    </div>
                </div>
                <!-- end main -->
            </div>
        </div>
        </div>
    </section>
    <div id="show-cart">
        <a href="{{ route('host.shopping.cart', $donationActivityAddress) }}">
            << Quay lại trang mua hàng </a>
                @if (count($orders))
                    <div id="list-cart">
                        <h3>Giỏ hàng</h3>
                        <table class="table table-bordered .table-responsive text-center">
                            <thead class="active">
                                <th width="11.111%">Ảnh mô tả</th>
                                <th width="22.222%">Tên sản phẩm</th>
                                <th width="11.111%">Số lượng</th>
                                <th width="16.6665%">Đơn giá</th>
                                <th width="16.6665%">Thành tiền</th>
                                <th width="11.112%">Xóa sản phẩm</th>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($orders as $item)
                                    <tr>
                                        <td><img class="img-responsive" src="{{ asset($item->image) }}"></td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" min="1" max="{{ $item->quantity_remain }}"
                                                    type="number" name="qty" value="{{ $item->quantity }}"
                                                    order-id="{{ $item->order_id }}"
                                                    product-price="{{ $item->price }}">
                                            </div>
                                        </td>
                                        <td>
                                            <b>
                                                @if ($item->price > pow(10, 17))
                                                    {{ number_format($item->price / pow(10, 17)) }}
                                                    (Ether)
                                                @elseif($item->price > pow(10,8))
                                                    {{ number_format($item->price / pow(10, 8)) }}
                                                    (Gwei)
                                                @else
                                                    {{ number_format($item->price) }} (wei)
                                                @endif
                                            </b>
                                        </td>
                                        <td>
                                            <b>
                                                @if ($item->total_receipt > pow(10, 17))
                                                    {{ number_format($item->total_receipt / pow(10, 17)) }}
                                                    (Ether)
                                                @elseif($item->total_receipt > pow(10,8))
                                                    {{ number_format($item->total_receipt / pow(10, 8)) }}
                                                    (Gwei)
                                                @else
                                                    {{ number_format($item->total_receipt) }} (wei)
                                                @endif
                                            </b>
                                        </td>
                                        <td><a href="{{ route('host.shopping.order.delete', $item->order_id) }}"
                                                class="btn btn-danger link-delete-cart"
                                                order-id="{{ $item->order_id }}">Xóa</a></td>
                                    </tr>
                                    @php
                                        $total += $item->quantity * $item->price;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row" id="total-price">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <h4>Tổng thanh toán: 
                                    <span class="price">
                                        @if ($total > pow(10, 17))
                                            {{ number_format($total / pow(10, 17)) }}
                                            (Ether)
                                        @elseif($total > pow(10,8))
                                            {{ number_format($total / pow(10, 8)) }}
                                            (Gwei)
                                        @else
                                            {{ number_format($total) }} (wei)
                                        @endif
                                    </span>
                                </h4>

                            </div>
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <a href="{{ route('host.shopping.cart', $donationActivityAddress) }}" class="btn btn-primary">Mua
                                    tiếp</a>
                                <a href="{{ route('host.shopping.order.delete.cart', $donationActivityAddress) }}"
                                    class="btn btn-danger">Xóa giả
                                    hàng</a>
                                    <a class="btn btn-confirm"
                                    href="{{ route('host.shopping.order.confirm', $donationActivityAddress) }}">Xác nhận mua hàng</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <br>
                @else
                    <h3 class="text-center">
                        Giỏ hàng chưa có sản phẩm
                    </h3>
                @endif
    </div>

@endsection

