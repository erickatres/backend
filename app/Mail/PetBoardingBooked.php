<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PetBoardingBooked extends Mailable
{
    use Queueable, SerializesModels;

    public $petBoarding;

    /**
     * Create a new message instance.
     *
     * @param array $petBoarding
     * @return void
     */
    public function __construct(array $petBoarding)
    {
        $this->petBoarding = $petBoarding;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.pet_boarding_booked') // Specify the view file to render
                    ->subject('Pet Boarding Appointment Confirmation') // Set the email subject
                    ->with(['petBoarding' => $this->petBoarding]); // Pass the petBoarding data to the view
    }
}
