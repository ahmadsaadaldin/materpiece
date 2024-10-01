@extends('layouts.website')

@section('title', 'Complete Patient Information')

@section('content')

<div class="container mt-5">
    <div class="card shadow-sm">
        <div style="background-color:#15558D;" class="card-header">
            <h4 style="color:white">Complete Patient Information for {{ $patient->user->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('patients.complete.save', $patient->id) }}" method="POST">
                @csrf
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="insurance_number" class="form-label">Insurance Number</label>
                        <input type="text" name="insurance_number" class="form-control" placeholder="Enter insurance number" value="{{ old('insurance_number') }}" >
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="medical_history" class="form-label">Medical History</label>
                        <textarea name="medical_history" class="form-control" rows="4" placeholder="Enter medical history" required>{{ old('medical_history') }}</textarea>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success btn-lg">Save Information</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
