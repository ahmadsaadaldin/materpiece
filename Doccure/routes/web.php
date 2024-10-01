<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\SecretaryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage route to display doctors
Route::get('/', [DoctorController::class, 'homepage'])->name('home');

// Admin dashboard route
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

// User management routes
Route::resource('users', UserController::class);

// Doctor management routes (for admin)
Route::resource('doctors', DoctorController::class);

// Route for booking a doctor
Route::get('/booking/{doctorId}', [AppointmentController::class, 'booking'])->name('appointment.booking');

// Route to handle booking submission
Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');

// Success page after booking an appointment
Route::get('/appointment/success', [AppointmentController::class, 'success'])->name('appointment.success');

// Route to view all appointments for the logged-in doctor
Route::get('/doctorappointments', [AppointmentController::class, 'doctorAppointments'])->name('doctorappointments');

// Route to update the status of an appointment (e.g., mark as completed or cancel)
Route::put('/appointments/{appointment}', [AppointmentController::class, 'updateAppointmentStatus'])->name('appointments.update');

// Registration routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Doctor dashboard route (for after login)
Route::get('/doctor-dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard')->middleware('auth');

// Route for incomplete patients (to be completed by the doctor)
Route::get('/doctor/incomplete-patients', [PatientController::class, 'incompletePatients'])->name('patients.incomplete');

// Route to show form to complete the patient data
Route::get('/doctor/patient/{patient}/complete', [PatientController::class, 'completePatientForm'])->name('patients.complete.form');

// Route to save the completed patient data
Route::post('/doctor/patient/{patient}/complete', [PatientController::class, 'saveCompletedPatient'])->name('patients.complete.save');
Route::get('/doctor/my-patients', [PatientController::class, 'myPatients'])->name('website.mypatients');


// Route for viewing a doctor's profile on the website (Keep this after the incomplete-patients route)
Route::get('/doctor/{doctor}', [DoctorController::class, 'show'])->name('doctor.profile');

// Patient management routes
Route::resource('patients', PatientController::class);

// Secretary management routes
Route::resource('secretaries', SecretaryController::class);

