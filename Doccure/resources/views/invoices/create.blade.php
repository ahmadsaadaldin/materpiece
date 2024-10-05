@extends('layouts.website')

@section('title', 'Create Invoice')

@section('content')

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Invoice</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Create Invoice</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6"> <!-- Reduced width of the form -->
                    <div class="card shadow mt-5">
                        <div class="card-header text-center bg-primary text-white">
                            <h4>Create Invoice for {{ $appointment->patient->user->name }}</h4>
                        </div>

                        <div class="card-body">
                            <!-- Display success or error messages -->
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Appointment Details -->
                            <div class="mb-4">
                                <h5>Appointment Details</h5>
                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</p>
                                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                            </div>

                            <!-- Invoice Creation Form -->
                            <form action="{{ route('invoices.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">
                                <input type="hidden" name="doctor_id" value="{{ $appointment->doctor->id }}">

                                <div class="form-group">
                                    <label for="amount">Invoice Amount</label>
                                    <input type="number" name="amount" class="form-control" step="0.01" placeholder="Enter amount in USD" required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block mt-3">Create Invoice</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Main Wrapper -->

@endsection
