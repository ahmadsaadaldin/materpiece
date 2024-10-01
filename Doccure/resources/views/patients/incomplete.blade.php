@extends('layouts.website')

@section('title', 'Incomplete Patients')

@section('content')
<div class="container">
    <h1>Incomplete Patients</h1>

    @if($patients->isEmpty())
        <p>No patients with incomplete data found.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Insurance Number</th>
                    <th>Medical History</th>
                    <th>Date of Birth</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->user->name }}</td>
                        <td>{{ $patient->user->email }}</td>
                        <td>{{ $patient->user->phone }}</td>
                        <td>{{ $patient->insurance_number ?? 'Missing' }}</td>
                        <td>{{ $patient->medical_history ?? 'Missing' }}</td>
                        <td>{{ $patient->date_of_birth ?? 'Missing' }}</td>
                        <td>
                        <a href="{{ route('patients.complete.form', $patient->id) }}" class="btn btn-primary">Complete Data</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
