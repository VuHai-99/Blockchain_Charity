<div class="row header">
    <div class="col col-md-6 col-lg-6">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-header.png') }}" alt=""> Chia sẻ để yêu thương
            </a>
        </div>
    </div>
    <div class="col col-md-6 col-lg-6">
        <div class="menu">
            <ul class="nav nav-tabs">
                <li class="nav-item @if (Request::route()->getName() == 'home') active @endif"><a href="{{ route('home') }}">Home</a></li>
                <li class="nav-item @if (Request::route()->getName() == 'event') active @endif"><a href="#">Events</a></li>
                <li class="nav-item @if (Request::route()->getName() == 'login.towfactor') active @endif"><a href="{{ route('login') }}">Login</a></li>
                <li class="nav-item @if (Request::route()->getName() == 'register') active @endif"><a href="{{ route('register') }}">Register</a>
                </li>
            </ul>
        </div>
    </div>
</div>
