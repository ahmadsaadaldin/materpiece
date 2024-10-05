@extends('layouts.website')

@section('title', 'Invoices')

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
                            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Invoices</h2>
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
                    @include('partials.sidebar') <!-- Include your sidebar -->
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card card-table">
                        <div class="card-body">
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('invoices.index') }}" class="mb-4">
                                <div class="row">
                                    <!-- Patient Name Filter -->
                                    <div class="col-md-4">
                                        <input type="text" name="patient_name" class="form-control" placeholder="Search by Patient Name" value="{{ request('patient_name') }}">
                                    </div>
                                    <!-- Date Filter -->
                                    <div class="col-md-4">
                                        <input type="date" name="invoice_date" class="form-control" value="{{ request('invoice_date') }}">
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <!-- /Filter Form -->

                            <!-- Invoice Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Invoice No</th>
                                            <th>Patient Name</th>
                                            <th>Amount</th>
                                            <th>Issued Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($invoices as $invoice)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('invoices.show', $invoice->id) }}">#{{ $invoice->invoice_no }}</a>
                                                </td>
                                                <td>{{ $invoice->patient->user->name ?? 'N/A' }}</td>
                                                <td>${{ $invoice->amount }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y') }}</td>
                                                <td class="text-right">
                                                    <div class="table-action">
                                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm bg-info-light">
                                                            <i class="far fa-eye"></i> View
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No invoices found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /Invoice Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Main Wrapper -->

@endsection
