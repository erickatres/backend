<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAppointment extends Mailable
{
    use Queueable, SerializesModels;

    public $appointmentData;
    public $status;

    public function __construct($appointmentData, $status)
    {
        $this->appointmentData = $appointmentData;
        $this->status = $status;
    }

    public function build()
    {
        return $this->view('emails.admin_appointment_notification')
            ->with([
                'appointment' => $this->appointmentData,
                'status' => $this->status,
            ]);
    }
}
