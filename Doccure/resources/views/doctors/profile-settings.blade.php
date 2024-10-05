@extends('layouts.website')

@section('title', 'Doctor Profile Settings')

@section('content')
<div class="main-wrapper">
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Profile Settings</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    @include('partials.sidebar') <!-- Sidebar with doctor's details -->
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Basic Information</h4>
                            <form method="POST" action="{{ route('doctor.store-profile') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Avatar Upload -->
                                <div class="form-group">
                                    <label>Profile Picture</label>
                                    <div class="change-avatar">
                                        <div class="profile-img">
                                            <img src="{{ asset($doctor->image ? 'storage/' . $doctor->image : 'assets/img/doctors/default.png') }}" alt="Doctor Image">
                                        </div>
                                        <div class="upload-img">
                                            <div class="change-photo-btn">
                                                <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                <input type="file" name="image" class="upload" />
                                            </div>
                                            <small class="form-text text-muted">Allowed JPG, GIF, or PNG. Max size of 2MB</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Name, Phone, Gender, and Date of Birth -->
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control select" name="gender">
                                                <option value="Male" {{ $doctor->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ $doctor->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $doctor->date_of_birth) }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Clinic Information -->
                                <h4 class="card-title">Clinic Info</h4>
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Clinic Name</label>
                                            <input type="text" name="clinic_name" class="form-control" value="{{ old('clinic_name', $doctor->clinic_name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Clinic Address</label>
                                            <input type="text" name="clinic_address" class="form-control" value="{{ old('clinic_address', $doctor->clinic_address) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Clinic Images</label>
                                            <input type="file" name="clinic_images[]" class="form-control" multiple>
                                            <small class="form-text text-muted">You can upload multiple images.</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <h4 class="card-title">Contact Details</h4>
                                <div class="row form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address Line 1</label>
                                            <input type="text" name="address_line_1" class="form-control" value="{{ old('address_line_1', $doctor->address_line_1) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address Line 2</label>
                                            <input type="text" name="address_line_2" class="form-control" value="{{ old('address_line_2', $doctor->address_line_2) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="{{ old('city', $doctor->city) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" name="state" class="form-control" value="{{ old('state', $doctor->state) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <input type="text" name="country" class="form-control" value="{{ old('country', $doctor->country) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $doctor->postal_code) }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Biography -->
                                <h4 class="card-title">About Me</h4>
                                <div class="form-group">
                                    <label>Biography</label>
                                    <textarea class="form-control" name="biography" rows="4">{{ old('biography', $doctor->biography) }}</textarea>
                                </div>

                                <!-- Services and Specialization -->
                                <h4 class="card-title">Services and Specialization</h4>
                                <div class="form-group">
                                    <label>Services</label>
                                    <input type="text" name="services" class="input-tags form-control" data-role="tagsinput" value="{{ old('services', $doctor->services) }}">
                                </div>

                                <div class="form-group">
                                    <label>Specialization</label>
                                    <input type="text" name="specialization" class="input-tags form-control" value="{{ old('specialization', $doctor->specialization) }}">
                                </div>

                                <!-- Education and Experience -->
                                <h4 class="card-title">Education and Experience</h4>
                                <div class="form-group">
                                    <label>Education</label>
                                    <input type="text" name="education" class="form-control" value="{{ old('education', $doctor->education) }}">
                                </div>
                                <div class="form-group">
                                    <label>Experience</label>
                                    <input type="text" name="experience" class="form-control" value="{{ old('experience', $doctor->experience) }}">
                                </div>

                                <!-- Submit Button -->
                                <div class="submit-section">
                                    <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
@endsection
