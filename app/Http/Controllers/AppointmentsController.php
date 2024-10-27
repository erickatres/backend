<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentBooked; // Import the Mailable
use App\Models\Appointments; // Ensure this matches your model's namespace
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Import the Mail facade
use Illuminate\Support\Facades\Log; // Import the Log facade for error logging

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
            'additional_details' => 'nullable|string|max:500',
        ]);

        try {
            // Create and save a new appointment instance
            $appointment = Appointments::create($validatedData);

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
            ];

            // Send confirmation email
            $this->sendConfirmationEmail($validatedData['email'], $appointmentData);

            // Return success response with created appointment data
            return response()->json([
                'success' => true,
                'message' => 'Appointment successfully booked!',
                'data' => $appointment
            ], 201); // HTTP 201 for resource creation
        } catch (\Exception $e) {
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
            // Log the error instead of throwing a new exception
            Log::error('Failed to send confirmation email: ' . $e->getMessage());
            // Optionally, you can handle the response differently
        }
    }

    // Retrieve all appointments
    public function index()
    {
        $appointments = Appointments::all();
        return response()->json($appointments);
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
            'client_name' => 'sometimes|string|max:255',
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
            // Update only provided fields
            $appointment->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Appointment successfully updated!',
                'data' => $appointment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update the appointment, please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the appointment, please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
