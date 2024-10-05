@extends('layouts.website')

@section('content')
    <div class="invoice-print">
        <h1>Invoice #{{ $invoice->invoice_no }}</h1>
        <p><strong>Patient:</strong> {{ $invoice->patient->user->name }}</p>
        <p><strong>Amount:</strong> ${{ $invoice->amount }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y') }}</p>

        <!-- Add more details about the invoice as necessary -->
    </div>
@endsection
