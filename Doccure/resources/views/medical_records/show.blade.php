@extends('layouts.website')

@section('title', 'Medical Record Details')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Medical Record Details</h2>
                </div>
                <div class="card-body">
                    <p><strong>Doctor:</strong> {{ $medicalRecord->doctor->user->name }}</p>
                    <p><strong>Patient:</strong> {{ $medicalRecord->patient->user->name }}</p>
                    <p><strong>Diagnosis:</strong> {{ $medicalRecord->diagnosis }}</p>
                    <p><strong>Treatment:</strong> {{ $medicalRecord->treatment }}</p>
                    <p><strong>Prescriptions:</strong> {{ $medicalRecord->prescriptions }}</p>
                    <p><strong>Date:</strong> {{ $medicalRecord->record_date }}</p>
                    <p><strong>Notes:</strong> {{ $medicalRecord->notes }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
