<?php

use App\Mail\AdminAppointment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentBooked;
use App\Mail\ReviewSubmitted;
use App\Mail\PetBoardingBooked; 
use App\Mail\AdminAppointmentNotification; // Import AppointmentNotification Mailable
use App\Models\Reviews;

// In web.php (or api.php)
Route::get('/login', function () {
    return response()->json(['message' => 'Unauthorized'], 401);
})->name('login');


// Route for testing appointment email
Route::get('/test-appointment-email', function () {
    try {
        // Sample appointment data
        $appointmentData = [
            'first_name' => 'Ericka',
            'last_name' => 'Brudo',
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
            'is_editable' => true,
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
            'first_name' => 'Ericka',
            'last_name' => 'Brudo',
            'phone' => '09519878479',
            'email' => 'erickabrudo2@gmail.com',
            'address' => '123 Test St',
            'furbabys_name' => 'Ezra',
            'pet_type' => 'Dog',
            'pet_check_in' => 'Yes',
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

// Route for testing appointment approval notification
Route::get('/test-appointment-approval-notification', function () {
    try {
        // Sample appointment approval data
        $appointmentData = [
            'first_name' => 'Ericka',
            'last_name' => 'Brudo',
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
            'status' => 'approved',
        ];

        // Send approval notification
        Mail::to('pawsalon.dagupan.ph@gmail.com')->send(new AdminAppointment($appointmentData, 'approved'));

        return response()->json(['message' => 'Appointment approval notification sent successfully!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error sending appointment approval notification: ' . $e->getMessage()], 500);
    }
});

// Route for testing appointment cancellation notification
Route::get('/test-appointment-cancellation-notification', function () {
    try {
        // Sample appointment cancellation data
        $appointmentData = [
            'first_name' => 'Ericka',
            'last_name' => 'Brudo',
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
            'status' => 'cancelled',
        ];

        // Send cancellation notification
        Mail::to('pawsalon.dagupan.ph@gmail.com')->send(new AdminAppointment($appointmentData, 'cancelled'));

        return response()->json(['message' => 'Appointment cancellation notification sent successfully!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error sending appointment cancellation notification: ' . $e->getMessage()], 500);
    }
});
