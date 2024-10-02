@extends('layouts.website')

@section('title', 'Appointments')

@section('content')
<div class="main-wrapper">
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Appointments</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Appointments</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    <!-- Include Sidebar Partial -->
                    @include('partials.sidebar', ['doctor' => $doctor])
                </div>

                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="appointments">
                        <!-- Search and Filter Form -->
                        <form action="{{ route('doctorappointments') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, status, etc." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Appointment List -->
                        @foreach($appointments as $appointment)
                            <div class="appointment-list">
                                <div class="profile-info-widget">
                                    <div class="profile-det-info">
                                        <h3>{{ $appointment->patient->user->name }}</a></h3>
                                        <div class="patient-details">
                                            <h5><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}, {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</h5>
                                            <h5><i class="fas fa-envelope"></i> {{ $appointment->patient->user->email }}</h5>
                                            <h5><i class="fas fa-check-circle text-success"></i> {{ ucfirst($appointment->status) }}</h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Appointment Actions -->
                                <div class="appointment-actions mt-3">
                                    <!-- Only show "Manage" button for appointments in progress -->
                                    @if($appointment->status === 'in progress')
                                        <a href="{{ route('appointments.manage', ['appointment' => $appointment->id]) }}" class="btn btn-primary">Manage Appointment</a>
                                    @endif
                                </div>
                            </div>

                            <!-- Appointment Details Modal -->
                            <div class="modal fade custom-modal" id="appt_details_{{ $appointment->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Appointment Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="info-details">
                                                <li>
                                                    <div class="details-header">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <span class="title">#APT{{ $appointment->id }}</span>
                                                                <span class="text">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }} {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="text-right">
                                                                    <button type="button" class="btn bg-success-light btn-sm" id="topup_status">{{ ucfirst($appointment->status) }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span class="title">Status:</span>
                                                    <span class="text">{{ ucfirst($appointment->status) }}</span>
                                                </li>
                                                <li>
                                                    <span class="title">Confirmed on:</span>
                                                    <span class="text">{{ \Carbon\Carbon::parse($appointment->created_at)->format('d M Y') }}</span>
                                                </li>
                                                <li>
                                                    <span class="title">Notes:</span>
                                                    <span class="text">{{ $appointment->notes ?? 'No notes provided' }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Appointment Details Modal -->
                        @endforeach

                        <div class="pagination-container">
                            {{ $appointments->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
@endsection
