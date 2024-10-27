<?php

namespace Tests\Feature;

use App\Mail\AdminAppointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\AdminAppointmentNotification; // Import the AdminAppointmentNotification mailable

class AdminAppointmentEmailTest extends TestCase
{
    /** @test */
    public function it_sends_an_admin_appointment_notification_email()
    {
        Mail::fake(); // Prevent real emails from being sent

        // Sample appointment data
        $appointmentData = [
            'first_name' => 'Ericka',
            'last_name' => 'Brudo',
            'phone' => '09519878479',
            'email' => 'erickabrudo2@gmail.com',
            'address' => 'Bonuan',
            'furbabys_name' => 'Buddy',
            'pet_type' => 'Dog',
            'appointment_date' => '2024-10-30',
            'appointment_time' => '12:00',
            'service_type' => 'grooming',
            'chosen_service' => 'bath & blowdry',
            'additional_details' => 'N/A',
            'status' => 'approved', // Example status
        ];

        // Send the admin appointment notification email
        Mail::to('pawsalon.dagupan.ph@gmail.com')->send(new AdminAppointment($appointmentData, $appointmentData['status']));

        // Assert that the email was sent
        Mail::assertSent(AdminAppointment::class, function ($mail) use ($appointmentData) {
            return $mail->hasTo('pawsalon.dagupan.ph@gmail.com') && 
                   $mail->appointmentData['first_name'] === $appointmentData['first_name'] &&
                   $mail->status === $appointmentData['status'];
        });
    }
}
