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
                    @include('partials.sidebar') <!-- Profile Sidebar -->
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Basic Information</h4>
                            <form method="POST" action="{{ route('doctor.store-profile') }}" enctype="multipart/form-data">
    @csrf

    <!-- Phone and Gender -->
    <div class="row form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. +1234567890">
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Gender</label>
                <select class="form-control select" name="gender">
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

    <!-- Date of Birth -->
    <div class="row form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" placeholder="e.g. 1988-07-14">
                @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

    <!-- Clinic Information -->
    <h4 class="card-title">Clinic Info</h4>
    <div class="row form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Clinic Name</label>
                <input type="text" name="clinic_name" class="form-control" value="{{ old('clinic_name') }}" placeholder="e.g. Best Health Clinic">
                @error('clinic_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Clinic Address</label>
                <input type="text" name="clinic_address" class="form-control" value="{{ old('clinic_address') }}" placeholder="e.g. 123 Main St">
                @error('clinic_address') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Clinic Images</label>
                <input type="file" name="clinic_images[]" class="form-control" multiple>
                <small class="form-text text-muted">You can upload multiple images. (Max 2MB each)</small>
                @error('clinic_images') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

    <!-- Address -->
    <h4 class="card-title">Contact Details</h4>
    <div class="row form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Address Line 1</label>
                <input type="text" name="address_line_1" class="form-control" value="{{ old('address_line_1') }}" placeholder="e.g. 456 Oak St">
                @error('address_line_1') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Address Line 2</label>
                <input type="text" name="address_line_2" class="form-control" value="{{ old('address_line_2') }}" placeholder="Apartment, Suite, etc.">
                @error('address_line_2') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="e.g. New York">
                @error('city') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>State</label>
                <input type="text" name="state" class="form-control" value="{{ old('state') }}" placeholder="e.g. NY">
                @error('state') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Country</label>
                <input type="text" name="country" class="form-control" value="{{ old('country') }}" placeholder="e.g. United States">
                @error('country') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Postal Code</label>
                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}" placeholder="e.g. 10001">
                @error('postal_code') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

    <!-- Biography -->
    <h4 class="card-title">About Me</h4>
    <div class="form-group">
        <label>Biography</label>
        <textarea class="form-control" name="biography" rows="4" placeholder="Tell us about yourself">{{ old('biography') }}</textarea>
        @error('biography') <small class="text-danger">{{ $message }}</small> @enderror
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
                <div class="input-group mb-2">
                    <input type="text" name="specialization[]" class="form-control" placeholder="Enter Specialization">
                    <button type="button" class="btn btn-danger remove-specialization">Remove</button>
                </div>
            @endif
        </div>
        <button type="button" id="add-specialization" class="btn btn-secondary mt-2">Add Specialization</button>
    </div>

    <!-- Education -->
    <h4 class="card-title">Education</h4>
    <div class="form-group">
        <label>Education</label>
        <textarea class="form-control" name="education" rows="3" placeholder="e.g. Harvard Medical School">{{ old('education') }}</textarea>
        @error('education') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <!-- Experience -->
    <h4 class="card-title">Experience</h4>
    <div class="form-group">
        <label>Experience</label>
        <textarea class="form-control" name="experience" rows="3" placeholder="e.g. 5 years at XYZ Hospital">{{ old('experience') }}</textarea>
        @error('experience') <small class="text-danger">{{ $message }}</small> @enderror
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
        });

        // Existing remove service buttons
        document.querySelectorAll('.remove-service').forEach(function (button) {
            button.addEventListener('click', function () {
                button.closest('.input-group').remove();
            });
        });

        // Existing remove specialization buttons
        document.querySelectorAll('.remove-specialization').forEach(function (button) {
            button.addEventListener('click', function () {
                button.closest('.input-group').remove();
            });
        });
    });
</script>

@endsection
