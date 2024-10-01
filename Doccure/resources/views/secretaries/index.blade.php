@extends('layouts.app')

@section('title', 'Manage Secretaries')

@section('content')
<div class="container">
    <h1>Manage Secretaries</h1>
    <a href="{{ route('secretaries.create') }}" class="btn btn-primary mb-3">Create New Secretary</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Secretary Name</th>
                <th>Email</th>
                <th>Doctor</th>
                <th>Phone Extension</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($secretaries as $secretary)
                <tr>
                    <td>{{ $secretary->id }}</td>
                    <td>{{ $secretary->user->name }}</td>
                    <td>{{ $secretary->user->email }}</td>
                    <td>{{ $secretary->doctor->user->name }}</td>
                    <td>{{ $secretary->phone_extension }}</td>
                    <td>
                        <a href="{{ route('secretaries.show', $secretary->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('secretaries.edit', $secretary->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('secretaries.destroy', $secretary->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this secretary?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
