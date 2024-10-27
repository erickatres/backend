<?php

namespace App\Http\Controllers;

use App\Models\PetBoarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetBoardingController extends Controller
{
    // Store a new pet boarding appointment
    public function store(Request $request)
    {
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
            'check_in_time' => 'required|time',
            'days' => 'required|integer|min:1',
            'hours' => 'required|integer|min:0',
            'additional_details' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $petBoarding = PetBoarding::create($request->all());

        return response()->json($petBoarding, 201);
    }

    // Get all pet boarding appointments
    public function index()
    {
        $petBoardings = PetBoarding::all();
        return response()->json($petBoardings, 200);
    }

    // Get a specific pet boarding appointment by ID
    public function show($id)
    {
        $petBoarding = PetBoarding::find($id);

        if (!$petBoarding) {
            return response()->json(['message' => 'Pet Boarding not found'], 404);
        }

        return response()->json($petBoarding, 200);
    }

    // Update a specific pet boarding appointment
    public function update(Request $request, $id)
    {
        $petBoarding = PetBoarding::find($id);

        if (!$petBoarding) {
            return response()->json(['message' => 'Pet Boarding not found'], 404);
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
            'check_in_time' => 'sometimes|required|time',
            'days' => 'sometimes|required|integer|min:1',
            'hours' => 'sometimes|required|integer|min:0',
            'additional_details' => 'sometimes|nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $petBoarding->update($request->all());

        return response()->json($petBoarding, 200);
    }

    // Delete a specific pet boarding appointment
    public function destroy($id)
    {
        $petBoarding = PetBoarding::find($id);

        if (!$petBoarding) {
            return response()->json(['message' => 'Pet Boarding not found'], 404);
        }

        $petBoarding->delete();
        return response()->json(['message' => 'Pet Boarding deleted successfully'], 204);
    }
}
