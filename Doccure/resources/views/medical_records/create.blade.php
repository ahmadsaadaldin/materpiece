@extends('layouts.website')

@section('title', 'Add Medical Record')

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
                            <li class="breadcrumb-item active" aria-current="page">Add Medical Record</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Add Medical Record</h2>
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
                <!-- /Sidebar -->

                <!-- Main Content -->
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card shadow-sm">
                        <div class="card-header" style="background-color: #15558D;">
                            <h4 style="color: white;">Add Medical Record for {{ $patient->user->name }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('medical_records.store', $patient->id) }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="record_date">Date</label>
                                    <input type="date" name="record_date" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="diagnosis">Diagnosis</label>
                                    <input type="text" name="diagnosis" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="treatment">Treatment</label>
                                    <input type="text" name="treatment" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="prescriptions">Prescriptions</label>
                                    <input type="text" name="prescriptions" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Record</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Main Content -->
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>

@endsection
