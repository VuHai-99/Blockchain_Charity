<!DOCTYPE html>
<html>

<head>
    <title> @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
        integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

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

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
@yield('Script')

</html>
