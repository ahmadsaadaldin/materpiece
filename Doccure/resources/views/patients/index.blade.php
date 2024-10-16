@extends('layouts.app')

@section('title', 'Manage Patients')

@section('content')
<div class="container">
    <h1>Manage Patients</h1>
    <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Create New Patient</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->user->name }}</td>
                    <td>{{ $patient->user->email }}</td>
                    <td>{{ $patient->user->phone ?? 'No Phone Provided' }}</td> <!-- Display phone number -->
                    <td>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?')">Delete</button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
