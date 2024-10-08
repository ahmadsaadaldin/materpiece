@extends('layouts.website')

@section('title', 'Login')

@section('content')
    <body class="account-page">
        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <!-- Page Content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <!-- Login Tab Content -->
                            <div class="account-content">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-md-7 col-lg-6 login-left">
                                        <img src="main/assets/img/login-banner.png" class="img-fluid" alt="Doccure Login">	
                                    </div>
                                    <div class="col-md-12 col-lg-6 login-right">
                                        <div class="login-header">
                                            <h3>Login <span>Doccure</span></h3>
                                        </div>

                                        <!-- Display Validation Errors -->
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <!-- Display Incorrect Email/Password Error -->
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <form action="{{ route('login') }}" method="POST">
                                            @csrf
                                            <div class="form-group form-focus">
                                                <input type="email" name="email" class="form-control floating" required>
                                                <label class="focus-label">Email</label>
                                            </div>
                                            <div class="form-group form-focus">
                                                <!-- Added minlength="8" for frontend validation -->
                                                <input type="password" name="password" class="form-control floating" minlength="8" required>
                                                <label class="focus-label">Password</label>
                                            </div>
                                            
                                            <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>
                                            <div class="login-or">
                                                <span class="or-line"></span>
                                                <span class="span-or">or</span>
                                            </div>

                                            <div class="text-center dont-have">Don’t have an account? <a href="{{ route('register.show') }}">Register</a></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /Login Tab Content -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
@endsection
