<!DOCTYPE html>
<html>

<head>
    <title> @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    {{-- Style Css --}}
    @yield('Css')

</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            @yield('content')
        </div>
    </div>
</body>

{{-- ----- Script ------ --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src={{ asset('js/app.js') }}></script>
<script type="text/javascript" src="{{ asset('js/laroute.js') }}"></script>
@yield('scripts')

</html>
