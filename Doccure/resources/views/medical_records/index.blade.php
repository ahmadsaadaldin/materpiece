@extends('layouts.website')

@section('title', 'Medical Records')

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
                            <li class="breadcrumb-item active" aria-current="page">Medical Records</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Medical Records</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    @include('partials.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card shadow-sm">
                        <div class="card-header" style="background-color: #15558D;">
                            <h4 style="color: white;">Medical Records for {{ $patient->user->name }}</h4>
                        </div>
                        <div class="card-body">
                            @if($medicalRecords->isEmpty())
                                <p>No medical records found.</p>
                            @else
                                <!-- Print Button -->
                                <div class="text-right mb-3">
                                    <button class="btn btn-primary" onclick="printMedicalRecords()">Print Medical Records</button>
                                </div>

                                <!-- Medical Records Table -->
                                <div id="medical-records-print-section">
                                    <h4>Medical Records for {{ $patient->user->name }}</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Diagnosis</th>
                                                <th>Treatment</th>
                                                <th>Prescriptions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($medicalRecords as $record)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}</td>
                                                    <td>{{ $record->diagnosis }}</td>
                                                    <td>{{ $record->treatment }}</td>
                                                    <td>{{ $record->prescriptions ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <a href="{{ route('medical_records.create', $patient->id) }}" class="btn btn-success mt-3">Add Medical Record</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>

<!-- Custom JS for Printing -->
<script>
    function printMedicalRecords() {
        var printContents = document.getElementById('medical-records-print-section').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<!-- Print Styles -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #medical-records-print-section, #medical-records-print-section * {
            visibility: visible;
        }

        .sidebar, .btn, .navbar, .breadcrumb-bar, .footer {
            display: none !important;
        }

        #medical-records-print-section {
            margin: 0;
            padding: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid black;
        }

        .table th, .table td {
            padding: 8px;
            border: 1px solid black;
        }

        @page {
            margin: 20mm;
        }
    }
</style>

@endsection
