<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\PetBoardingBooked; // Ensure to import the Mailable

// Route for testing pet boarding email
Route::get('/test-pet-boarding-email', function () {
    try {
        // Sample pet boarding data
        $petBoardingData = [
            'first_name' => 'Ericka', // Change to your desired first name
            'last_name' => 'Brudo',    // Change to your desired last name
            'phone' => '09519878479',
            'email' => 'erickabrudo2@gmail.com', // Change to your desired email
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
