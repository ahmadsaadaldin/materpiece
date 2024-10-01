@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
<div class="container">
    <h1>Edit Patient</h1>

    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="doctor_id" class="form-label">Select Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-select" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $doctor->id == $patient->doctor_id ? 'selected' : '' }}>
                        {{ $doctor->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Patient Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $patient->user->name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Patient Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $patient->user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Patient Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $patient->user->phone }}" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Patient Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $patient->user->address }}">
        </div>

        <div class="mb-3">
            <label for="insurance_number" class="form-label">Insurance Number</label>
            <input type="text" name="insurance_number" id="insurance_number" class="form-control" value="{{ $patient->insurance_number }}" required>
        </div>

        <div class="mb-3">
            <label for="medical_history" class="form-label">Medical History</label>
            <textarea name="medical_history" id="medical_history" class="form-control" required>{{ $patient->medical_history }}</textarea>
        </div>

        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $patient->date_of_birth }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Patient</button>
    </form>
</div>
@endsection
