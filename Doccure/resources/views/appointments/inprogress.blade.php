@extends('layouts.website')

@section('title', 'In Progress Appointments')

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
                            <li class="breadcrumb-item active" aria-current="page">In Progress Appointments</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">In Progress Appointments</h2>
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
                        <!-- In Progress Appointments -->
                        <h2>In Progress Appointments</h2>

                        @if($appointments->isEmpty())
                            <p>No appointments in progress.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->patient->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                            <td>
                                                <a href="{{ route('appointments.manage', $appointment->id) }}" class="btn btn-primary">Manage Appointment</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
@endsection
