@extends('layouts.website')

@section('title', 'My Patients')

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
                            <li class="breadcrumb-item active" aria-current="page">My Patients</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">My Patients</h2>
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
                        @foreach ($patients as $patient)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="card widget-profile pat-widget-profile">
                                    <div class="card-body">
                                        <div class="pro-widget-content">
                                            <div class="profile-info-widget">
                                                <div class="profile-det-info">
                                                    <h3>{{ $patient->user->name }}</h3>
                                                    <div class="patient-details">
                                                        <h5><b>Patient ID :</b> {{ $patient->id }}</h5>
                                                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> {{ $patient->user->address ?? 'Location not provided' }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="patient-info">
                                            <ul>
                                                <li>Phone <span>{{ $patient->user->phone ?? 'N/A' }}</span></li>
                                                <li>Age <span>{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Years</span></li>
                                                <li>Medical History <span>{{ $patient->medical_history ?? 'N/A' }}</span></li>
                                            </ul>
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
