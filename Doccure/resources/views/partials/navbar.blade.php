<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
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
                <!-- Other menu items -->
                <!-- Add conditional logic for displaying login/signup or logout -->
                @if(Auth::check())
                    <li>
                        <a href="{{ route('home') }}">home</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="login-link">
                        <a href="{{ route('login.show') }}">Login / Signup</a>
                    </li>
                @endif
            </ul>         
        </div>         
        <ul class="nav header-navbar-rht">
            <li class="nav-item contact-item">
            </li>
            @if(Auth::check())
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('login.show') }}">Login / Signup</a>
                </li>
            @endif
        </ul>
    </nav>
</header>
