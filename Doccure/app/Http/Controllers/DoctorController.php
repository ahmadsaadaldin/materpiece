<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /**
     * Display the homepage with all doctors.
     */
    public function homepage()
    {
        // Fetch all doctors with their associated user data
        $doctors = Doctor::with('user')->get();

        // Render the homepage view
        return view('website.home', compact('doctors'));
    }

    /**
     * Display a listing of the doctors.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create()
    {
        // Fetch users with the doctor role who are not yet associated with a doctor
        $users = User::whereDoesntHave('doctor')->where('role_id', 2)->get();
        return view('doctors.create', compact('users'));
    }

    /**
     * Store a newly created doctor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/doctors', 'public');
        }

        Doctor::create([
            'user_id' => $request->input('user_id'),
            'specialization' => $request->input('specialization'),
            'years_of_experience' => $request->input('years_of_experience'),
            'image' => $imagePath ?? null,
            'description' => $request->input('description'),
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    /**
     * Display the specified doctor.
     */
    public function show(Doctor $doctor)
    {
        // Get all patients assigned to this doctor using many-to-many relationship
        $patients = $doctor->patients;

        return view('website.doctor-profile', compact('doctor', 'patients'));
    }

    /**
     * Show the form for editing the specified doctor.
     */
    public function edit(Doctor $doctor)
    {
        $users = User::whereDoesntHave('doctor')->where('role_id', 2)->orWhere('id', $doctor->user_id)->get();
        return view('doctors.edit', compact('doctor', 'users'));
    }

    /**
     * Update the specified doctor in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }
            $imagePath = $request->file('image')->store('images/doctors', 'public');
        }

        $doctor->update([
            'user_id' => $request->input('user_id'),
            'specialization' => $request->input('specialization'),
            'years_of_experience' => $request->input('years_of_experience'),
            'image' => $imagePath ?? $doctor->image,
            'description' => $request->input('description'),
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }

    /**
     * Doctor's dashboard view.
     */
    public function dashboard()
    {
        // Get the logged-in doctor
        $doctor = Auth::user()->doctor;

        // Fetch upcoming scheduled appointments (appointments after today with status 'scheduled')
        $upcomingAppointments = $doctor->appointments()
            ->whereDate('appointment_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Fetch today's scheduled appointments
        $todayAppointments = $doctor->appointments()
            ->whereDate('appointment_date', now())
            ->where('status', 'scheduled')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Get all patients assigned to this doctor using many-to-many relationship
        $patients = $doctor->patients;

        // Pass both the upcoming and today's appointments, as well as patients, to the view
        return view('website.doctor-dashboard', compact('doctor', 'upcomingAppointments', 'todayAppointments', 'patients'));
    }
    public function publicList(Request $request)
{
    // Retrieve search query from the request
    $search = $request->input('search');

    // Query to fetch doctors and allow searching by name or specialization
    $doctors = Doctor::with('user')
        ->when($search, function ($query, $search) {
            return $query->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->orWhere('specialization', 'like', '%' . $search . '%');
        })
        ->paginate(10);  // Adjust the pagination as needed

    return view('doctors.public-list', compact('doctors', 'search'));
}


}
