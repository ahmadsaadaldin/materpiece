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
                            <!-- Debugging Form -->
                            <form method="POST" action="{{ route('doctor.store-profile') }}" enctype="multipart/form-data"> 
                                @csrf
                                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
                                        <!-- Education -->
<div class="form-group">
    <label>Education</label>
    <textarea class="form-control" name="education" rows="4">{{ old('education', $doctor->education) }}</textarea>
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

                               <!-- Services Section -->
                               <div class="form-group">
    <label>Services</label>
    <div id="services-wrapper">
        @if(is_array(old('services')))
            @foreach(old('services') as $service)
                <div class="input-group mb-2">
                    <input type="text" name="services[]" class="form-control" value="{{ $service }}" placeholder="Enter Service">
                    <button type="button" class="btn btn-danger remove-service">Remove</button>
                </div>
            @endforeach
        @else
            @if(!is_null($doctor->services) && is_array(json_decode($doctor->services)))
                @foreach(json_decode($doctor->services) as $service)
                    <div class="input-group mb-2">
                        <input type="text" name="services[]" class="form-control" value="{{ $service }}" placeholder="Enter Service">
                        <button type="button" class="btn btn-danger remove-service">Remove</button>
                    </div>
                @endforeach
            @endif
            <div class="input-group mb-2">
                <input type="text" name="services[]" class="form-control" placeholder="Enter Service">
                <button type="button" class="btn btn-danger remove-service">Remove</button>
            </div>
        @endif
    </div>
    <button type="button" id="add-service" class="btn btn-secondary mt-2">Add Service</button>
</div>

<!-- Specialization Section -->
<div class="form-group">
    <label>Specialization</label>
    <div id="specialization-wrapper">
        @if(is_array(old('specialization')))
            @foreach(old('specialization') as $spec)
                <div class="input-group mb-2">
                    <input type="text" name="specialization[]" class="form-control" value="{{ $spec }}" placeholder="Enter Specialization">
                    <button type="button" class="btn btn-danger remove-specialization">Remove</button>
                </div>
            @endforeach
        @else
            @if(!is_null($doctor->specialization) && is_array(json_decode($doctor->specialization)))
                @foreach(json_decode($doctor->specialization) as $spec)
                    <div class="input-group mb-2">
                        <input type="text" name="specialization[]" class="form-control" value="{{ $spec }}" placeholder="Enter Specialization">
                        <button type="button" class="btn btn-danger remove-specialization">Remove</button>
                    </div>
                @endforeach
            @endif
            <div class="input-group mb-2">
                <input type="text" name="specialization[]" class="form-control" placeholder="Enter Specialization">
                <button type="button" class="btn btn-danger remove-specialization">Remove</button>
            </div>
        @endif
    </div>
    <button type="button" id="add-specialization" class="btn btn-secondary mt-2">Add Specialization</button>
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

<!-- JavaScript for Adding/Removing Services and Specializations -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add Service
        document.getElementById('add-service').addEventListener('click', function () {
            const servicesWrapper = document.getElementById('services-wrapper');
            const newService = document.createElement('div');
            newService.classList.add('input-group', 'mb-2');
            newService.innerHTML = `
                <input type="text" name="services[]" class="form-control" placeholder="Enter Service">
                <button type="button" class="btn btn-danger remove-service">Remove</button>
            `;
            servicesWrapper.appendChild(newService);

            // Add event listener to the remove button for the new service
            newService.querySelector('.remove-service').addEventListener('click', function () {
                newService.remove();
            });

            console.log("Service added");
        });

        // Add Specialization
        document.getElementById('add-specialization').addEventListener('click', function () {
            const specializationWrapper = document.getElementById('specialization-wrapper');
            const newSpecialization = document.createElement('div');
            newSpecialization.classList.add('input-group', 'mb-2');
            newSpecialization.innerHTML = `
                <input type="text" name="specialization[]" class="form-control" placeholder="Enter Specialization">
                <button type="button" class="btn btn-danger remove-specialization">Remove</button>
            `;
            specializationWrapper.appendChild(newSpecialization);

            // Add event listener to the remove button for the new specialization
            newSpecialization.querySelector('.remove-specialization').addEventListener('click', function () {
                newSpecialization.remove();
            });

            console.log("Specialization added");
        });

        // Existing remove service buttons
        document.querySelectorAll('.remove-service').forEach(function (button) {
            button.addEventListener('click', function () {
                button.closest('.input-group').remove();
                console.log("Service removed");
            });
        });

        // Existing remove specialization buttons
        document.querySelectorAll('.remove-specialization').forEach(function (button) {
            button.addEventListener('click', function () {
                button.closest('.input-group').remove();
                console.log("Specialization removed");
            });
        });
    });
</script>

@endsection
