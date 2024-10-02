@extends('layouts.website')

@section('title', 'Incomplete Patients')

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
                            <li class="breadcrumb-item active" aria-current="page">Incomplete Patients</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Incomplete Patients</h2>
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
                @include('partials.sidebar', ['doctor' => $doctor])
                </div>
                <!-- /Sidebar -->

                <div class="col-md-7 col-lg-8 col-xl-9">
                    <h1>Incomplete Patients</h1>

                    @if($patients->isEmpty())
                        <p>No patients with incomplete data found.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Insurance Number</th>
                                    <th>Medical History</th>
                                    <th>Date of Birth</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $patient)
                                    <tr>
                                        <td>{{ $patient->user->name }}</td>
                                        <td>{{ $patient->user->email }}</td>
                                        <td>{{ $patient->user->phone }}</td>
                                        <td>{{ $patient->insurance_number ?? 'Missing' }}</td>
                                        <td>{{ $patient->medical_history ?? 'Missing' }}</td>
                                        <td>{{ $patient->date_of_birth ?? 'Missing' }}</td>
                                        <td>
                                            <a href="{{ route('patients.complete.form', $patient->id) }}" class="btn btn-primary">Complete Data</a>
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
    <!-- /Page Content -->
</div>
<!-- /Main Wrapper -->

@endsection
