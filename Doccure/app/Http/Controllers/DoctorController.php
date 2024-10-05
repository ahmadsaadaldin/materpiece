<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Invoice;

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
        
          // Count the number of patients assigned to this doctor
    $patientsCount = $doctor->patients()->count();

    // Calculate total revenue from invoices
    $totalRevenue = $doctor->invoices()->sum('amount');

    // Count the number of appointments
    $appointmentsCount = $doctor->appointments()->count();
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
    
        // Fetch daily revenue (sum of amounts) grouped by invoice creation date
        $dailyRevenue = Invoice::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('doctor_id', $doctor->id)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    
        // Pass data to the view
        return view('website.doctor-dashboard', compact('doctor', 'upcomingAppointments', 'todayAppointments', 'dailyRevenue','patientsCount', 'totalRevenue', 'appointmentsCount'));
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

public function createProfile()
{
    // Assuming you are fetching the doctor data for the currently logged-in user
    $doctor = Doctor::where('user_id', auth()->user()->id)->first();
    
    return view('doctors.create-profile', compact('doctor'));
}

public function storeProfile(Request $request)
{
    \Log::info('Store profile request', $request->all()); // This will log the form data
    $request->validate([
        'phone' => 'required|numeric|digits_between:7,15',
        'gender' => 'required|in:Male,Female',
        'date_of_birth' => 'required|date|before:today',
        'clinic_name' => 'required|string|max:255',
        'clinic_address' => 'required|string|max:255',
        'clinic_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Allowing multiple images
        'address_line_1' => 'required|string|max:255',
        'address_line_2' => 'nullable|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'nullable|string|max:100',
        'country' => 'required|string|max:100',
        'postal_code' => 'required|numeric|min:5',
        'biography' => 'required|string|max:500',
        'services' => 'nullable|array',
        'specialization' => 'nullable|array',
        'education' => 'required|string|max:500',
        'experience' => 'required|string|max:500',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Profile image validation
    ]);

    // Get the currently authenticated user
    $user = auth()->user();

    // Fetch the existing doctor profile based on user_id
    $doctor = Doctor::where('user_id', $user->id)->firstOrFail(); // Use firstOrFail to ensure the doctor exists

    // Update services and specialization as JSON arrays
    $doctor->services = json_encode($request->input('services', []));
    $doctor->specialization = json_encode($request->input('specialization', []));

    // Update the doctor's profile data
    $doctor->gender = $request->gender;
    $doctor->date_of_birth = $request->date_of_birth;
    $doctor->clinic_name = $request->clinic_name;
    $doctor->clinic_address = $request->clinic_address;
    $doctor->address_line_1 = $request->address_line_1;
    $doctor->address_line_2 = $request->address_line_2;
    $doctor->city = $request->city;
    $doctor->state = $request->state;
    $doctor->country = $request->country;
    $doctor->postal_code = $request->postal_code;
    $doctor->biography = $request->biography;
    $doctor->education = $request->education;
    $doctor->experience = $request->experience;

    // Store profile image if uploaded
    if ($request->hasFile('image')) {
        $doctor->image = $request->file('image')->store('doctors', 'public');
    }

    // Store clinic images if uploaded
    if ($request->hasFile('clinic_images')) {
        $clinicImages = [];
        foreach ($request->file('clinic_images') as $image) {
            $clinicImages[] = $image->store('clinics', 'public');
        }
        $doctor->clinic_images = json_encode($clinicImages); // Store as JSON array
    }

    // Save the updated doctor profile
    $doctor->save();

    // Redirect to profile settings with success message
    return redirect()->route('doctor.profile-settings')->with('success', 'Profile updated successfully.');
}

public function profileSettings()
{
    $doctor = auth()->user()->doctor;
    return view('doctors.profile-settings', compact('doctor'));
}





}
