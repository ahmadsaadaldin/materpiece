@extends('layouts.website')

@section('title', 'Invoice View')

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
                            <li class="breadcrumb-item active" aria-current="page">Invoice View</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Invoice View</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="invoice-content">
                        <div class="invoice-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="invoice-details">
                                        <strong>Invoice No:</strong> {{ $invoice->invoice_no }} <br>
                                        <strong>Issued:</strong> {{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-md-6 text-right">
    <button class="btn btn-primary" onclick="printInvoice()">
        <i class="fas fa-print"></i> Print Invoice
    </button>
    <!-- Redirect to doctor dashboard button -->
    <a href="{{ route('doctor.dashboard') }}" class="btn btn-success ml-2">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

                            </div>
                        </div>

                        <!-- Invoice Item -->
                        <div id="invoice-print-section">
                            <div class="invoice-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="invoice-info">
                                            <strong class="customer-text">Invoice From</strong>
                                            <p class="invoice-details invoice-details-two">
                                                Dr. {{ $invoice->doctor->user->name ?? 'Doctor name missing' }} <br>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="invoice-info invoice-info2">
                                            <strong class="customer-text">Invoice To</strong>
                                            <p class="invoice-details">
                                                {{ $invoice->patient->user->name ?? 'Patient name missing' }} <br>  
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Invoice Item -->

                            <!-- Invoice Table -->
                            <div class="invoice-item invoice-table-wrap">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="invoice-table table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Description</th>
                                                        <th class="text-right">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Consultation Fee</td>
                                                        <td class="text-right">${{ $invoice->amount }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4 ml-auto">
                                        <div class="table-responsive">
                                            <table class="invoice-table-two table">
                                                <tbody>
                                                    <tr>
                                                        <th>Total Amount:</th>
                                                        <td><span>${{ $invoice->amount }}</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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

<!-- Custom JS for Printing -->
<script>
    function printInvoice() {
        window.print();
    }
</script>

<!-- Print Styles -->
<style>
    @media print {
        /* Hide navigation, buttons, and other non-essential elements */
        .breadcrumb-bar, .btn, .navbar, .footer {
            display: none !important;
        }
        
        /* Ensure the print area is well spaced and properly aligned */
        #invoice-print-section {
            margin: 0;
            padding: 0;
        }

        /* Adjust table layout for better print appearance */
        .invoice-table, .invoice-table-two {
            width: 100%;
            border-collapse: collapse;
        }
        
        .invoice-table th, .invoice-table td {
            padding: 8px;
            border: 1px solid #000;
        }
        
        .invoice-table-two th, .invoice-table-two td {
            padding: 8px;
            border: none;
        }

        /* Set margins for the printed page */
        @page {
            margin: 20mm;
        }
    }
</style>

@endsection
