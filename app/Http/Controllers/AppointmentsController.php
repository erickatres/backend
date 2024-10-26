<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    // Store a new appointment in the database
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
            'furbabys_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:50',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string|max:10',
            'service_type' => 'required|string|max:100',
            'choosen_service' => 'required|string|max:100',
            'additional_details' => 'nullable|string|max:500',
        ]);

        // Create a new appointment instance and save it to the database
        $appointment = Appointment::create($validatedData);

        // Check if the appointment was successfully saved
        if ($appointment) {
            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Appointment successfully booked!',
                'data' => $appointment
            ]);
        } else {
            // Return an error response if something went wrong
            return response()->json([
                'success' => false,
                'message' => 'Failed to book the appointment, please try again.'
            ], 500);
        }
    }

    // Optional: Retrieve all appointments
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    // Optional: Show a specific appointment
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return response()->json($appointment);
    }

    // Optional: Update an appointment
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Validate the form data
        $validatedData = $request->validate([
            'client_name' => 'string|max:255',
            'phone' => 'string|max:20',
            'email' => 'email|max:255',
            'address' => 'nullable|string|max:255',
            'furbabys_name' => 'string|max:255',
            'pet_type' => 'string|max:50',
            'appointment_date' => 'date',
            'appointment_time' => 'string|max:10',
            'service_type' => 'string|max:100',
            'choosen_service' => 'string|max:100',
            'additional_details' => 'nullable|string|max:500',
        ]);

        // Update the appointment instance
        $appointment->update(array_filter($validatedData)); // Only update fields that are present

        return response()->json([
            'success' => true,
            'message' => 'Appointment successfully updated!',
            'data' => $appointment
        ]);
    }

    // Optional: Delete an appointment
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment successfully deleted!'
        ]);
    }
}
