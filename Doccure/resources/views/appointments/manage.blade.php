@extends('layouts.website')

@section('title', 'Manage Appointment')

@section('content')
<div class="main-wrapper">

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Appointment</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Manage Appointment</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                </div>

                <!-- Main Content -->
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card mb-4">
                        <div class="card-header">Appointment Details</div>
                        <div class="card-body">
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</p>
                            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>

                            <!-- Update Appointment Status -->
                            <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                @csrf
                                @method('PUT')
                                
                                @if($appointment->status === 'scheduled')
                                    <input type="hidden" name="status" value="in progress">
                                    <button type="submit" class="btn btn-success">Start Appointment</button>
                                @elseif($appointment->status === 'in progress')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-success">Complete Appointment</button>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">Medical History</div>
                        <div class="card-body">
                            @if($medicalRecords->isEmpty())
                                <p>No medical records found.</p>
                            @else
                                <ul>
                                    @foreach($medicalRecords as $record)
                                        <li><strong>{{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}</strong>: {{ $record->diagnosis }} ({{ $record->treatment }})</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('medical_records.create', $appointment->patient_id) }}" class="btn btn-primary">Add Medical Record</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
@endsection
