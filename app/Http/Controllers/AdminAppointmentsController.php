<?php

namespace App\Http\Controllers;

use App\Mail\AdminAppointment;
use App\Mail\AdminAppointmentNotification;
use App\Models\Appointments;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AdminAppointmentsController extends Controller
{
    /**
     * Send notification email to the admin about a new appointment.
     *
     * @param \App\Models\Appointments $appointment
     * @param string $status  The status of the appointment ('approved' or 'cancelled')
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendAppointmentNotification(Appointments $appointment, string $status)
    {
        // Validate the status
        if (!in_array($status, ['approved', 'cancelled'])) {
            return response()->json(['error' => 'Invalid appointment status.'], 400);
        }

        // Prepare the appointment data to be sent in the email
        $appointmentData = [
            'first_name' => $appointment->first_name,
            'last_name' => $appointment->last_name,
            'phone' => $appointment->phone,
            'email' => $appointment->email,
            'address' => $appointment->address,
            'furbabys_name' => $appointment->furbabys_name,
            'pet_type' => $appointment->pet_type,
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
            'service_type' => $appointment->service_type,
            'chosen_service' => $appointment->chosen_service,
            'additional_details' => $appointment->additional_details,
            'status' => $status,
        ];

        // Send the email to the admin
        Mail::to('pawsalon.dagupan.ph@gmail.com')->send(new AdminAppointment($appointmentData, $status));

        // Return a response indicating the email was sent successfully
        return response()->json(['message' => 'Admin notified about the new appointment.'], 200);
    }
}
