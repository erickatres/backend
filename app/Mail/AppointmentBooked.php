<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentBooked extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The appointment data.
     *
     * @var array
     */
    public $appointment;

    /**
     * Create a new message instance.
     *
     * @param array $appointment  The appointment data array
     */
    public function __construct(array $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Booked',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_booked', // Ensure the view exists at resources/views/emails/appointment_booked.blade.php
            with: ['appointment' => $this->appointment], // Pass the appointment data to the view
        );
    }
}

