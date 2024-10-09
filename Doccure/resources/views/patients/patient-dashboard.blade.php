@extends('layouts.website')

@section('title', 'Patient Dashboard')

@section('content')
<!-- Main Wrapper -->

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Patient Dashboard</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Patient Dashboard</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container">

        <!-- Appointments Section -->
        <div class="card">
            <div class="card-body">
                <h4 class="widget-title">My Appointments</h4>

                @if($appointments->isEmpty())
                    <p>No appointments yet.</p>
                @else
                    <div class="scrollable-section">
                        <ul class="list-group">
                            @foreach($appointments as $appointment)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>{{ $appointment->doctor->user->name }}</strong> - {{ $appointment->appointment_date }} 
                                            <br> Time: {{ $appointment->appointment_time }}
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <a href="{{ route('appointment.details', $appointment->id) }}" class="btn btn-sm btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <!-- /Appointments Section -->

        <!-- Invoices Section -->
        <div class="card">
            <div class="card-body">
                <h4 class="widget-title">My Invoices</h4>

                @if($invoices->isEmpty())
                    <p>No invoices yet.</p>
                @else
                    <div class="scrollable-section">
                        <ul class="list-group">
                            @foreach($invoices as $invoice)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>Invoice #{{ $invoice->id }}</strong> - {{ $invoice->created_at }}
                                            <br> Amount: ${{ $invoice->amount }}
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <a href="{{ route('invoices.details', $invoice->id) }}" class="btn btn-sm btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <!-- /Invoices Section -->

        <!-- Medical History Section -->
        <div class="card">
            <div class="card-body">
                <h4 class="widget-title">My Medical Records</h4>

                @if($medicalRecords->isEmpty())
                    <p>No medical records available.</p>
                @else
                    <div class="scrollable-section">
                        <ul class="list-group">
                            @foreach($medicalRecords as $record)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>Doctor: </strong>{{ $record->doctor->user->name }}<br>
                                            <strong>Diagnosis: </strong>{{ $record->diagnosis }}<br>
                                            <strong>Treatment: </strong>{{ $record->treatment }}<br>
                                            <strong>Prescriptions: </strong>{{ $record->prescriptions }}<br>
                                            <strong>Date: </strong>{{ $record->record_date }}<br>
                                            <strong>Notes: </strong>{{ $record->notes }}
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <a href="{{ route('medical.history.details', $record->id) }}" class="btn btn-sm btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <!-- /Medical History Section -->

    </div>
</div>
<!-- /Page Content -->

<!-- Add custom styles for scrolling -->
<style>
    .widget-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .list-group-item {
        border: 1px solid #ddd;
        margin-bottom: 10px;
        border-radius: 4px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    /* Scrollable section styles */
    .scrollable-section {
        max-height: 180px; /* Adjust to fit two items at a time */
        overflow-y: auto;
    }
</style>

@endsection
