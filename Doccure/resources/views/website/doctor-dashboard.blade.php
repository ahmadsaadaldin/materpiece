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
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">

                    <!-- Card Section -->
                    <div class="row">
                        <!-- Patients Count Card -->
                        <div class="col-md-4 col-sm-6 col-lg-4 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-primary border-primary">
                                            <i class="fas fa-user-injured"></i>
                                        </span>
                                        <div class="dash-count">
                                            <h3>{{ $patientsCount }}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        <h6 class="text-muted">Patients</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Card -->
                        <div class="col-md-4 col-sm-6 col-lg-4 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-success border-success">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <div class="dash-count">
                                            <h3>${{ number_format($totalRevenue, 2) }}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        <h6 class="text-muted">Revenue</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Appointments Count Card -->
                        <div class="col-md-4 col-sm-6 col-lg-4 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-warning border-warning">
                                            <i class="fas fa-calendar-check"></i>
                                        </span>
                                        <div class="dash-count">
                                            <h3>{{ $appointmentsCount }}</h3>
                                        </div>
                                    </div>
                                    <div class="dash-widget-info">
                                        <h6 class="text-muted">Appointments</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Card Section -->

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
                        @php
                            $today = \Carbon\Carbon::today();
                        @endphp

                        @if($upcomingAppointments->filter(fn($appointment) => \Carbon\Carbon::parse($appointment->appointment_date)->gt($today))->isEmpty())
                            <p>No upcoming scheduled appointments found.</p>
                        @else
                            @foreach($upcomingAppointments as $appointment)
                                @if(\Carbon\Carbon::parse($appointment->appointment_date)->gt($today))
                                    <tr>
                                        <td>{{ $appointment->patient->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                        <td>{{ ucfirst($appointment->status) }}</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <!-- Start Appointment -->
                                                @if($appointment->status !== 'in progress')
                                                    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="in progress">
                                                        <button style="width:100px" type="submit" class="btn btn-sm bg-success-light">
                                                            <i class="fas fa-check"></i> Start
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- View Medical History -->
                                                <a href="{{ route('medical_records.index', ['id' => $appointment->patient->id]) }}" class="btn btn-sm bg-info-light" style="width:150px;margin-top:10px">
                                                    <i class="fas fa-folder-open"></i> View Records
                                                </a>

                                                <!-- Add Medical Record -->
                                                @if($appointment->status === 'completed')
                                                    <a href="{{ route('medical_records.create', ['id' => $appointment->patient->id]) }}" class="btn btn-sm bg-primary-light" style="width:100px;margin-top:10px">
                                                        <i class="fas fa-file-medical"></i> Add Record
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
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
                        @if($todayAppointments->filter(fn($appointment) => \Carbon\Carbon::parse($appointment->appointment_date)->eq($today))->isEmpty())
                            <p>No appointments scheduled for today.</p>
                        @else
                            @foreach($todayAppointments as $appointment)
                                @if(\Carbon\Carbon::parse($appointment->appointment_date)->eq($today))
                                    <tr>
                                        <td>{{ $appointment->patient->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                        <td>{{ ucfirst($appointment->status) }}</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <!-- Start Appointment -->
                                                @if($appointment->status === 'scheduled')
                                                    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="in progress">
                                                        <button type="submit" class="btn btn-sm bg-success-light">
                                                            <i class="fas fa-check"></i> Start
                                                        </button>
                                                    </form>
                                                @elseif($appointment->status === 'in progress')
                                                    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="btn btn-sm bg-success-light">
                                                            <i class="fas fa-check"></i> Complete
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- View Medical History -->
                                                <a href="{{ route('medical_records.index', ['id' => $appointment->patient->id]) }}" class="btn btn-sm bg-info-light" style="width:100px;margin-top:10px">
                                                    <i class="fas fa-folder-open"></i> View Records
                                                </a>

                                                <!-- Add Medical Record -->
                                                @if($appointment->status === 'completed')
                                                    <a href="{{ route('medical_records.create', ['id' => $appointment->patient->id]) }}" class="btn btn-sm bg-primary-light" style="width:100px;margin-top:10px">
                                                        <i class="fas fa-file-medical"></i> Add Record
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

                    <!-- /Dynamic Appointment Section -->

                    <!-- Revenue Chart Section -->
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 30px;">
                            <h4 class="mb-4">Revenue Chart</h4>
                            <canvas id="revenueChart" width="800" height="200"></canvas>
                        </div>
                    </div>
                    <!-- /Revenue Chart Section -->

                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('revenueChart');
        if (ctx) {
            var revenueData = {!! json_encode($dailyRevenue->pluck('total')->toArray()) !!};
            var labelsData = {!! json_encode($dailyRevenue->pluck('date')->map(function ($date) { return \Carbon\Carbon::parse($date)->format('d M Y'); })->toArray()) !!};

            if (revenueData.length === 0) {
                revenueData = [0]; // Default data when no values
                labelsData = ['No Data'];
            }

            var revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsData,
                    datasets: [{
                        label: 'Daily Revenue',
                        data: revenueData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'category',
                            beginAtZero: true,
                            ticks: {
                                autoSkip: false
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
