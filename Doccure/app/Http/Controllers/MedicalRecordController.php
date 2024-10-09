<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    /**
     * Display the medical history for a patient.
     */
    public function index($patientId)
    {
        // Fetch the patient and their medical records
        $patient = Patient::with('user')->findOrFail($patientId);
        $medicalRecords = MedicalRecord::where('patient_id', $patientId)->get();
        $doctor = Auth::user()->doctor; // Get the logged-in doctor
        
        return view('medical_records.index', compact('patient', 'medicalRecords', 'doctor'));
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $doctor = Auth::user()->doctor; // Get the logged-in doctor
        return view('medical_records.create', compact('patient', 'doctor'));
    }

    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request, $patientId)
    {
        // Validation
        $request->validate([
            'record_date' => 'required|date',
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'required|string|max:255',
            'prescriptions' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Store the new medical record
        MedicalRecord::create([
            'record_date' => $request->input('record_date'),
            'diagnosis' => $request->input('diagnosis'),
            'treatment' => $request->input('treatment'),
            'prescriptions' => $request->input('prescriptions'),
            'notes' => $request->input('notes'),
            'doctor_id' => auth()->user()->doctor->id,  // Assuming the doctor is logged in
            'patient_id' => $patientId,
            'appointment_id' => $request->input('appointment_id') // Link it to the appointment if applicable
        ]);

        $doctor = Auth::user()->doctor; // Get the logged-in doctor

        return redirect()->route('medical_records.index', $patientId)->with('success', 'Medical record added successfully.')->with(compact('doctor'));
    }

    /**
     * Show the form for editing an existing medical record.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $patient = $medicalRecord->patient;
        $doctor = Auth::user()->doctor; // Get the logged-in doctor
        return view('medical_records.edit', compact('medicalRecord', 'patient', 'doctor'));
    }

    /**
     * Update the specified medical record in storage.
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        // Validation
        $request->validate([
            'record_date' => 'required|date',
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'required|string|max:255',
            'prescriptions' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Update the medical record
        $medicalRecord->update([
            'record_date' => $request->input('record_date'),
            'diagnosis' => $request->input('diagnosis'),
            'treatment' => $request->input('treatment'),
            'prescriptions' => $request->input('prescriptions'),
            'notes' => $request->input('notes'),
        ]);

        $doctor = Auth::user()->doctor; // Get the logged-in doctor

        return redirect()->route('medical_records.index', $medicalRecord->patient_id)->with('success', 'Medical record updated successfully.')->with(compact('doctor'));
    }

    /**
     * Remove the specified medical record from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
        $doctor = Auth::user()->doctor; // Get the logged-in doctor
        return redirect()->back()->with('success', 'Medical record deleted successfully.')->with(compact('doctor'));
    }
    public function show($id)
{
    // Fetch the medical record with related details like doctor and patient
    $medicalRecord = MedicalRecord::with('doctor.user', 'patient.user')->findOrFail($id);

    return view('medical_records.show', compact('medicalRecord'));
}

}
