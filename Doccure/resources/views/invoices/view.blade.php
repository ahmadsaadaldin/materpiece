@extends('layouts.website')

@section('title', 'Invoice Details')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card for Invoice Details -->
            <div class="card">
                <div class="card-header">
                    <h2>Invoice #{{ $invoice->id }}</h2>
                </div>
                <div class="card-body">
                    <!-- Appointment Information -->
                    <p><strong>Appointment Date:</strong> {{ $invoice->appointment->appointment_date }}</p>
                    <p><strong>Appointment Time:</strong> {{ $invoice->appointment->appointment_time }}</p>
                    
                    <!-- Doctor's Information -->
                    <p><strong>Doctor:</strong> {{ $invoice->appointment->doctor->user->name }}</p>
                    
                    <!-- Patient's Information -->
                    <p><strong>Patient:</strong> {{ $invoice->appointment->patient->user->name }}</p>
                    
                    <!-- Invoice Amount and Date -->
                    <p><strong>Invoice Date:</strong> {{ $invoice->created_at }}</p>
                    <p><strong>Amount:</strong> ${{ $invoice->amount }}</p>
                    
                    <!-- Notes (if available) -->
                    <p><strong>Notes:</strong> {{ $invoice->notes ?? 'N/A' }}</p>
                </div>
                <div class="card-footer text-right">
                    <!-- Back to Dashboard Button -->
                    <a href="{{ route('patients.patient-dashboard') }}" class="btn btn-sm btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
