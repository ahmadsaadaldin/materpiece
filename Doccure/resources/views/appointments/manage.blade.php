@extends('layouts.website')

@section('title', 'Manage Appointment')

@section('content')
<div class="container mt-5">
    <h2>Manage Appointment for {{ $appointment->patient->user->name }}</h2>

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
@endsection
