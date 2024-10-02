<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use Carbon\Carbon;
use App\Models\MedicalRecord;

class AppointmentController extends Controller
{
    // Show available booking slots for a doctor for the next 7 days
    public function booking($doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $weekDays = collect();

        for ($i = 0; $i < 7; $i++) {
            $date = now()->addDays($i)->format('Y-m-d');
            $appointments = Appointment::where('doctor_id', $doctorId)
                                       ->where('appointment_date', $date)
                                       ->pluck('appointment_time')
                                       ->toArray();

            $timeSlots = ['9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM'];
            $availableTimeSlots = [];

            foreach ($timeSlots as $timeSlot) {
                $formattedTimeSlot = date("H:i:s", strtotime($timeSlot));
                $availableTimeSlots[] = [
                    'time' => $timeSlot,
                    'is_booked' => in_array($formattedTimeSlot, $appointments),
                ];
            }

            $weekDays->add([
                'day' => now()->addDays($i)->format('d'),
                'month' => now()->addDays($i)->format('m'),
                'year' => now()->addDays($i)->format('Y'),
                'timeSlots' => $availableTimeSlots,
            ]);
        }

        return view('website.booking', compact('doctor', 'weekDays'));
    }

    // Handle appointment creation
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to book an appointment.');
        }
    
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'doctor_id' => 'required|exists:doctors,id',
        ]);
    
        $userId = Auth::id();
        $patient = Patient::firstOrCreate(
            ['user_id' => $userId],
            [
                'insurance_number' => $request->input('insurance_number', null),
                'medical_history' => $request->input('medical_history', null),
                'date_of_birth' => $request->input('date_of_birth', null),
            ]
        );
    
        $patient->doctors()->syncWithoutDetaching([$request->doctor_id]);
    
        $appointment = Appointment::create([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'scheduled',
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'notes' => $request->notes ?? null,
        ]);
    
        return redirect()->route('appointment.success')->with([
            'doctor' => Doctor::find($request->doctor_id),
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
        ]);
    }

    // Show success page after appointment booking
    public function success(Request $request)
    {
        $doctor = $request->session()->get('doctor');
        $appointment_date = $request->session()->get('appointment_date');
        $appointment_time = $request->session()->get('appointment_time');

        return view('website.booking-success', compact('doctor', 'appointment_date', 'appointment_time'));
    }

    // Show all scheduled appointments for the logged-in doctor
    public function doctorAppointments(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->doctor; // Make sure to pass the doctor

        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $appointments = Appointment::where('doctor_id', $doctor->id)
                                ->where(function ($query) use ($search, $startDate, $endDate) {
                                    if ($search) {
                                        $query->whereHas('patient.user', function ($query) use ($search) {
                                            $query->where('name', 'like', '%' . $search . '%')
                                                  ->orWhere('email', 'like', '%' . $search . '%');
                                        })
                                        ->orWhere('status', 'like', '%' . $search . '%')
                                        ->orWhereRaw('DATE_FORMAT(appointment_date, "%d") LIKE ?', ['%' . $search . '%'])
                                        ->orWhereRaw('DATE_FORMAT(appointment_date, "%m") LIKE ?', ['%' . $search . '%'])
                                        ->orWhereRaw('DATE_FORMAT(appointment_date, "%Y") LIKE ?', ['%' . $search . '%'])
                                        ->orWhere('appointment_time', 'like', '%' . $search . '%');
                                    }
                                    if ($startDate && $endDate) {
                                        $query->whereBetween('appointment_date', [$startDate, $endDate]);
                                    } elseif ($startDate) {
                                        $query->whereDate('appointment_date', '>=', $startDate);
                                    } elseif ($endDate) {
                                        $query->whereDate('appointment_date', '<=', $endDate);
                                    }
                                })
                                ->orderBy('appointment_date', 'asc')
                                ->simplePaginate(5);

        return view('website.appointments', compact('appointments', 'doctor', 'search', 'startDate', 'endDate'));
    }

    // Show in-progress appointments for the logged-in doctor
    public function inProgressAppointments()
    {
        $doctor = Auth::user()->doctor; // Pass the doctor variable here

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'in progress')
            ->with('patient.user')
            ->get();

        return view('appointments.inprogress', compact('appointments', 'doctor')); // Pass doctor to the view
    }

    // Manage in-progress appointment
    public function manageInProgress($appointmentId)
    {
        $appointment = Appointment::with('patient.user')->findOrFail($appointmentId);

        $medicalRecords = MedicalRecord::where('patient_id', $appointment->patient_id)->get();

        return view('appointments.manage', compact('appointment', 'medicalRecords'));
    }

    // Update the status of an appointment
    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $appointment->status = $request->input('status');
        $appointment->save();

        if ($appointment->status == 'in progress') {
            return redirect()->route('appointments.manage', $appointment->id)->with('success', 'Appointment is now in progress.');
        }

        return redirect()->back()->with('success', 'Appointment status updated.');
    }

    // Method to show today's appointments and upcoming appointments separately
    public function showTodayAndUpcomingAppointments()
    {
        $user = Auth::user();
        if ($user->role_id != 2) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        $today = Carbon::today();

        $todayAppointments = Appointment::where('doctor_id', $user->doctor->id)
                                        ->whereDate('appointment_date', $today)
                                        ->where('status', 'scheduled')
                                        ->with('patient')
                                        ->get();

        $upcomingAppointments = Appointment::where('doctor_id', $user->doctor->id)
                                           ->whereDate('appointment_date', '>', $today)
                                           ->where('status', 'scheduled')
                                           ->with('patient')
                                           ->get();

        return view('website.doctor-appointments', compact('todayAppointments', 'upcomingAppointments'));
    }
}
