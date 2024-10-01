@extends('layouts.website')

@section('title', 'Booking')

@section('content')
    <body>
		<style>
			.timing.unavailable {
    background-color: #ff4d4d !important;  /* Red background for unavailable slots */
    color: #fff !important; /* White text for better contrast */
    cursor: not-allowed; /* Change cursor to indicate it’s not clickable */
    pointer-events: none; /* Prevent any click events */
    border: none; /* Remove border if necessary */
    text-align: center; /* Center the text inside the button */
    padding: 10px 20px; /* Adjust padding for better appearance */
    border-radius: 5px; /* Optional: Add border radius for rounded corners */
    display: inline-block; /* Ensure it behaves like a button */
}


		</style>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif 
        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <!-- Breadcrumb -->
            <div class="breadcrumb-bar">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-12 col-12">
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Booking</li>
                                </ol>
                            </nav>
                            <h2 class="breadcrumb-title">Booking</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->
            
            <!-- Page Content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                        
                            <div class="card">
                                <div class="card-body">
                                    <div class="booking-doc-info">
                                        <a href="{{ route('doctor.profile', $doctor->id) }}" class="booking-doc-img">
                                            <img src="{{ asset('storage/' . $doctor->image) }}" alt="User Image">
                                        </a>
                                        <div class="booking-info">
                                            <h4><a href="{{ route('doctor.profile', $doctor->id) }}">{{ $doctor->user->name }}</a></h4>
                                            <p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> {{ $doctor->user->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Schedule Widget -->
                            <div class="card booking-schedule schedule-widget">
                                <div class="schedule-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="day-slot">
                                                <ul>
                                                    @foreach($weekDays as $day)
                                                        <li>
                                                            <span>{{ $day['day'] }}</span>
                                                            <span class="slot-date">{{ $day['month'] }} {{ $day['day'] }} <small class="slot-year">{{ $day['year'] }}</small></span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="schedule-cont">
    <div class="row">
        <div class="col-md-12">
            <div class="time-slot">
                <ul class="clearfix">
                    @foreach($weekDays as $day)
                        <li>
                            @foreach($day['timeSlots'] as $slot)
                                <a class="timing {{ $slot['is_booked'] ? 'unavailable' : '' }}" 
                                   href="#" 
                                   data-date="{{ $day['year'] }}-{{ $day['month'] }}-{{ $day['day'] }}" 
                                   data-time="{{ $slot['time'] }}"
                                   {{ $slot['is_booked'] ? 'onclick="return false;"' : '' }}>
                                    <span>{{ explode(' ', $slot['time'])[0] }}</span> 
                                    <span>{{ explode(' ', $slot['time'])[1] }}</span>
                                </a>
                            @endforeach
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
						    <!-- Submit Section -->
                            <div style="margin-right:20px" class="submit-section proceed-btn text-right">
                                <button  id="bookAppointment" class="btn btn-primary submit-btn">Book Now</button>
                            </div>
                            <!-- /Submit Section -->
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const timeSlots = document.querySelectorAll('.timing');
                    let selectedDate = '';
                    let selectedTime = '';

                    timeSlots.forEach(slot => {
                        slot.addEventListener('click', function(event) {
                            event.preventDefault();
                            timeSlots.forEach(slot => slot.classList.remove('selected'));
                            this.classList.add('selected');

                            selectedDate = this.getAttribute('data-date');
                            let time = this.getAttribute('data-time');
                            const timeParts = time.match(/(\d+):(\d+) (\wM)/);
                            let hours = parseInt(timeParts[1]);
                            const minutes = timeParts[2];
                            const period = timeParts[3];

                            if (period === 'PM' && hours < 12) hours += 12;
                            if (period === 'AM' && hours === 12) hours = 0;

                            selectedTime = `${hours.toString().padStart(2, '0')}:${minutes}:00`;
                        });
                    });
                    

                    document.getElementById('bookAppointment').addEventListener('click', function() {
                        if (selectedDate && selectedTime) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route("appointments.store") }}';

                            const dateInput = document.createElement('input');
                            dateInput.type = 'hidden';
                            dateInput.name = 'appointment_date';
                            dateInput.value = selectedDate;

                            const timeInput = document.createElement('input');
                            timeInput.type = 'hidden';
                            timeInput.name = 'appointment_time';
                            timeInput.value = selectedTime;

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';

                            const doctorIdInput = document.createElement('input');
                            doctorIdInput.type = 'hidden';
                            doctorIdInput.name = 'doctor_id';
                            doctorIdInput.value = '{{ $doctor->id }}';

                            form.appendChild(dateInput);
                            form.appendChild(timeInput);
                            form.appendChild(csrfInput);
                            form.appendChild(doctorIdInput);

                            document.body.appendChild(form);
                            form.submit();
                        } else {
                            alert('Please select a date and time for your appointment.');
                        }
                    });
                });
            </script>
        </div>
    </body>
@endsection
