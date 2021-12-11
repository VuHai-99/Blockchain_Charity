@inject('NAV', 'App\Constants\Nav')

@php
$navs = [];
if (Auth::guard('admin')->check()) {
    $navs = $NAV::NAV_SUPPER_ADMIN;
}

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
}

if (Auth::guard('authority')->check()) {
    $navs = $NAV::NAV_SUPPER_AUTHORITY;
}

if (!Auth::check() && !Auth::guard('admin')->check()) {
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
                            @if (!Auth::guard('admin')->check())
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
                                            class="nav-link">Dashboard</a>
                                    </li>
                                    <li class="item">
                                        <a href="{{ route('admin.host.list') }}" class="nav-link">List Host</a>
                                    </li>
                                    <li class="item">
                                        <a href="{{ route('admin.campaign.list') }}" class="nav-link">List
                                            Campaign</a>
                                    </li>
                                    <li class="item btn-group">
                                        <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">Request</a>
                                        <ul class="dropdown-menu">
                                            <li class="item">
                                                <a href="{{ route('admin.open-campaign-request.list') }}"
                                                    class="nav-link">Approve Campaign</a>
                                            </li>
                                            <li class="item">
                                                <a href="{{ route('admin.validate-host-request.list') }}"
                                                    class="nav-link">Approve Host</a>
                                            </li>
                                            <li class="item">
                                                <a href="{{ route('admin.withdraw-money-request.list') }}"
                                                    class="nav-link">Approve Withdrawal</a>
                                            </li>
                                            <li class="item">
                                                <a href="{{ route('admin.create-donationActivity-request.list') }}"
                                                    class="nav-link">Approve DonationActivity</a>
                                            </li>
                                            <li class="item">
                                                <a href="{{ route('admin.create-donationActivityCashout-request.list') }}"
                                                    class="nav-link">Approve DonationActivity Cashout</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="item">
                                        <a href="{{ route('admin.logout') }}" class="nav-link">Logout</a>
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
                            <p>With so much to consume and such little time, coming up <br> with relevant title ideas is
                                essential
                            </p>
                            <a href="#" class="boxed-btn3">Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-end -->
