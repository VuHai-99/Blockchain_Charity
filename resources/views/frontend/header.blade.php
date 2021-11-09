<!-- header-start -->
<header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="{{route('home')}}">
                                <img src="images/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="main-menu">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="{{ asset(route('home')) }}" class="nav-link {{strpos(\Request::route()->getName(), 'home') !== false ? 'active' : '' }}">home</a></li>
                                    <li><a href="#">About</a></li>
                                    <li>
                                        <a href="{{ asset(route('campaign')) }}" class="nav-link {{strpos(\Request::route()->getName(), 'event') !== false ? 'active' : '' }}">Campaign </i></a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link {{strpos(\Request::route()->getName(), 'help') !== false ? 'active' : '' }}">Help </i></a>
                                    </li>
                                    <li><a href="#" class="nav-link {{strpos(\Request::route()->getName(), 'contact') !== false ? 'active' : '' }}">Contact</a></li>
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-end -->

<!-- slider_area_start -->
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
<!-- slider_area_end !-->
