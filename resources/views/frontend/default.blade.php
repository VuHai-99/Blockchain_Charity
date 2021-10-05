<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') </title>
    <link rel="stylesheet" href="{{ asset('theme/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    {{-- -------- Style -------- --}}
    @yield('css')

</head>

<body>
    <div class="container-fluid management">
        {{-- header --}}
        @include('frontend.header')
        {{-- end header --}}

        {{-- content --}}
        <div class="manage">
            @yield('content')
        </div>
        {{-- end content --}}

        <footer>
            @include('frontend.footer')
        </footer>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@yield('script')

</html>
