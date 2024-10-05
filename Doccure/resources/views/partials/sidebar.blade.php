<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">
                @if($doctor->image)
                    <img src="{{ asset('storage/' . $doctor->image) }}" alt="User Image">
                @else
                    <img src="{{ asset('assets/img/doctors/doctor-thumb-02.jpg') }}" alt="User Image">
                @endif
            </a>
            <div class="profile-det-info">
                <h3>Dr. {{ $doctor->user->name }}</h3> <!-- Doctor's name dynamically loaded -->
                <div class="patient-details">
                    <h5 class="mb-0">{{ $doctor->specialization }}</h5> <!-- Doctor's specialization -->
                </div>
            </div>
        </div>
    </div>

    <!-- Static navigation menu -->
    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                <li class="{{ request()->is('doctor-dashboard') ? 'active' : '' }}">
                    <a href="{{ route('doctor.dashboard') }}">
                        <i class="fas fa-columns"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->is('doctorappointments') ? 'active' : '' }}">
                    <a href="{{ route('doctorappointments') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="{{ request()->is('doctor/incomplete-patients') ? 'active' : '' }}">
                    <a href="{{ route('patients.incomplete') }}">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Incomplete Patients</span>
                    </a>
                </li>
                <li class="{{ request()->is('doctor/my-patients') ? 'active' : '' }}">
                    <a href="{{ route('website.mypatients') }}">
                        <i class="fas fa-user-injured"></i>
                        <span>My Patients</span>
                    </a>
                </li>
                <li class="{{ request()->is('doctor/in-progress-appointments') ? 'active' : '' }}">
                    <a href="{{ route('appointments.inprogress') }}">
                        <i class="fas fa-tasks"></i>
                        <span>In Progress</span>
                    </a>
                </li>
                <li class="{{ request()->is('doctor/diagnosis') ? 'active' : '' }}">
                    <a href="{{ route('doctors.diagnosis') }}">
                        <i class="fas fa-stethoscope"></i>
                        <span>Diagnosis Assistant</span>
                    </a>
                </li>
                <li class="{{ request()->is('doctor/invoices') ? 'active' : '' }}">
                    <a href="{{ route('invoices.index') }}">
                        <i class="fas fa-file-invoice"></i>
                        <span>Invoices</span>
                    </a>
                </li>

                <!-- Add Create Profile link -->
                <li class="{{ request()->is('doctor/create-profile') ? 'active' : '' }}">
                    <a href="{{ route('doctor.create-profile') }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Create Profile</span>
                    </a>
                </li>

                <!-- Add Profile Settings link -->
                <li class="{{ request()->is('doctor/profile-settings') ? 'active' : '' }}">
                    <a href="{{ route('doctor.profile-settings') }}">
                        <i class="fas fa-user-cog"></i>
                        <span>Profile Settings</span>
                    </a>
                </li>

                <!-- Other Links -->
                <li>
                    <a href="reviews.html">
                        <i class="fas fa-star"></i>
                        <span>Reviews</span>
                    </a>
                </li>
                <li>
                    <a href="chat-doctor.html">
                        <i class="fas fa-comments"></i>
                        <span>Message</span>
                        <small class="unread-msg">23</small>
                    </a>
                </li>
                <li>
                    <a href="social-media.html">
                        <i class="fas fa-share-alt"></i>
                        <span>Social Media</span>
                    </a>
                </li>
                <li>
                    <a href="doctor-change-password.html">
                        <i class="fas fa-lock"></i>
                        <span>Change Password</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
    