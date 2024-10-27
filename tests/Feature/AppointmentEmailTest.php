<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\AppointmentBooked;

class AppointmentEmailTest extends TestCase
{
    /** @test */
    public function it_sends_an_appointment_email()
    {
        Mail::fake(); // Prevent real emails from being sent

        // Your logic to trigger the email sending
        $appointmentData = [
            'first_name' => 'ericka',
            'last_name' => 'brudo',
            'phone' => '09519878479',
            'email' => 'erickabrudo2@gmail.com',
            'address' => 'bonuan',
            'furbabys_name' => 'Buddy',
            'appointment_date' => '2024-10-30',
            'appointment_time' => '12:00',
            'service_type' => 'grooming',
            'chosen_service' => 'bath&blowdry',
            'additional_details' => 'N/A',
        ];

        Mail::to($appointmentData['email'])->send(new AppointmentBooked($appointmentData));

        // Assert that the email was sent
        Mail::assertSent(AppointmentBooked::class, function ($mail) use ($appointmentData) {
            return $mail->hasTo($appointmentData['email']);
        });
    }
}
