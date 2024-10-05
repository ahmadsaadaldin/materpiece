@extends('layouts.website')

@section('title', 'Medical Records')

@section('content')

<div class="container mt-5">
    <div class="row">
        @include('partials.sidebar') <!-- Include the sidebar -->

        <div class="col-md-9">
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
                            <table class="table table-bordered"> <!-- Added 'table-bordered' for outer border -->
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
                                            <td>{{ $record->record_date }}</td>
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
        /* Hide everything except the medical records section */
        body * {
            visibility: hidden;
        }

        #medical-records-print-section, #medical-records-print-section * {
            visibility: visible;
        }

        /* Hide sidebar, buttons, and other elements */
        .sidebar, .btn, .navbar, .breadcrumb-bar, .footer {
            display: none !important;
        }

        /* Ensure the print area is well spaced and properly aligned */
        #medical-records-print-section {
            margin: 0;
            padding: 0;
        }

        /* Adjust table layout for better print appearance */
        .table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid black; /* Outer border for the entire table */
        }

        .table th, .table td {
            padding: 8px;
            border: 1px solid black; /* Border for each cell */
        }

        /* Set margins for the printed page */
        @page {
            margin: 20mm;
        }
    }
</style>

@endsection
