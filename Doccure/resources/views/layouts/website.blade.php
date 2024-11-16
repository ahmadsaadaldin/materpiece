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
    
    <!-- Sticky Footer Styling -->
    <style>
        /* Ensure full height and flex layout */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container-fluid {
            flex: 1;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>
<body>

<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand logo">
                <img src="{{ asset('main/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
            </a>
            <!-- Burger Menu Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
            </button>
        </div>
        <!-- Collapsible Menu -->
        <div class="collapse navbar-collapse main-menu-wrapper" id="navbarNav">
            <div class="menu-header">
                <a href="{{ route('home') }}" class="menu-logo">
                    <img src="{{ asset('main/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <ul class="navbar-nav main-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doctors.publicList') }}">Doctors</a>
                </li>

                <!-- Check for authenticated users -->
                @if(Auth::check())
                    <!-- Doctor Menu -->
                    @if(Auth::user()->role_id == 2)
                        <li class="nav-item"><a class="nav-link" href="{{ route('doctor.dashboard') }}">Doctor Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('doctorappointments') }}">My Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('doctor.reviews') }}">Reviews</a></li>

                    <!-- Patient Menu -->
                    @elseif(Auth::user()->role_id == 4)
                        <li class="nav-item"><a class="nav-link" href="{{ route('patients.patient-dashboard') }}">Patient Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('patients.profile') }}">Patient Profile</a></li>

                    <!-- Admin Menu -->
                    @elseif(Auth::user()->role_id == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">User Management</a></li>

                    <!-- Secretary Menu -->
                    @elseif(Auth::user()->role_id == 3)
                        <li class="nav-item"><a class="nav-link" href="{{ route('secretary.dashboard') }}">Secretary Dashboard</a></li>
                    @endif
                @else
                @endif
            </ul>
        </div>

        <!-- Right Header Menu -->
        <ul class="nav header-navbar-rht">
            @if(Auth::check())
                <!-- Display logged-in user's name -->
                <li class="nav-item">
                    <span class="nav-link">Hello, {{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('login.show') }}">Login / Signup</a>
                </li>
            @endif
        </ul>
    </nav>
</header>

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
    
    <!-- Theia Sticky Sidebar Plugin -->
    <script src="{{ asset('main/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('main/assets/js/script.js') }}"></script>

    <!-- ChartJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Inline script to initi<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function () {
            // Theia Sticky Sidebar initialization (only if element is found)
            if ($('.theiaStickySidebar').length > 0) {
                $('.theiaStickySidebar').theiaStickySidebar({
                    additionalMarginTop: 30
                });
            }

            // Chart.js Initialization (check if the canvas exists)
            var ctx = document.getElementById('revenueChart');
            if (ctx) {
                var revenueData = {!! isset($dailyRevenue) && count($dailyRevenue) > 0 ? json_encode($dailyRevenue->pluck('total')->toArray()) : '[]' !!};
                var labelsData = {!! isset($dailyRevenue) && count($dailyRevenue) > 0 ? json_encode($dailyRevenue->pluck('date')->map(function ($date) { return \Carbon\Carbon::parse($date)->format('d M Y'); })->toArray()) : '[]' !!};

                var revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labelsData.length > 0 ? labelsData : ['No Data'],
                        datasets: [{
                            label: 'Daily Revenue',
                            data: revenueData.length > 0 ? revenueData : [0], // If no data, provide a dummy value
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'category',
                                beginAtZero: true,
                                ticks: {
                                    autoSkip: false
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
    
</body>
</html>
