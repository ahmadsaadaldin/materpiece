@extends('layouts.website')

@section('title', 'Patient Profile')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Update Profile</h2>
                </div>
                <div class="card-body">
                    <!-- Display success message -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Profile Form -->
                    <form action="{{ route('patients.updateProfile') }}" method="POST">
                        @csrf

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password (Optional) -->
                        <div class="form-group">
                            <label for="password">Password (Leave blank to keep current password)</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <!-- Insurance Number -->
                        <div class="form-group">
                            <label for="insurance_number">Insurance Number</label>
                            <input type="text" name="insurance_number" class="form-control" value="{{ old('insurance_number', $patient->insurance_number) }}" required>
                            @error('insurance_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Footer -->
<style>
    /* Make sure the footer sticks to the bottom */
    html, body {
        height: 100%;
    }
    
    body {
        display: flex;
        flex-direction: column;
    }
    
    .container {
        flex: 1;
    }
    
    footer {
        margin-top: auto;
    }
</style>
@endsection
