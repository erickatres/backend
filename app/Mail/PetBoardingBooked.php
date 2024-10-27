<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PetBoardingBooked extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The pet boarding booking data.
     *
     * @var array
     */
    public $petBoarding;

    /**
     * Create a new message instance.
     *
     * @param array $petBoarding The pet boarding data
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
        return $this->subject('Pet Boarding Appointment Confirmation')
                    ->view('emails.pet_boarding_booked')
                    ->with([
                        'petBoarding' => $this->petBoarding, // Passing pet boarding data to the view
                    ]);
    }
}
