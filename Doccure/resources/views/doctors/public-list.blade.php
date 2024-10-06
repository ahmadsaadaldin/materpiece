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
                    <div class="profile-widget">
                        <div class="doc-img">
                            <!-- Doctor's Image -->
                            <a href="{{ route('doctor.profile', $doctor->id) }}">
                                @if($doctor->image)
                                    <img src="{{ asset('storage/' . $doctor->image) }}" class="img-fluid" alt="{{ $doctor->user->name }}">
                                @else
                                    <img src="{{ asset('assets/img/doctors/doctor-thumb-02.jpg') }}" class="img-fluid" alt="{{ $doctor->user->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="pro-content">
                            <h3 class="title">
                                <a href="{{ route('doctor.profile', $doctor->id) }}">{{ $doctor->user->name }}</a>
                                <i class="fas fa-check-circle verified"></i>
                            </h3>
                            <p class="speciality">
    @if(is_array(json_decode($doctor->specialization, true)))
        {{ implode(', ', json_decode($doctor->specialization, true)) }}
    @else
        {{ $doctor->specialization }}
    @endif
</p>

                            <ul class="available-info">
                                <li><i class="fas fa-map-marker-alt"></i> {{ $doctor->user->address }}</li>
                            </ul>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <a href="{{ route('doctor.profile', $doctor->id) }}" class="btn view-btn">View Profile</a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('appointment.booking', $doctor->id) }}" class="btn book-btn">Book Now</a>
                                </div>
                            </div>
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

<!-- CSS to style the doctor cards similarly to the home page -->
<style>
    .profile-widget .doc-img img {
        width: 350px; /* Fixed width */
        height: 250px; /* Fixed height */
        object-fit: cover; /* Ensures the image fits the box without distortion */
        border-radius: 3%; /* Optional: if you want a rounded image */
    }
    .pro-content .btn {
        margin-top: 10px;
        display: inline-block;
        width: 100%;
    }
    .pro-content .title {
        font-size: 18px;
        margin-top: 15px;
    }
    .speciality {
        color: #777;
        margin-top: 5px;
    }
</style>
