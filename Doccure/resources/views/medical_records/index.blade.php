@extends('layouts.website')

@section('title', 'Medical Records')

@section('content')

<div class="container mt-5">
    <div class="row">
        @include('partials.sidebar') <!-- Include the sidebar -->

        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #15558D;">
                    <h4 style="color: white;">Medical Records for {{ $patient->user->name }}</h4>
                </div>
                <div class="card-body">
                    @if($medicalRecords->isEmpty())
                        <p>No medical records found.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Diagnosis</th>
                                    <th>Treatment</th>
                                    <th>Prescriptions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($medicalRecords as $record)
                                    <tr>
                                        <td>{{ $record->record_date }}</td>
                                        <td>{{ $record->diagnosis }}</td>
                                        <td>{{ $record->treatment }}</td>
                                        <td>{{ $record->prescriptions ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('medical_records.edit', $record->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('medical_records.destroy', $record->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <a href="{{ route('medical_records.create', $patient->id) }}" class="btn btn-success mt-3">Add Medical Record</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
