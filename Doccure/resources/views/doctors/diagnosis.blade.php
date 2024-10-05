@extends('layouts.website')

@section('title', 'Diagnosis Assistant')

@section('content')
<div class="container mt-5">
    <h2>Diagnosis Assistant</h2>

    @if($errors->any()) <!-- Show validation errors -->
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctors.diagnosis') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="symptoms">Patient's Symptoms:</label>
            <textarea name="symptoms" class="form-control" rows="4">{{ old('symptoms') }}</textarea> <!-- Preserve old value -->
        </div>
        <div class="form-group">
            <label for="medical_history">Patient's Medical History:</label>
            <textarea name="medical_history" class="form-control" rows="4">{{ old('medical_history') }}</textarea> <!-- Preserve old value -->
        </div>
        <button type="submit" class="btn btn-primary">Get Diagnosis</button>
    </form>
</div>
@endsection
