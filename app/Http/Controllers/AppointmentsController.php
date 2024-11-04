<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentBooked;
use App\Mail\AdminAppointment;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AppointmentsController extends Controller
{
    // Store a new appointment in the database
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
            'furbabys_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:50',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string|max:10',
            'service_type' => 'required|string|max:100',
            'chosen_service' => 'required|string|max:100',
            'additional_details' => 'sometimes|nullable|string|max:500',
        ]);

        try {
            // Create and save a new appointment instance
            $appointment = Appointments::create(array_merge($validatedData, ['status' => 'pending']));

            // Prepare the appointment data for the email
            $appointmentData = [
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'service' => $validatedData['chosen_service'],
                'date' => $validatedData['appointment_date'],
                'time' => $validatedData['appointment_time'],
                'furbabys_name' => $validatedData['furbabys_name'],
                'pet_type' => $validatedData['pet_type'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'additional_details' => $validatedData['additional_details'],
            ];

            // Send confirmation email
            $this->sendConfirmationEmail($validatedData['email'], $appointmentData);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Appointment successfully booked!',
                'data' => $appointment
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to book appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to book the appointment, please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Send confirmation email
    private function sendConfirmationEmail($email, $appointmentData)
    {
        try {
            Mail::to($email)->send(new AppointmentBooked($appointmentData));
        } catch (\Exception $e) {
            Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }
    }

    // Retrieve all appointments
    public function index()
    {
        return response()->json(Appointments::all());
    }

    // Show a specific appointment by ID
    public function show($id)
    {
        $appointment = Appointments::findOrFail($id);
        return response()->json($appointment);
    }

    // Update an existing appointment
    public function update(Request $request, $id)
    {
        $appointment = Appointments::findOrFail($id);

        // Validate the form data
        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|max:255',
            'address' => 'nullable|string|max:255',
            'furbabys_name' => 'sometimes|string|max:255',
            'pet_type' => 'sometimes|string|max:50',
            'appointment_date' => 'sometimes|date',
            'appointment_time' => 'sometimes|string|max:10',
            'service_type' => 'sometimes|string|max:100',
            'chosen_service' => 'sometimes|string|max:100',
            'additional_details' => 'nullable|string|max:500',
        ]);

        try {
            $appointment->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Appointment successfully updated!',
                'data' => $appointment
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update the appointment, please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Approve an appointment
    public function approve($id)
    {
        $appointment = Appointments::findOrFail($id);
        $appointment->update(['status' => 'approved']);

        // Send notification email to client
        Mail::to($appointment->email)->send(new AdminAppointment($appointment->toArray(), 'approved'));

        return response()->json(['message' => 'Appointment approved successfully!']);
    }

    // Cancel an appointment
    public function cancel($id)
    {
        $appointment = Appointments::findOrFail($id);
        $appointment->update(['status' => 'cancelled']);

        // Send notification email to client
        Mail::to($appointment->email)->send(new AdminAppointment($appointment->toArray(), 'cancelled'));

        return response()->json(['message' => 'Appointment cancelled successfully!']);
    }

    // Delete an appointment by ID
    public function destroy($id)
    {
        try {
            $appointment = Appointments::findOrFail($id);
            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Appointment successfully deleted!'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the appointment, please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
