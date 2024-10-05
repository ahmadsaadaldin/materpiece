@extends('layouts.website')

@section('title', 'Our Doctors')

@section('content')
<div class="container mt-5">
    <h2>Meet Our Doctors</h2>

    <!-- Search Form -->
    <form action="{{ route('doctors.publicList') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or specialization" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>

    <!-- Doctor List -->
    @if($doctors->isEmpty())
        <p>No doctors found.</p>
    @else
        <div class="row">
            @foreach($doctors as $doctor)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <!-- Doctor's Image -->
                            @if($doctor->image)
                                <img src="{{ asset('storage/' . $doctor->image) }}" class="img-fluid rounded-circle mb-2" alt="{{ $doctor->user->name }}" style="width: 100px; height: 100px;">
                            @else
                                <img src="{{ asset('assets/img/doctors/doctor-thumb-02.jpg') }}" class="img-fluid rounded-circle mb-2" alt="{{ $doctor->user->name }}">
                            @endif

                            <!-- Doctor's Name -->
                            <h5>{{ $doctor->user->name }}</h5>

                            <!-- Doctor's Specialization -->
                            <p class="text-muted">{{ $doctor->specialization }}</p>

                            <!-- Doctor Profile Button -->
                            <a href="{{ route('doctor.profile', $doctor->id) }}" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $doctors->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
@endsection
