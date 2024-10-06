<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Appointment;
class ReviewController extends Controller
{
    public function submitReview(Request $request, $doctorId)
    {
        // Validate the request data
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);
    
        // Get the logged-in user
        $user = auth()->user();
    
        // Ensure the user is a patient (role_id = 4)
        if ($user->role_id !== 4) {
            return back()->with('error', 'Only patients can leave a review.');
        }
    
        // Check if the patient exists
        $patient = Patient::where('user_id', $user->id)->first();
    
        if (!$patient) {
            return back()->with('error', 'Only patients can leave a review.');
        }
    
        // Check if the patient has had an appointment with the doctor
        $appointment = Appointment::where('doctor_id', $doctorId)
                                  ->where('patient_id', $patient->id)
                                  ->first();
    
        if (!$appointment) {
            return back()->with('error', 'You must have an appointment with this doctor to leave a review.');
        }
    
        // Proceed to create the review
        Review::create([
            'doctor_id' => $doctorId,
            'patient_id' => $patient->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'content' => $request->content,
        ]);
    
        // Redirect back with a success message
        return back()->with('success', 'Review submitted successfully!');
    }
    public function destroy(Review $review)
{
    // Check if the logged-in user is the owner of the review
    if (auth()->user()->id !== $review->patient->user_id) {
        return back()->with('error', 'You can only delete your own reviews.');
    }

    // Delete the review
    $review->delete();

    return back()->with('success', 'Review deleted successfully.');
}

}
