<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\SecretaryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\InvoiceController;

use App\Http\Controllers\ReviewController;
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
Route::get('/patient/dashboard', [PatientController::class, 'patientDashboard'])->name('patients.patient-dashboard');
Route::get('/appointments/{appointment}', [AppointmentController::class, 'viewAppointmentDetails'])->name('appointment.details');


// Admin dashboard route
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::resource('doctor/invoices', InvoiceController::class);
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
// Diagnosis Routes
Route::get('/doctor/diagnosis', [DiagnosisController::class, 'showDiagnosisForm'])->name('doctors.diagnosis.form'); // Show form
Route::post('/doctor/diagnosis', [DiagnosisController::class, 'getDiagnosis'])->name('doctors.diagnosis'); // Process form and display result

// Doctor profile routes
Route::get('/doctor/create-profile', [DoctorController::class, 'createProfile'])->name('doctor.create-profile');
Route::post('/doctor/store-profile', [DoctorController::class, 'storeProfile'])->name('doctor.store-profile');
Route::get('/doctor/profile-settings', [DoctorController::class, 'profileSettings'])->name('doctor.profile-settings');
Route::get('/doctor/reviews', [DoctorController::class, 'showDoctorReviews'])->name('doctor.reviews');

// web.php
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');


// Route for submitting a review
Route::post('/doctor/{id}/submit-review', [ReviewController::class, 'submitReview'])->name('doctor.submitReview');


// Route for viewing a doctor's profile on the website (Keep this after the incomplete-patients route)
Route::get('/doctor/{doctor}', [DoctorController::class, 'show'])->name('doctor.profile');

// Patient management routes
Route::resource('patients', PatientController::class);

// Secretary management routes
Route::resource('secretaries', SecretaryController::class);

Route::get('patient/{id}/medical-records', [MedicalRecordController::class, 'index'])->name('medical_records.index');
Route::get('patient/{id}/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical_records.create');
Route::post('patient/{id}/medical-records', [MedicalRecordController::class, 'store'])->name('medical_records.store');
Route::get('medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical_records.edit');
Route::put('medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical_records.update');
Route::delete('medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('medical_records.destroy');
Route::get('/appointments/inprogress', [AppointmentController::class, 'inProgressAppointments'])->name('appointments.inprogress');
Route::get('/appointments/{appointment}/manage', [AppointmentController::class, 'manageInProgress'])->name('appointments.manage');
Route::get('/doctors-public-list', [DoctorController::class, 'publicList'])->name('doctors.publicList');

Route::get('/invoices/create/{appointment}', [InvoiceController::class, 'create'])->name('invoices.create');

Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoices/create/{appointment}', [InvoiceController::class, 'createInvoice'])->name('invoices.create');


Route::get('/invoices/{invoice}', [InvoiceController::class, 'viewInvoiceDetails'])->name('invoices.details');
Route::get('/medical-records/{id}/details', [MedicalRecordController::class, 'show'])->name('medical.history.details');
Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patients.profile');
Route::post('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('patients.updateProfile');
