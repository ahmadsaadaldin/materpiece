@extends('layouts.website')

@section('title', 'Appointment Details')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card for Appointment Details -->
            <div class="card">
                <div class="card-header">
                    <h2>Appointment Details</h2>
                </div>
                <div class="card-body">
                    <!-- Doctor's Information -->
                    <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
                    
                    <!-- Patient's Information -->
                    <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
                    
                    <!-- Appointment Date and Time -->
                    <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
                    <p><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
                    
                    <!-- Appointment Status -->
                    <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                    
                    <!-- Additional Notes (if available) -->
                    <p><strong>Notes:</strong> {{ $appointment->notes ?? 'N/A' }}</p>
                </div>
                <div class="card-footer text-right">
                    <!-- Back to Patient Dashboard -->
                    <a href="{{ route('patients.patient-dashboard') }}" class="btn btn-sm btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-css')
<style>
    /* Ensure full height of the page */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    /* Flexbox layout to push footer to the bottom */
    body {
        display: flex;
        flex-direction: column;
    }

    .container {
        flex: 1;
    }

    footer {
        margin-top: auto;
        background-color: #004a7c; /* Adjust background color as needed */
        color: white;
        padding: 20px 0;
        text-align: center;
    }
</style>
@endsection
