<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\PetBoardingController; // Include the PetBoardingController

// Client Routes
Route::prefix('clients')->group(function () {
    Route::get('/', [ClientsController::class, 'index'])->name('clients.index'); // Get all clients
    Route::post('/register', [ClientsController::class, 'store'])->name('clients.register'); // Register new client
    Route::post('/login', [ClientsController::class, 'login'])->name('clients.login'); // Client login
    Route::post('/reset-password', [ClientsController::class, 'resetPassword'])->name('clients.reset-password'); // Reset client password
    Route::get('/{id}', [ClientsController::class, 'show'])->name('clients.show'); // Get specific client by ID
    Route::put('/{id}', [ClientsController::class, 'update'])->name('clients.update'); // Update specific client
    Route::delete('/{id}', [ClientsController::class, 'destroy'])->name('clients.destroy'); // Delete specific client
});

// Admin Routes
Route::prefix('admins')->group(function () {
    Route::get('/', [AdminsController::class, 'index'])->name('admins.index'); // Get all admins
    Route::post('/register', [AdminsController::class, 'store'])->name('admins.register'); // Register new admin
    Route::post('/login', [AdminsController::class, 'login'])->name('admins.login'); // Admin login
    Route::post('/reset-password', [AdminsController::class, 'resetPassword'])->name('admins.reset-password'); // Reset admin password
    Route::get('/{id}', [AdminsController::class, 'show'])->name('admins.show'); // Get specific admin by ID
    Route::put('/{id}', [AdminsController::class, 'update'])->name('admins.update'); // Update specific admin
    Route::delete('/{id}', [AdminsController::class, 'destroy'])->name('admins.destroy'); // Delete specific admin
});

// Appointments Routes (Requires Authentication)
Route::middleware('auth:sanctum')->prefix('appointments')->group(function () {
    Route::post('/', [AppointmentsController::class, 'store'])->name('appointments.store'); // Create new appointment
    Route::get('/', [AppointmentsController::class, 'index'])->name('appointments.index'); // Get all appointments
    Route::get('/{id}', [AppointmentsController::class, 'show'])->name('appointments.show'); // Get specific appointment by ID
    Route::put('/{id}', [AppointmentsController::class, 'update'])->name('appointments.update'); // Update specific appointment by ID
    Route::delete('/{id}', [AppointmentsController::class, 'destroy'])->name('appointments.destroy'); // Delete specific appointment by ID

    // Admin routes for approval and cancellation
    Route::post('/{id}/approve', [AppointmentsController::class, 'approve'])->name('appointments.approve'); // Approve appointment
    Route::post('/{id}/cancel', [AppointmentsController::class, 'cancel'])->name('appointments.cancel'); // Cancel appointment
});

// Reviews Routes (Requires Authentication)
Route::middleware('auth:sanctum')->prefix('reviews')->group(function () {
    Route::post('/', [ReviewsController::class, 'store'])->name('reviews.store'); // Create new review
    Route::get('/', [ReviewsController::class, 'index'])->name('reviews.index'); // Get all reviews
    Route::get('/{id}', [ReviewsController::class, 'show'])->name('reviews.show'); // Get specific review by ID
    Route::put('/{id}', [ReviewsController::class, 'update'])->name('reviews.update'); // Update specific review by ID
    Route::delete('/{id}', [ReviewsController::class, 'destroy'])->name('reviews.destroy'); // Delete specific review by ID
});

// Pet Boarding Routes (Requires Authentication)
Route::middleware('auth:sanctum')->prefix('pet-boardings')->group(function () {
    Route::post('/', [PetBoardingController::class, 'store'])->name('pet-boardings.store'); // Create new pet boarding appointment
    Route::get('/', [PetBoardingController::class, 'index'])->name('pet-boardings.index'); // Get all pet boarding appointments
    Route::get('/{id}', [PetBoardingController::class, 'show'])->name('pet-boardings.show'); // Get specific pet boarding appointment by ID
    Route::put('/{id}', [PetBoardingController::class, 'update'])->name('pet-boardings.update'); // Update specific pet boarding appointment by ID
    Route::delete('/{id}', [PetBoardingController::class, 'destroy'])->name('pet-boardings.destroy'); // Delete specific pet boarding appointment by ID
});

// Services and Supplies Routes (Requires Admin Authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Service Routes
    Route::prefix('services')->group(function () {
        Route::post('/', [AdminsController::class, 'createService'])->name('services.store'); // Create new service
        Route::get('/', [AdminsController::class, 'getAllServices'])->name('services.index'); // Get all services
        Route::get('/{id}', [AdminsController::class, 'getService'])->name('services.show'); // Get specific service by ID
        Route::put('/{id}', [AdminsController::class, 'updateService'])->name('services.update'); // Update specific service by ID
        Route::delete('/{id}', [AdminsController::class, 'deleteService'])->name('services.destroy'); // Delete specific service by ID
    });

    // Supply Routes
    Route::prefix('supplies')->group(function () {
        Route::post('/', [AdminsController::class, 'createSupply'])->name('supplies.store'); // Create new supply
        Route::get('/', [AdminsController::class, 'getAllSupplies'])->name('supplies.index'); // Get all supplies
        Route::get('/{id}', [AdminsController::class, 'getSupply'])->name('supplies.show'); // Get specific supply by ID
        Route::put('/{id}', [AdminsController::class, 'updateSupply'])->name('supplies.update'); // Update specific supply by ID
        Route::delete('/{id}', [AdminsController::class, 'deleteSupply'])->name('supplies.destroy'); // Delete specific supply by ID
    });
});

// Route to get the authenticated user
Route::get('/user', function (Request $request) {
    return $request->user(); // Get authenticated user details
})->middleware('auth:sanctum')->name('user.show');
