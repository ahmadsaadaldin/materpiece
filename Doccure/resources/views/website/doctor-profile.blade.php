@extends('layouts.website')

@section('title', 'Doctor Profile')

@section('content')
<!-- Main Wrapper -->

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Doctor Profile</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Doctor Profile</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container">

        <!-- Doctor Widget -->
        <div class="card">
            <div class="card-body">
                <div class="doctor-widget">
                    <div class="doc-info-left">
                        <div class="doctor-img">
                            <img src="{{ asset('storage/' . $doctor->image) }}" class="img-fluid" alt="{{ $doctor->user->name }}">
                        </div>
                        <div class="doc-info-cont">
                            <h4 class="doc-name">{{ $doctor->user->name }}</h4>
                            <p class="speciality">
                                @if(is_array(json_decode($doctor->specialization, true)))
                                    {{ implode(', ', json_decode($doctor->specialization, true)) }}
                                @else
                                    {{ $doctor->specialization }}
                                @endif
                            </p>

                            <!-- Star Rating under Specialization -->
                            @php
                                $averageRating = round($doctor->reviews->avg('rating'), 1);
                            @endphp

                            @if($averageRating > 0)
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $averageRating)
                                            <i class="fas fa-star" style="color: #ffc107;"></i> <!-- Filled star -->
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

                            <!-- City and Address -->
                            <ul class="available-info">
                                <li><i class="fas fa-map-marker-alt"></i> {{ $doctor->city }}</li>
                            </ul>

                            <div class="clinic-services">
                                <span>{{ $doctor->years_of_experience }} years of experience</span>
                            </div>
                        </div>
                    </div>
                    <div class="doc-info-right">
                        <div class="clinic-booking">
                            <a class="apt-btn" href="{{ route('appointment.booking', $doctor->id) }}">Book Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Doctor Widget -->

        <!-- Doctor Details Tab -->
        <div class="card">
            <div class="card-body pt-0">
                <!-- Tab Menu -->
                <nav class="user-tabs mb-4">
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" href="#doc_overview" data-toggle="tab">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#doc_reviews" data-toggle="tab">Reviews</a>
                        </li>
                    </ul>
                </nav>
                <!-- /Tab Menu -->

                <!-- Tab Content -->
                <div class="tab-content pt-0">
                    <!-- Overview Content -->
                    <div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-12 col-lg-9">
                                <!-- About Details -->
                                <div class="widget about-widget">
                                    <h4 class="widget-title">About Me</h4>
                                    <p>{{ $doctor->biography }}</p>
                                </div>

                                <!-- Education Details -->
                                <div class="widget education-widget">
                                    <h4 class="widget-title">Education</h4>
                                    <p>{{ $doctor->education }}</p>
                                </div>

                                <!-- Services Section -->
                                <div class="widget services-widget">
                                    <h4 class="widget-title">Services</h4>
                                    <div class="services-container">
                                        @foreach(json_decode($doctor->services) as $service)
                                            @if($service)
                                                <span class="service-box">{{ $service }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Overview Content -->

                    <!-- Reviews Content -->
                    <div role="tabpanel" id="doc_reviews" class="tab-pane fade">
                        <!-- Review Listing with scrollable area -->
                        <div class="widget review-listing" style="max-height: 400px; overflow-y: scroll;">
                            <h4 class="widget-title">Reviews</h4>
                            <ul class="comments-list">
                                @forelse($doctor->reviews as $review)
                                    <li class="review-item">
                                        <div class="comment-box">
                                            <div class="comment-body">
                                                <!-- Reviewer Name -->
                                                <span class="comment-author">{{ $review->patient->user->name }}</span>

                                                <!-- Star Rating -->
                                                <div class="review-count rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star filled"></i>
                                                        @else
                                                            <i class="fas fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>

                                                <!-- Review Title -->
                                                <p class="review-title" style="font-weight: bold;">{{ $review->title }}</p>

                                                <!-- Review Content -->
                                                <p class="comment-content">{{ $review->content }}</p>

                                                <!-- Time of Comment -->
                                                <span class="comment-date">{{ $review->created_at->diffForHumans() }}</span>

                                                <!-- Delete Review Button (Only show to the owner) -->
                                                @if(auth()->check() && auth()->user()->id === $review->patient->user_id)
                                                    <form action="{{ route('review.destroy', $review->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <p>No reviews yet.</p>
                                @endforelse
                            </ul>
                        </div>
                        <!-- /Review Listing -->

                        <!-- Write Review Section -->
                        @if(auth()->check() && auth()->user()->role_id === 4) <!-- Ensure the logged-in user is a patient (role_id = 4) -->
                            <div class="write-review">
                                <h4>Write a review for <strong>Dr. {{ $doctor->user->name }}</strong></h4>

                                <!-- Review Form -->
                                <form action="{{ route('doctor.submitReview', $doctor->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <div class="star-rating">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input id="star-{{ $i }}" type="radio" name="rating" value="{{ $i }}">
                                                <label for="star-{{ $i }}" title="{{ $i }} stars">
                                                    <i class="active fa fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Title of your review</label>
                                        <input class="form-control" type="text" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Your review</label>
                                        <textarea class="form-control" name="content" rows="4" required>{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Submit Review</button>
                                    </div>

                                    <!-- Display success and error messages -->
                                    @if(session('success'))
                                        <div style="margin-top:100px;" class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </form>
                            </div>
                        @else
                            <p class="text-danger">
                                You need to be <a href="{{ route('login') }}">logged in</a> as a patient to write a review.
                            </p>
                        @endif
                        <!-- /Write Review Section -->
                    </div>
                    <!-- /Reviews Content -->
                </div>
            </div>
        </div>
        <!-- /Doctor Details Tab -->

    </div>
</div>
<!-- /Page Content -->

<!-- CSS for styling services as individual blue boxes -->
<style>
    .services-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .service-box {
        background-color: #e6f7ff;
        border: 1px solid #b3e0ff;
        border-radius: 4px;
        padding: 5px 10px;
        color: #007bff;
        font-weight: bold;
        display: inline-block;
    }

    .widget-title {
        font-size: 20px;
        font-weight: bold;
    }

    /* Styling for reviews */
    .review-item {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        margin-bottom: 50px;
    }

    .comment-content {
        margin-top: 10px;
    }

    .comments-list {
        padding-left: 0;
        list-style: none;
    }

    /* Grey box for each comment */
    .comment-box {
        background-color: #f5f5f5; /* Light grey background */
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .comment-author {
        font-weight: bold;
        font-size: 16px;
        color: #333;
    }

    .rating {
        margin: 10px 0;
    }

    .review-title {
        font-weight: bold;
        font-size: 14px;
        margin-top: 10px;
        color: #007bff;
    }

    .comment-content {
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }

    .comment-date {
        display: block;
        margin-top: 10px;
        font-size: 12px;
        color: #888;
    }

    /* Add scroll to reviews */
    .review-listing {
        max-height: 800px; /* Limit the height of the review section */
        overflow-y: auto;  /* Add scroll to the reviews section */
    }
</style>

@endsection
