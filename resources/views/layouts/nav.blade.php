@inject('NAV', 'App\Constants\Nav')

@php
$nav = [];
@endphp

@if (Auth::user()->role == 1 ? ($navs = $NAV::NAV_ADMIN_HOST) : ($navs = $NAV::NAV_ADMIN_DONATOR))
    <nav class="sidenav navbar navbar-vertical  fixed-left navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <div class="sidenav-header  align-items-center">
                <a class="navbar-link" href="#">
                    <img class="header-logo" src="{{ asset('images/footer_logo.png') }}">
                </a>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        @foreach ($navs as $index => $nav)
                            @php
                                $url = $nav['url'] ? route($nav['url']) : '#';
                                $parentName = explode('.', $nav['url']);
                                $parentName = join('.', array_splice($parentName, 0, count($parentName) - 1));
                                $parentName = $parentName ? $parentName . '.' : $parentName;
                            @endphp
                            <li class="nav-item">
                                <a a="{{ $parentName }}"
                                    class="nav-link {{ $parentName && strpos(\Request::route()->getName(), $parentName) !== false ? 'active' : '' }}"
                                    href="{{ $url }}">
                                    <img src="{{ asset('images/icons/' . $nav['icon']) }}" alt="" width="20px">
                                    <span class="nav-link-text">{{ $nav['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </nav>
@endif
