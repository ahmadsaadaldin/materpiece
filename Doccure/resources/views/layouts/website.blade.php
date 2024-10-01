<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>@yield('title', 'Welcome to My Website')</title>
    
    <!-- Favicons -->
    <link type="image/x-icon" href="{{ asset('main/assets/img/favicon.png') }}" rel="icon">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('main/assets/css/bootstrap.min.css') }}">
    
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('main/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/assets/plugins/fontawesome/css/all.min.css') }}">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('main/assets/css/style.css') }}">
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="{{ asset('main/assets/js/html5shiv.min.js') }}"></script>
        <script src="{{ asset('main/assets/js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>

    <!-- Navbar or Header -->
    @include('partials.navbar') <!-- You can create a separate navbar blade file and include it here -->
    
    <!-- Main Content -->
    <div class="container-fluid">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('partials.footer') <!-- You can create a separate footer blade file and include it here -->
    
    <!-- jQuery -->
    <script src="{{ asset('main/assets/js/jquery.min.js') }}"></script>
    
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('main/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('main/assets/js/bootstrap.min.js') }}"></script>
    
    <!-- Slick JS -->
    <script src="{{ asset('main/assets/js/slick.js') }}"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('main/assets/js/script.js') }}"></script>
    
</body>
</html>
