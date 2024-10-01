@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
<div class="container">
    <h1>Patient Details</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user me-1"></i>
            Patient Information
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name:</strong> {{ $patient->user->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $patient->user->email }}</li>
                <li class="list-group-item"><strong>Phone:</strong> {{ $patient->user->phone }}</li>
                <li class="list-group-item"><strong>Address:</strong> {{ $patient->user->address }}</li>
                <li class="list-group-item"><strong>Insurance Number:</strong> {{ $patient->insurance_number }}</li>
                <li class="list-group-item"><strong>Medical History:</strong> {{ $patient->medical_history }}</li>
                <li class="list-group-item"><strong>Date of Birth:</strong> {{ $patient->date_of_birth }}</li>
                <li class="list-group-item"><strong>Assigned Doctor:</strong> {{ $patient->doctor->user->name }}</li>
            </ul>
        </div>
    </div>

    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
