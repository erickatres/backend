<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Admin Routes
Route::prefix('admins')->group(function () {
    // Admin management (CRUD)
    Route::get('/', [AdminController::class, 'index']);        // List all admins
    Route::post('/', [AdminController::class, 'store']);       // Create new admin (registration)
    Route::get('/{id}', [AdminController::class, 'show']);     // Get specific admin
    Route::put('/{id}', [AdminController::class, 'update']);   // Update specific admin
    Route::delete('/{id}', [AdminController::class, 'destroy']); // Delete specific admin

    // Authentication
    Route::post('/signin', [AdminController::class, 'sign_in']); // Admin login using employee_id + email + password

    // Password reset
    Route::post('/forgot-password', [AdminController::class, 'forgotPassword']); // Request reset code
    Route::post('/reset-password', [AdminController::class, 'resetPassword']);   // Reset password

    Route::post('/verify-reset-code', [AdminController::class, 'verifyResetCode']); // Verify code sent via email

});


// Authenticated user (Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
