@extends('layouts.website')

@section('title', 'Register')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <!-- Register Content -->
                    <div class="account-content">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-7 col-lg-6 login-left">
                                <img src="main/assets/img/login-banner.png" class="img-fluid" alt="Doccure Register">    
                            </div>
                            <div class="col-md-12 col-lg-6 login-right">
                                <div class="login-header">
                                    <h3>Patient Register <a href="#">Are you a Doctor?</a></h3>
                                </div>

                                <!-- Display Validation Errors -->
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <!-- Register Form -->
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="form-group form-focus">
                                        <input type="text" name="name" class="form-control floating" value="{{ old('name') }}" required>
                                        <label class="focus-label">Name</label>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="email" name="email" class="form-control floating" value="{{ old('email') }}" required>
                                        <label class="focus-label">Email</label>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="text" name="phone" class="form-control floating" value="{{ old('phone') }}" required>
                                        <label class="focus-label">Phone Number</label>
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="password" name="password" class="form-control floating" required>
                                        <label class="focus-label">Create Password</label>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="password" name="password_confirmation" class="form-control floating" required>
                                        <label class="focus-label">Confirm Password</label>
                                    </div>
                                    <div class="text-right">
                                        <a class="forgot-link" href="{{ route('login.show') }}">Already have an account?</a>
                                    </div>
                                    <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
                                    <div class="login-or">
                                        <span class="or-line"></span>
                                        <span class="span-or">or</span>
                                    </div>
                                    <div class="row form-row social-login">
                                        <div class="col-6">
                                            <a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
                                        </div>
                                    </div>
                                </form>
                                <!-- /Register Form -->
                            </div>
                        </div>
                    </div>
                    <!-- /Register Content -->
                </div>
            </div>
        </div>
    </div>        
    <!-- /Page Content -->
@endsection
