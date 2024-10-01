<?php

namespace App\Http\Controllers;

use App\Models\Secretary;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secretaries = Secretary::with('user', 'doctor.user')->get(); 
        return view('secretaries.index', compact('secretaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereDoesntHave('secretary')->where('role_id', '=', 3)->get(); 
        $doctors = Doctor::with('user')->get(); 
        return view('secretaries.create', compact('users', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'phone_extension' => 'nullable|string|max:10',
        ]);

        Secretary::create([
            'user_id' => $request->input('user_id'),
            'doctor_id' => $request->input('doctor_id'),
            'phone_extension' => $request->input('phone_extension'),
        ]);

        return redirect()->route('secretaries.index')->with('success', 'Secretary created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Secretary $secretary)
    {
        return view('secretaries.show', compact('secretary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secretary $secretary)
    {
        $users = User::where('role_id', '=', 3)->get(); 
        $doctors = Doctor::with('user')->get(); 
        return view('secretaries.edit', compact('secretary', 'users', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secretary $secretary)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'phone_extension' => 'nullable|string|max:10',
        ]);

        $secretary->update([
            'user_id' => $request->input('user_id'),
            'doctor_id' => $request->input('doctor_id'),
            'phone_extension' => $request->input('phone_extension'),
        ]);

        return redirect()->route('secretaries.index')->with('success', 'Secretary updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secretary $secretary)
    {
        $secretary->delete();
        return redirect()->route('secretaries.index')->with('success', 'Secretary deleted successfully.');
    }
}
