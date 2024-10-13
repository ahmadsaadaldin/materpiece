@extends('layouts.website')

@section('title', 'Home')

@section('content')
<div class="main-wrapper">
    <!-- Home Banner -->
    <section class="section section-search">
        <div class="container-fluid">
            <div class="banner-wrapper">
                <div class="banner-header text-center">
                    <h1>Search Doctor, Make an Appointment</h1>
                    <p>Discover the best doctors, clinic & hospital the city nearest to you.</p>
                </div>

                <!-- Search -->
                <div class="search-box">
                    <form action="{{ route('doctors.publicList') }}" method="GET">
                        <div class="form-group search-location">
                            <input type="text" name="search" class="form-control" placeholder="Search Location (City or State)" value="{{ request('search') }}">
                            <span class="form-text">Based on your Location</span>
                        </div>
                        <div class="form-group search-info">
                            <input type="text" name="search" class="form-control" placeholder="Search Doctors, Specialization, Clinic Name, Services, etc." value="{{ request('search') }}">
                            <span class="form-text">Ex: Dental, Neurology, Dr. John Doe</span>
                        </div>
                        <button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i> <span>Search</span></button>
                    </form>
                </div>
                <!-- /Search -->
            </div>
        </div>
    </section>
    <!-- /Home Banner -->

    <!-- Popular Section -->
    <section class="section section-doctor">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-header">
                        <h2>Find Trusted Doctors Near You</h2>
                        <p>Book an appointment with the best doctors in your area. Check profiles, read reviews, and make your booking in just a few clicks.</p>
                    </div>
                    <div class="about-content">
                        <p>Explore our selection of top-rated doctors across a variety of specializations, from dentistry to cardiology. Our platform helps you find the care you need, when you need it.</p>
                        <a href="{{ route('doctors.publicList') }}">All doctors</a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="doctor-slider slider">
                        @foreach($doctors as $doctor)
                        <div class="profile-widget">
                            <div class="doc-img">
                                <a href="{{ route('doctor.profile', $doctor->id) }}">
                                    <img class="img-fluid" alt="User Image" src="{{ asset('storage/' . $doctor->image) }}">
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

                                <!-- Star Rating -->
                                @php
                                    $averageRating = round($doctor->reviews->avg('rating'), 1);
                                @endphp

                                @if($averageRating > 0)
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $averageRating)
                                                <i class="fas fa-star" style="color: #ffc107;"></i> <!-- Filled yellow star -->
                                            @else
                                                <i class="far fa-star" style="color: #ffc107;"></i> <!-- Empty star -->
                                            @endif
                                        @endfor
                                        <span>{{ $doctor->reviews->count() }} reviews</span>
                                    </div>
                                @else
                                    <div class="rating">
                                        <span>No reviews yet</span>
                                    </div>
                                @endif

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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Popular Section -->

</div>

<!-- CSS for fixing image size and styling doctor cards -->
<style>
    .profile-widget .doc-img img {
        width: 250px; /* Fixed width */
        height: 150px; /* Fixed height */
        object-fit: cover; /* Ensures the image fits the box without distortion */
        border-radius: 3%; /* Optional: if you want a circular image */
    }
    .rating i {
        color: #ffc107; /* Yellow color for the stars */
    }
</style>
@endsection
