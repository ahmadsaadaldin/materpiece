@extends('layouts.website')

@section('title', 'Edit Medical Record')

@section('content')

<div class="container mt-5">
    <div class="row">
        @include('partials.sidebar') <!-- Include the sidebar -->

        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #15558D;">
                    <h4 style="color: white;">Edit Medical Record for {{ $patient->user->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('medical_records.update', $medicalRecord->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="record_date">Date</label>
                            <input type="date" name="record_date" class="form-control" value="{{ $medicalRecord->record_date }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="diagnosis">Diagnosis</label>
                            <input type="text" name="diagnosis" class="form-control" value="{{ $medicalRecord->diagnosis }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="treatment">Treatment</label>
                            <input type="text" name="treatment" class="form-control" value="{{ $medicalRecord->treatment }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="prescriptions">Prescriptions</label>
                            <input type="text" name="prescriptions" class="form-control" value="{{ $medicalRecord->prescriptions }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="notes">Notes</label>
                            <textarea name="notes" class="form-control">{{ $medicalRecord->notes }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
