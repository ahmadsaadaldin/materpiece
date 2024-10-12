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
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Routes protected by authentication middleware
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    // Patient-related routes
    Route::get('/patient/dashboard', [PatientController::class, 'patientDashboard'])->name('patients.patient-dashboard');
    Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patients.profile');
    Route::post('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('patients.updateProfile');
    Route::get('/patient/index', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patient/create', [PatientController::class, 'create'])->name('patients.create');
    Route::get('/patient/{id}/show', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patient/store', [PatientController::class, 'store'])->name('patients.store');
    Route::put('/patient/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::post('/patient/{id}/destroy', [PatientController::class, 'destroy'])->name('patients.destroy');
    // Invoices management routes


    // Appointment-related routes
    Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');

    Route::get('/appointments/inprogress', [AppointmentController::class, 'inProgressAppointments'])->name('appointments.inprogress');
    
    Route::get('/appointments/{appointment}/manage', [AppointmentController::class, 'manageInProgress'])->name('appointments.manage');

    Route::put('/appointments/{appointment}', [AppointmentController::class, 'updateAppointmentStatus'])->name('appointments.update');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'viewAppointmentDetails'])->name('appointment.details');
    // Doctor-related routes (Dashboard, Profile Settings, and Reviews)
    Route::get('/doctor/appointments', [AppointmentController::class, 'doctorAppointments'])->name('doctorappointments');
// Diagnosis Routes
Route::get('/doctor/diagnosis', [DiagnosisController::class, 'showDiagnosisForm'])->name('doctors.diagnosis.form'); // Show the diagnosis form
Route::post('/doctor/diagnosis', [DiagnosisController::class, 'getDiagnosis'])->name('doctors.diagnosis'); // Process the diagnosis form and show the result

    Route::get('/doctor-dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/create-profile', [DoctorController::class, 'createProfile'])->name('doctor.create-profile');
    Route::post('/doctor/store-profile', [DoctorController::class, 'storeProfile'])->name('doctor.store-profile');
    Route::get('/doctor/profile-settings', [DoctorController::class, 'profileSettings'])->name('doctor.profile-settings');
    Route::get('/doctor/reviews', [DoctorController::class, 'showDoctorReviews'])->name('doctor.reviews');
    Route::post('/doctor/{id}/submit-review', [ReviewController::class, 'submitReview'])->name('doctor.submitReview');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');

    // Medical record routes
    Route::get('patient/{id}/medical-records', [MedicalRecordController::class, 'index'])->name('medical_records.index');
    Route::get('patient/{id}/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical_records.create');
    Route::post('patient/{id}/medical-records', [MedicalRecordController::class, 'store'])->name('medical_records.store');
    Route::get('medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical_records.edit');
    Route::put('medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical_records.update');
    Route::delete('medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('medical_records.destroy');
    Route::get('/medical-records/{id}/details', [MedicalRecordController::class, 'show'])->name('medical.history.details');

    // Doctor-patient relationships
    Route::get('/doctor/incomplete-patients', [PatientController::class, 'incompletePatients'])->name('patients.incomplete');
    Route::get('/doctor/patient/{patient}/complete', [PatientController::class, 'completePatientForm'])->name('patients.complete.form');
    Route::post('/doctor/patient/{patient}/complete', [PatientController::class, 'saveCompletedPatient'])->name('patients.complete.save');
    Route::get('/doctor/my-patients', [PatientController::class, 'myPatients'])->name('website.mypatients');
    Route::get('/invoices/{invoice}/details', [InvoiceController::class, 'viewInvoiceDetails'])->name('invoices.details');

    // Booking a doctor
    Route::get('/booking/{doctorId}', [AppointmentController::class, 'booking'])->name('appointment.booking');
    Route::get('/appointment/success', [AppointmentController::class, 'success'])->name('appointment.success');
    Route::get('/invoices/index', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/createInvoice/{appointment}', [InvoiceController::class, 'createInvoice'])->name('invoices.createInvoice');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'viewInvoiceDetails'])->name('invoices.details');
    Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');


});

// Routes protected by both authentication and admin middleware
Route::middleware(['auth', 'role:1'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Admin management of users and doctors
    Route::resource('users', UserController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('secretaries', SecretaryController::class);

    // Invoice management for admin


});
// Routes accessible to all users (guest routes)

Route::get('/', [DoctorController::class, 'homepage'])->name('home');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/doctors-public-list', [DoctorController::class, 'publicList'])->name('doctors.publicList');
Route::get('/doctor/{doctor}', [DoctorController::class, 'show'])->name('doctor.profile');