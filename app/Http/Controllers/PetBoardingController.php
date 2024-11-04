<?php

namespace App\Http\Controllers;

use App\Models\PetBoarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PetBoardingController extends Controller
{
    // Store a new pet boarding appointment
    public function store(Request $request)
    {
        // Log incoming request data for debugging
        Log::info('Incoming request data:', $request->all());

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'furbabys_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'pet_check_in' => 'required|string|max:255',
            'check_in_date' => 'required|date',
            'check_in_time' => ['required', 'string', 'regex:/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/'],
            'days' => 'required|integer',
            'hours' => 'required|integer',
            'additional_details' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed for pet boarding:', $validator->errors()->toArray());
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            // Create a new pet boarding appointment using validated data
            $petBoarding = PetBoarding::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Pet boarding appointment successfully created.',
                'data' => $petBoarding
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating pet boarding appointment: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to create pet boarding appointment'], 500);
        }
    }



    // Get all pet boarding appointments
    public function index()
    {
        $petBoardings = PetBoarding::all();
        return response()->json(['success' => true, 'data' => $petBoardings], 200);
    }

    // Get a specific pet boarding appointment by ID
    public function show($id)
    {
        $petBoarding = PetBoarding::find($id);

        if (!$petBoarding) {
            return response()->json(['success' => false, 'message' => 'Pet Boarding not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $petBoarding], 200);
    }

    // Update a specific pet boarding appointment
    public function update(Request $request, $id)
    {
        $petBoarding = PetBoarding::find($id);

        if (!$petBoarding) {
            return response()->json(['success' => false, 'message' => 'Pet Boarding not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:15',
            'email' => 'sometimes|required|email|max:255',
            'address' => 'sometimes|required|string|max:255',
            'furbabys_name' => 'sometimes|required|string|max:255',
            'pet_type' => 'sometimes|required|string|max:255',
            'pet_check_in' => 'sometimes|required|string|max:255',
            'check_in_date' => 'sometimes|required|date',
            'check_in_time' => 'sometimes|required|regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', // Validate as HH:MM format
            'days' => 'sometimes|required|integer|min:1',
            'hours' => 'sometimes|required|integer|min:0',
            'additional_details' => 'sometimes|nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $petBoarding->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Pet boarding appointment successfully updated.',
                'data' => $petBoarding
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating pet boarding appointment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update pet boarding appointment'], 500);
        }
    }

    // Delete a specific pet boarding appointment
    public function destroy($id)
    {
        $petBoarding = PetBoarding::find($id);

        if (!$petBoarding) {
            return response()->json(['success' => false, 'message' => 'Pet Boarding not found'], 404);
        }

        try {
            $petBoarding->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pet boarding appointment successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting pet boarding appointment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete pet boarding appointment'], 500);
        }
    }
}
