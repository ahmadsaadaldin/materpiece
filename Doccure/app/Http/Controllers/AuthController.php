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
        // Validate request data
        $validateData = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "phone" => "required|string|regex:/^[0-9]{10,15}$/", // Validate phone number to be between 10-15 digits
            "password" => "required|string|min:8|confirmed"
        ]);

        // Create the user
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone, // Save phone number
            "password" => Hash::make($request->password),
            "role_id" => 4, // Default role ID for a "patient"
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
   /**
 * Handle user login.
 */
public function login(Request $request)
{

    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:8',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully as Admin');
        }

        if ($user->role_id == 2) {
            return redirect()->route('doctor.dashboard')->with('success', 'Logged in successfully as Doctor');
        }


        return redirect()->route('home')->with('success', 'Logged in successfully');
    } else {

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
