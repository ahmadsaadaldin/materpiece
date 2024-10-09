<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand logo">
                <img src="{{ asset('main/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
            </a>
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="{{ route('home') }}" class="menu-logo">
                    <img src="{{ asset('main/assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <ul class="main-nav">
                <li class="active">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('doctors.publicList') }}">Doctors</a>
                </li>

                <!-- Check for authenticated users -->
                @if(Auth::check())
                    <!-- Doctor Menu -->
                    @if(Auth::user()->role_id == 2)
                        <li>
                            <a href="{{ route('doctor.dashboard') }}">Doctor Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('doctorappointments') }}">My Appointments</a>
                        </li>
                        <li>
                            <a href="{{ route('doctor.reviews') }}">Reviews</a>
                        </li>

                    <!-- Patient Menu -->
                    @elseif(Auth::user()->role_id == 4)
                        <li>
                            <a href="{{ route('patients.patient-dashboard') }}">Patient Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('patients.profile') }}">Patient Profile</a>
                        </li>

                    <!-- Admin Menu -->
                    @elseif(Auth::user()->role_id == 1)
                        <li>
                            <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}">User Management</a>
                        </li>

                    <!-- Secretary Menu (role_id == 3) -->
                    @elseif(Auth::user()->role_id == 3)
                        <li>
                            <a href="{{ route('secretary.dashboard') }}">Secretary Dashboard</a>
                        </li>
                    @endif

                <!-- Guest Menu (Not Logged In) -->
                @else
                    <li class="login-link">
                        <a href="{{ route('login.show') }}">Login / Signup</a>
                    </li>
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
