@extends('layouts.website')

@section('title', 'Add Medical Record')

@section('content')

<div class="container mt-5">
    <div class="row">
        @include('partials.sidebar') <!-- Include the sidebar -->

        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #15558D;">
                    <h4 style="color: white;">Add Medical Record for {{ $patient->user->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('medical_records.store', $patient->id) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="record_date">Date</label>
                            <input type="date" name="record_date" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="diagnosis">Diagnosis</label>
                            <input type="text" name="diagnosis" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="treatment">Treatment</label>
                            <input type="text" name="treatment" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="prescriptions">Prescriptions</label>
                            <input type="text" name="prescriptions" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="notes">Notes</label>
                            <textarea name="notes" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
