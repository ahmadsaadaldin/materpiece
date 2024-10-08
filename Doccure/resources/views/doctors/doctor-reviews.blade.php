@extends('layouts.website')

@section('title', 'Doctor Reviews')

@section('content')

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Reviews</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">My Reviews</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->
    
    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Include Sidebar -->
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    @include('partials.sidebar', ['doctor' => Auth::user()->doctor])
                </div>
                <!-- /Include Sidebar -->

                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="row">
                        @foreach ($reviews as $review)
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Review from {{ $review->patient->user->name }}</h4>
                                        <div class="patient-details">
                                            <h5>Rating: {{ $review->rating }}/5</h5>
                                            <p>{{ $review->content }}</p>
                                            <small>Reviewed on {{ $review->created_at->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main Wrapper -->

@endsection
