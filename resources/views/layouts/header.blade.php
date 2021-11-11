@inject('NAV', 'App\Constants\Nav')

@php
$navs = [];
if (Auth::guard('admin')->check()) {
    $navs = $NAV::NAV_SUPPER_ADMIN;
}
if (Auth::check()) {
    if (Auth::user()->role == 1) {
        $navs = $NAV::NAV_ADMIN_HOST;
    } elseif (Auth::user()->role == 0) {
        $navs = $NAV::NAV_ADMIN_DONATOR;
    }
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
                            <input type="text" name="search" id="" class="form-control"
                                placeholder="Search campaign...">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 main-menu">
                        <nav>
                            <ul id="navigation">
                                @foreach ($navs as $nav)
                                    @php
                                        $url = $nav['url'] ? route($nav['url']) : '#';
                                    @endphp
                                    <li class="item">
                                        <a href="{{ $url }}"
                                            class="nav-link {{ $nav['url'] && strpos(\Request::route()->getName(), $nav['url']) !== false ? 'active' : '' }}  ">
                                            @if (isset($nav['icon']))
                                                <span class="icon-menu"><img
                                                        src="{{ asset($nav['icon']) }}"></span>
                                            @endif
                                            {{ $nav['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
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
