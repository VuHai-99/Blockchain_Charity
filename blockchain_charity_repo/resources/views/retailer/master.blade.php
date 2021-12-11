<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/datepicker3.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @yield('css')
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header row">
                <div class="logo col-md-6 col-sm-12 col-xs-12">
                    <a href="#"><img width="150px" src="{{ asset('frontend/img/home/logo.png') }}" alt=""></a>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12" id="user">
                    @if (Auth::guard('retailer')->check())
                        <div class="dropdown">
                            <span id="user-name" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user-o text-light" aria-hidden="true"></i>
                                {{ Auth::guard('retailer')->user()->name }}
                            </span>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-file-text-o text-primary" aria-hidden="true"></i>
                                    &nbsp;
                                    Thông tin cá nhân
                                </a>
                                <hr>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('password.confirm') }}">
                                    <i class="fa fa-cogs text-danger" aria-hidden="true"></i>
                                    &nbsp;
                                    Đổi mật khẩu
                                </a>
                                <hr>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('retailer.logout') }}">
                                    <i class="fa fa-sign-out text-danger" aria-hidden="true"></i> &nbsp; Đăng xuất
                                </a>

                            </div>
                        </div>
                    @else
                        <a href="{{ route('retailer.login') }}" class="login btn btn-primary">Đăng nhập</a>
                    @endif
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </nav>

    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <ul class="nav menu">
            <li role="presentation" class="divider"></li>
            <li class="{{ Request::route()->getName() == 'retailer.dashboard' ? 'active' : '' }}"><a
                    href="{{ route('retailer.dashboard') }}"><svg class="glyph stroked dashboard-dial">
                        <use xlink:href="#stroked-dashboard-dial"></use>
                    </svg> Trang chủ</a></li>
            <li class="{{ strpos(Request::route()->getName(), 'retailer.product') !== false ? 'active' : '' }}"><a
                    href="{{ route('retailer.product.list') }}"><svg class="glyph stroked calendar">
                        <use xlink:href="#stroked-calendar"></use>
                    </svg> Sản phẩm </a></li>
            <li><a href=""><svg class="glyph stroked line-graph">
                        <use xlink:href="#stroked-line-graph"></use>
                    </svg> Danh mục</a></li>
            <li><a href=""><i class="fa fa-list-alt" aria-hidden="true">
                        <use xlink:href="#stroked-line-graph"></use>
                    </i> &emsp;Đơn hàng </a></li>
            <li role="presentation" class="divider"></li>
        </ul>

    </div>
    <!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        @yield('main')
    </div>
    <!--/.main-->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/chart.min.js') }}"></script>
    <script src="{{ asset('backend/js/chart-data.js') }}"></script>
    <script src="{{ asset('backend/js/easypiechart.js') }}"></script>
    <script src="{{ asset('backend/js/easypiechart-data.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('backend/js/ajax.js') }}"></script>
    <script src="{{ asset('backend/js/myscript.js') }}"></script>
    <script src="{{ asset('backend/js/lumino.glyphs.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $('#calendar').datepicker({});

        ! function($) {
            $(document).on("click", "ul.nav li.parent > a > span.icon", function() {
                $(this).find('em:first').toggleClass("glyphicon-minus");
            });
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
        }(window.jQuery);

        $(window).on('resize', function() {
            if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function() {
            if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
        })
    </script>
    @yield('scripts')
</body>

</html>
