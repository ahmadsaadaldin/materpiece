@extends('layouts.app')

@section('title', 'View Secretary')

@section('content')
<div class="container">
    <h1>Secretary Details</h1>
    <a href="{{ route('secretaries.index') }}" class="btn btn-secondary mb-3">Back to List</a>

    <div class="card">
        <div class="card-header">
            Secretary Information
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $secretary->user->name }}</p>
            <p><strong>Email:</strong> {{ $secretary->user->email }}</p>
            <p><strong>Doctor:</strong> {{ $secretary->doctor->user->name }}</p>
            <p><strong>Phone Extension:</strong> {{ $secretary->phone_extension }}</p>
        </div>
    </div>
</div>
@endsection
