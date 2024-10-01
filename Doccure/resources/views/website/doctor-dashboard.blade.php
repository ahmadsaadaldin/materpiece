@extends('layouts.website')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="main-wrapper">

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Dashboard</h2>
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
                @include('partials.sidebar')
                    <!-- /Profile Sidebar -->

                </div>

                <div class="col-md-7 col-lg-8 col-xl-9">
                    <!-- Dynamic Appointment Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-4">Patient Appointments</h4>
                            <div class="appointment-tab">

                                <!-- Appointment Tab -->
                                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">Upcoming</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#today-appointments" data-toggle="tab">Today</a>
                                    </li>
                                </ul>
                                <!-- /Appointment Tab -->

                                <div class="tab-content">

                                    <!-- Upcoming Appointment Tab -->
                                    <div class="tab-pane show active" id="upcoming-appointments">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Patient Name</th>
                                                                <th>Appointment Date</th>
                                                                <th>Appointment Time</th>
                                                                <th>Status</th>
                                                                <th class="text-right">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($upcomingAppointments->isEmpty())
                                                                <p>No upcoming scheduled appointments found.</p>
                                                            @else
                                                                @foreach($upcomingAppointments as $appointment)
                                                                    <tr>
                                                                        <td>{{ $appointment->patient->user->name }}</td> <!-- Patient's name -->
                                                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td> <!-- Appointment date -->
                                                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td> <!-- Appointment time -->
                                                                        <td>{{ ucfirst($appointment->status) }}</td> <!-- Status -->
                                                                        <td class="text-right">
                                                                            <div class="table-action">
                                                                                <!-- Accept button -->
                                                                                <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="status" value="completed">
                                                                                    <button style="width:100px" type="submit" class="btn btn-sm bg-success-light">
                                                                                        <i class="fas fa-check"></i> Accept
                                                                                    </button>
                                                                                </form>

                                                                                <!-- Cancel button -->
                                                                                <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="status" value="cancelled">
                                                                                    <button style="width:100px;margin-top:10px" type="submit" class="btn btn-sm bg-danger-light">
                                                                                        <i class="fas fa-times"></i> Cancel
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Upcoming Appointment Tab -->

                                    <!-- Today Appointment Tab -->
                                    <div class="tab-pane" id="today-appointments">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Patient Name</th>
                                                                <th>Appointment Date</th>
                                                                <th>Appointment Time</th>
                                                                <th>Status</th>
                                                                <th class="text-right">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($todayAppointments->isEmpty())
                                                                <p>No appointments scheduled for today.</p>
                                                            @else
                                                                @foreach($todayAppointments as $appointment)
                                                                    <tr>
                                                                        <td>{{ $appointment->patient->user->name }}</td> <!-- Patient's name -->
                                                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td> <!-- Appointment date -->
                                                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td> <!-- Appointment time -->
                                                                        <td>{{ ucfirst($appointment->status) }}</td> <!-- Status -->
                                                                        <td class="text-right">
                                                                            <div class="table-action">
                                                                                <!-- Accept button -->
                                                                                <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="status" value="completed">
                                                                                    <button type="submit" class="btn btn-sm bg-success-light">
                                                                                        <i class="fas fa-check"></i> Accept
                                                                                    </button>
                                                                                </form>

                                                                                <!-- Cancel button -->
                                                                                <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="status" value="cancelled">
                                                                                    <button type="submit" class="btn btn-sm bg-danger-light">
                                                                                        <i class="fas fa-times"></i> Cancel
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Today Appointment Tab -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Appointment Section -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection