<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * This would show all invoices, if needed.
     */
    public function index()
    {
        // Get the currently logged-in doctor
        $doctor = auth()->user()->doctor;
    
        // Fetch invoices that belong to the logged-in doctor
        $invoices = Invoice::where('doctor_id', $doctor->id)
                            ->with('patient')
                            ->get();
    
        // Return the view with the filtered invoices
        return view('invoices.index', compact('invoices'));
    }
    

    /**
     * Show the form for creating a new invoice.
     */
    public function createInvoice($appointmentId)
    {
        $appointment = Appointment::with('patient.user', 'doctor.user')->findOrFail($appointmentId);
        $doctor = $appointment->doctor; // Retrieve the doctor associated with the appointment
    
        return view('invoices.create', compact('appointment', 'doctor'));
    }
    

    

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'appointment_id' => 'required|exists:appointments,id',
        'amount' => 'required|numeric',
    ]);

    // Retrieve the appointment to get the associated patient ID
    $appointment = Appointment::findOrFail($validatedData['appointment_id']);

    // Create a new invoice
    $invoice = Invoice::create([
        'invoice_no' => 'INV-' . time(),
        'appointment_id' => $validatedData['appointment_id'],
        'amount' => $validatedData['amount'],
        'doctor_id' => Auth::user()->doctor->id,
        'patient_id' => $appointment->patient_id, // Correctly assign the patient_id from the appointment
    ]);

    return redirect()->route('invoices.show', $invoice->id)
                     ->with('success', 'Invoice created successfully.');
}


    /**
     * Display the specified invoice.
     */
    public function show($id)
{
    // Fetch the invoice with related doctor and patient details
    $invoice = Invoice::with('doctor', 'patient')->findOrFail($id);

    return view('invoices.show', compact('invoice'));
}

    

    /**
     * Edit the form for the specified invoice, if needed.
     */
    public function edit(Invoice $invoice)
    {
        // Show the invoice edit form, if required in your project
    }

    /**
     * Update the specified invoice in storage, if needed.
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Logic to update the invoice if necessary (e.g., mark as paid)
    }

    /**
     * Remove the specified invoice from storage, if needed.
     */
    public function destroy(Invoice $invoice)
    {
        // Delete the invoice and redirect
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
