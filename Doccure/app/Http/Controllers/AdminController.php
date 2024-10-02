<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Summary data for the dashboard overview
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();

        // Pass summary data to the dashboard view
        return view('admin.dashboard', compact('totalUsers', 'totalDoctors', 'totalPatients', 'totalAppointments'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}