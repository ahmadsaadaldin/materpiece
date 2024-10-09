<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Import Log facade to log debug information
use Illuminate\Support\Facades\Auth;
class DiagnosisController extends Controller
{
    public function getDiagnosis(Request $request)
    {
        // Get the patient's symptoms and medical history from the request
        $symptoms = $request->input('symptoms');
        $medicalHistory = $request->input('medical_history');

        // Log inputs for debugging
        Log::info('Received symptoms: ' . $symptoms);
        Log::info('Received medical history: ' . $medicalHistory);

        try {
            // Call the ChatGPT API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer Api_key',
            ])->post('https://api.openai.com/v1/completions', [
                'model' => 'gpt-3.5-turbo',  // Or use 'gpt-4'
                'prompt' => 'A patient is experiencing symptoms such as ' . $symptoms . '. Their medical history includes ' . $medicalHistory . '. Based on this, what is a likely diagnosis and what should the next steps be?',
                'temperature' => 0.2,  // Focus on accuracy
                'max_tokens' => 400,    // Limit the length of the response
                'top_p' => 0.3,         // Reduce randomness
                'frequency_penalty' => 0.1,
                'presence_penalty' => 0.0
            ]);

            // Log API request status and response
            Log::info('API Request Status: ' . $response->status());
            Log::info('API Response: ' . $response->body());

            if ($response->successful()) {
                // Extract the diagnosis suggestions from the response
                $suggestions = $response->json('choices.0.text');

                // Log the suggestions for debugging
                Log::info('Diagnosis suggestions: ' . $suggestions);

                // Pass the suggestions to the view
                return view('doctors.diagnosis-output', compact('suggestions'));
            } else {
                // Log error if the API request failed
                Log::error('API Request failed with status: ' . $response->status());

                // Return to the form with an error message
                return redirect()->back()->withErrors(['error' => 'Failed to get a response from the API.']);
            }
        } catch (\Exception $e) {
            // Log any exceptions that occur during the request
            Log::error('API Request Exception: ' . $e->getMessage());

            // Return to the form with an error message
            return redirect()->back()->withErrors(['error' => 'An error occurred while trying to get the diagnosis.']);
        }
    }
    public function showDiagnosisForm()
    {
        $doctor = Auth::user()->doctor; // Assuming the logged-in user is a doctor
        return view('doctors.diagnosis', compact('doctor'));
    }
    

}
