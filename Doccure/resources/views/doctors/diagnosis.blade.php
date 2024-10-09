@extends('layouts.website')

@section('title', 'Diagnosis Assistant')

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
                            <li class="breadcrumb-item active" aria-current="page">Diagnosis Assistant</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Diagnosis Assistant</h2>
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
                            <h4 style="color: white;">Diagnosis Assistant</h4>
                        </div>
                        <div class="card-body">
                            @if($errors->any()) <!-- Show validation errors -->
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('doctors.diagnosis') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="symptoms">Patient's Symptoms:</label>
                                    <textarea name="symptoms" class="form-control" rows="4">{{ old('symptoms') }}</textarea> <!-- Preserve old value -->
                                </div>
                                <div class="form-group mb-3">
                                    <label for="medical_history">Patient's Medical History:</label>
                                    <textarea name="medical_history" class="form-control" rows="4">{{ old('medical_history') }}</textarea> <!-- Preserve old value -->
                                </div>
                                <button type="submit" class="btn btn-primary">Get Diagnosis</button>
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
