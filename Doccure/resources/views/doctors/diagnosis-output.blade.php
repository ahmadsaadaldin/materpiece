@extends('layouts.website')

@section('title', 'Diagnosis Result')

@section('content')
<div class="container mt-5">
    <h2>Diagnosis Result</h2>
    
    @if($suggestions)
        <p>{{ $suggestions }}</p> <!-- Displaying the diagnosis output -->
    @else
        <p>No diagnosis suggestions available.</p>
    @endif

    <a href="{{ route('doctors.diagnosis') }}" class="btn btn-primary mt-4">Back to Diagnosis Form</a>
</div>
@endsection
