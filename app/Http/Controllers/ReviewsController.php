<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewSubmitted;

class ReviewsController extends Controller
{
    /**
     * Store a new review.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate(Reviews::validationRules());

        // Create the review and automatically manage timestamps
        $review = Reviews::create($validatedData);

        // Send email notification for the new review
        try {
            Mail::to('pawsalon.dagupan.ph@gmail.com')->send(new ReviewSubmitted($review));
        } catch (\Exception $e) {
        }

        return response()->json([
            'message' => 'Review submitted successfully',
            'review' => $review,
        ], 201);
    }

    /**
     * Get all reviews with pagination.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch all reviews with pagination (10 reviews per page)
        $reviews = Reviews::paginate(10); // Adjust the number as needed
        
        return response()->json($reviews);
    }

    /**
     * Get a specific review by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Use findOrFail to automatically handle not found cases
        $review = Reviews::findOrFail($id);

        return response()->json($review);
    }

    /**
     * Update an existing review.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Find the review and return a 404 response if not found
        $review = Reviews::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validate(Reviews::validationRules());

        // Update the review with validated data
        $review->update($validatedData);

        return response()->json([
            'message' => 'Review updated successfully',
            'review' => $review,
        ]);
    }

    /**
     * Delete a review.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the review and return a 404 response if not found
        $review = Reviews::findOrFail($id);

        // Delete the review
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
