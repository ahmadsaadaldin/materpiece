<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::with('user', 'doctors.user')->get();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('patients.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user is already a patient, if not create a new patient
        $patient = Patient::firstOrCreate(
            ['user_id' => $user->id]
        );

        // Attach the doctor to the patient using many-to-many relationship
        $patient->doctors()->attach($request->doctor_id);

        // Create the appointment and link it to the doctor and patient
        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',  // Assuming default status is pending
        ]);

        return redirect()->route('appointment.success')->with('success', 'Appointment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $doctors = Doctor::with('user')->get();
        return view('patients.edit', compact('patient', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'doctor_id' => 'required|exists:doctors,id',
            'insurance_number' => 'required|string|max:255',
            'medical_history' => 'required|string',
            'date_of_birth' => 'required|date',
        ]);

        // Update patient user data
        $patient->user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        // Attach the new doctor to the patient (if not already assigned)
        if (!$patient->doctors->contains($request->doctor_id)) {
            $patient->doctors()->attach($request->doctor_id);
        }

        // Update the patient data
        $patient->update([
            'insurance_number' => $request->input('insurance_number'),
            'medical_history' => $request->input('medical_history'),
            'date_of_birth' => $request->input('date_of_birth'),
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        // Detach all doctors when deleting a patient
        $patient->doctors()->detach();
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully');
    }

    /**
     * Display incomplete patients for the logged-in doctor.
     */
    public function incompletePatients()
    {
        // Get the logged-in doctor
        $doctor = Auth::user()->doctor;

        // Find patients assigned to the logged-in doctor who have null values for 'insurance_number', 'medical_history', or 'date_of_birth'
        $patients = $doctor->patients()
            ->where(function($query) {
                $query->whereNull('insurance_number')
                      ->orWhereNull('medical_history')
                      ->orWhereNull('date_of_birth');
            })
            ->get();

        return view('patients.incomplete', compact('patients', 'doctor'));
    }

    public function completePatientForm(Patient $patient)
    {
        // Ensure that only the assigned doctor can access this page
        if (!Auth::user()->doctor->patients->contains($patient->id)) {
            return redirect()->back()->with('error', 'You are not authorized to edit this patient.');
        }

        return view('patients.complete', compact('patient'));
    }

    public function saveCompletedPatient(Request $request, Patient $patient)
    {
        // Ensure that only the assigned doctor can update these fields
        if (!Auth::user()->doctor->patients->contains($patient->id)) {
            return redirect()->back()->with('error', 'You are not authorized to update this patient.');
        }

        // Validate the form inputs
        $request->validate([
            'insurance_number' => 'required|string|max:255',
            'medical_history' => 'required|string',
            'date_of_birth' => 'required|date',
        ]);

        // Update the patient record
        $patient->update([
            'insurance_number' => $request->input('insurance_number'),
            'medical_history' => $request->input('medical_history'),
            'date_of_birth' => $request->input('date_of_birth'),
        ]);

        return redirect()->route('doctor.dashboard')->with('success', 'Patient information updated successfully.');
    }

    public function myPatients()
    {
        // Get the logged-in doctor
        $doctor = Auth::user()->doctor;

        // Get patients assigned to this doctor
        $patients = $doctor->patients()->with('user')->get();

        return view('website.my-patients', compact('patients'));
    }
    public function patientDashboard()
    {
        // Eager load medicalRecords along with the doctor and user relationships
        $patient = Patient::where('user_id', Auth::id())
                          ->with('medicalRecords.doctor.user') // Eager load related data
                          ->firstOrFail(); 
    
        // Fetch appointments and invoices
        $appointments = $patient->appointments;
        $invoices = $patient->invoices;
        $medicalRecords = $patient->medicalRecords;
    
        return view('patients.patient-dashboard', compact('appointments', 'invoices', 'medicalRecords'));
    }
    public function profile()
    {
        // Get the authenticated user
        $user = Auth::user();
    
        // Get the corresponding patient data for the authenticated user
        $patient = Patient::where('user_id', $user->id)->first();
    
        // Ensure that the patient data exists
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }
    
        // Pass both the user and patient to the view
        return view('patients.profile', compact('user', 'patient'));
    }
    
    

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
    
        // Find the patient record based on the authenticated user's ID
        $patient = Patient::where('user_id', $user->id)->first();
    
        // Validate the request data
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed', // password confirmation
            'insurance_number' => 'required|string|max:255'
        ]);
    
        // Update user's email
        $user->email = $request->input('email');
    
        // Update user's password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
    
        // If patient record does not exist, show an error or handle accordingly
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient record not found.');
        }
    
        // Update patient's insurance number
        $patient->insurance_number = $request->input('insurance_number');
        $patient->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    
    

}
