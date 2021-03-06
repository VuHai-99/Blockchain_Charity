@inject('NAV', 'App\Constants\Nav')

@php
$navs = [];
if (Auth::check()) {
    if (Auth::user()->role == 1) {
        if (Auth::user()->wallet_type == 0) {
            $navs = $NAV::NAV_ADMIN_HOST;
        } else {
            $navs = $NAV::NAV_ADMIN_HOST_WS;
        }
    } elseif (Auth::user()->role == 0) {
        if (Auth::user()->wallet_type == 0) {
            $navs = $NAV::NAV_ADMIN_DONATOR;
        } else {
            $navs = $NAV::NAV_ADMIN_DONATOR_WS;
        }
    }
} elseif (Auth::guard('authority')->check()) {
    $navs = $NAV::NAV_SUPPER_AUTHORITY;
} else {
    $navs = $NAV::NAV_HOME;
}
@endphp
<!-- header-start -->
<header>
    <div class="header-area">
        <div id="sticky-header" class="main-header-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-5 col-lg-5 menu-left">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/black_logo.png') }}" alt="">
                            </a>
                        </div>
                        <div class="search">
                            <form method="get" action="{{ route('campaign') }}">
                                <input type="text" name="key_word" id="" class="form-control"
                                    placeholder="Search campaign...">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 main-menu">
                        <nav>
                            @if (!Auth::guard('admin')->check() && !Auth::guard('authority')->check())
                                <ul id="navigation">
                                    @foreach ($navs as $nav)
                                        @php
                                            $url = $nav['url'] ? route($nav['url']) : '#';
                                        @endphp
                                        <li class="item">
                                            <a href="{{ $url }}"
                                                class="nav-link {{ $nav['url'] && Request::route()->getName() == $nav['url'] ? 'active' : '' }} ">
                                                {{ $nav['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif(Auth::guard('admin')->check())
                                <ul id="navigation">
                                    <li class="item">
                                        <a href="{{ route('admin.dashboard.index') }}"
                                            class="nav-link">Trang ch???</a>
                                    </li>
                                    <li class="item">
                                        <a href="{{ route('admin.host.list') }}" class="nav-link">Nh?? t??? thi???n</a>
                                    </li>
                                    <li class="item">
                                        <a href="{{ route('admin.campaign.list') }}" class="nav-link">D??? ??n</a>
                                    </li>
                                    <li class="item btn-group">
                                        <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">Y??u c???u</a>
                                        <ul class="dropdown-menu">
                                            <li class="item">
                                                <a href="{{ route('admin.open-campaign-request.list') }}"
                                                    class="nav-link">X??c nh???n d??? ??n</a>
                                            </li>
                                            <li class="item">
                                                <a href="{{ route('admin.validate-host-request.list') }}"
                                                    class="nav-link">X??c nh???n nh?? t??? thi???n</a>
                                            </li>
                                            
                                            <li class="item">
                                                <a href="{{ route('admin.create-donationActivity-request.list') }}"
                                                    class="nav-link">X??c nh???n ?????t t??? thi???n</a>
                                            </li>
                                            <li class="item">
                                                <a href="{{ route('admin.create-donationActivityCashout-request.list') }}"
                                                    class="nav-link">X??c nh???n s??? d???ng ti???n m???t trong ?????t t??? thi???n</a>
                                            </li>
                                            <li class="item">
                                                <a href="{{ route('admin.create-donationActivityOrder-request.list') }}"
                                                    class="nav-link">X??c nh???n mua h??ng trong ?????t t??? thi???n</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="item">
                                        <a href="{{ route('admin.logout') }}" class="nav-link">????ng xu???t</a>
                                    </li>
                                </ul>

                            @elseif(Auth::guard('authority')->check())
                                <ul id="navigation">
                                    <li class="item">
                                        <a href="{{ route('admin.dashboard.index') }}"
                                            class="nav-link">Trang ch???</a>
                                    </li>
                                    <li class="item btn-group">
                                        <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">Y??u c???u</a>
                                        <ul class="dropdown-menu">
                                            <li class="item">
                                                <a href="{{ route('authority.cashout_request.list') }}"
                                                    class="nav-link">X??c nh???n s??? d???ng ti???n m???t trong ?????t t??? thi???n</a>
                                            </li>
                                            <li class="item">
                                                <a href="{{ route('authority.order_request.list') }}"
                                                    class="nav-link">X??c nh???n mua h??ng trong ?????t t??? thi???n</a>
                                            </li>
                                            
                                        </ul>
                                    </li>
                                    <li class="item">
                                        <a href="{{ route('authority.logout') }}" class="nav-link">????ng xu???t</a>
                                    </li>
                                </ul>
                            
                            @endif
                        </nav>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="slider_area">
        <div class="single_slider  d-flex align-items-center slider_bg_1 overlay2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="slider_text ">
                            <span>Get Started Today.</span>
                            <h3> Help the children When They Need</h3>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-end -->
