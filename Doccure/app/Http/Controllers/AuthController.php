<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view("auth.register");
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
{
    // Validate incoming request, including phone field
    $validateData = $request->validate([
        "name" => "required|string|max:255",
        "email" => "required|email|unique:users,email",
        "phone" => "required|string|max:15",  // Add phone validation
        "password" => "required|string|min:6|confirmed"
    ]);

    // Create a new user with phone number
    User::create([
        "name" => $request->name,
        "email" => $request->email,
        "phone" => $request->phone,  
        "password" => Hash::make($request->password),
        "role_id" => 4,
    ]);

    return redirect("/login")->with("success", "User created successfully");
}

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view("auth.login");
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Validation logic to ensure the email and password meet the criteria
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8', // Password must be at least 8 characters long
        ]);
    
        // Get the credentials (email and password) from the request
        $credentials = $request->only('email', 'password');
    
        // Attempt to log the user in with the provided credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // If the user is a doctor (assuming role_id 2 is for doctors), redirect to the doctor's dashboard page
            if ($user->role_id == 2) {
                return redirect()->route('doctor.dashboard')->with('success', 'Logged in successfully');
            }
    
            // Otherwise, redirect to the homepage or another dashboard
            return redirect()->route('home')->with('success', 'Logged in successfully');
        } else {
            // If authentication fails, redirect back with an error message
            return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
        }
    }
    
    


    /**
     * Handle user logout.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with("success", "Logged out successfully");
    }
}
