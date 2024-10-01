@extends('layouts.app')

@section('title', 'Edit Secretary')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Secretary</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('secretaries.index') }}">Manage Secretaries</a></li>
        <li class="breadcrumb-item active">Edit Secretary</li>
    </ol>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Secretary Information
                </div>
                <div class="card-body">
                    <form action="{{ route('secretaries.update', $secretary->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $secretary->user_id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">Select Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="form-select" required>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ $doctor->id == $secretary->doctor_id ? 'selected' : '' }}>
                                        {{ $doctor->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="phone_extension" class="form-label">Phone Extension</label>
                            <input type="text" name="phone_extension" id="phone_extension" class="form-control" value="{{ $secretary->phone_extension }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Secretary</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
