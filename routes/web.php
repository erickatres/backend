<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentBooked;
use App\Mail\ReviewSubmitted;
use App\Models\Reviews;
use App\Mail\PetBoardingBooked; // Import PetBoardingBooked Mailable
use App\Models\PetBoarding; // Import PetBoarding Model

// Route for testing appointment email
Route::get('/test-appointment-email', function () {
    try {
        // Sample appointment data
        $appointmentData = [
            'first_name' => 'Ericka', // Change here
            'last_name' => 'Brudo',    // Change here
            'phone' => '09519878479',
            'email' => 'erickabrudo2@gmail.com',
            'address' => '123 Test St',
            'furbabys_name' => 'Ezra',
            'pet_type' => 'Dog',
            'appointment_date' => now()->format('Y-m-d'),
            'appointment_time' => now()->format('H:i'),
            'service_type' => 'grooming',
            'chosen_service' => 'bath & blowdry kasi di naliligo',
            'additional_details' => 'N/A',
        ];

        // Send appointment booked email
        Mail::to($appointmentData['email'])->send(new AppointmentBooked($appointmentData));

        return response()->json(['message' => 'Appointment email sent successfully!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error sending appointment email: ' . $e->getMessage()], 500);
    }
});

// Route for testing review email
Route::get('/test-review-email', function () {
    try {
        // Sample review data
        $reviewData = [
            'rating' => 5,
            'comments' => 'Great service!',
            'is_editable' => true, // Ensure to include this if it's required in your model
        ];

        // Create a new review instance and save it to the database
        $review = Reviews::create($reviewData); // Ensure the model is set up correctly

        // Send review submitted email
        Mail::to('pawsalon.dagupan.ph@gmail.com')->send(new ReviewSubmitted($review));

        return response()->json(['message' => 'Review email sent successfully!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error sending review email: ' . $e->getMessage()], 500);
    }
});

// Route for testing pet boarding email
Route::get('/test-pet-boarding-email', function () {
    try {
        // Sample pet boarding data
        $petBoardingData = [
            'first_name' => 'Ericka', // Change here
            'last_name' => 'Brudo',    // Change here
            'phone' => '09519878479',
            'email' => 'erickabrudo2@gmail.com',
            'address' => '123 Test St',
            'furbabys_name' => 'Ezra',
            'pet_type' => 'Dog',
            'pet_check_in' => 'Yes', // Include pet check-in
            'check_in_date' => now()->format('Y-m-d'),
            'check_in_time' => now()->format('H:i'),
            'days' => 3,
            'hours' => 24,
            'additional_details' => 'N/A',
        ];

        // Send pet boarding booked email
        Mail::to($petBoardingData['email'])->send(new PetBoardingBooked($petBoardingData));

        return response()->json(['message' => 'Pet boarding email sent successfully!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error sending pet boarding email: ' . $e->getMessage()], 500);
    }
});
