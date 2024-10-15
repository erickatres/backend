<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\AdminsController;

// Client Routes
Route::get('/clients', [ClientsController::class, 'index']);
Route::post('/clients/register', [ClientsController::class, 'store']);
Route::post('/clients/login', [ClientsController::class, 'login']);
// Removed forgot-password route, but retained reset-password for clients
Route::post('/clients/reset-password', [ClientsController::class, 'resetPassword']);
Route::get('/clients/{id}', [ClientsController::class, 'show']);
Route::put('/clients/{id}', [ClientsController::class, 'update']);
Route::delete('/clients/{id}', [ClientsController::class, 'destroy']);

// Admin Routes
Route::get('/admins', [AdminsController::class, 'index']);
Route::post('/admins/register', [AdminsController::class, 'store']);
Route::post('/admins/login', [AdminsController::class, 'login']);
// Route for admin password reset (handled without email)
Route::post('/admins/reset-password', [AdminsController::class, 'resetPassword']);
Route::get('/admins/{id}', [AdminsController::class, 'show']);
Route::put('/admins/{id}', [AdminsController::class, 'update']);
Route::delete('/admins/{id}', [AdminsController::class, 'destroy']);

// Route group for admin-managed services and supplies
Route::middleware('auth:sanctum')->group(function () {
    // Service Routes
    Route::post('/services', [AdminsController::class, 'createService']);
    Route::get('/services', [AdminsController::class, 'getAllServices']);
    Route::get('/services/{id}', [AdminsController::class, 'getService']);
    Route::put('/services/{id}', [AdminsController::class, 'updateService']);
    Route::delete('/services/{id}', [AdminsController::class, 'deleteService']);
    
    // Supply Routes
    Route::post('/supplies', [AdminsController::class, 'createSupply']);
    Route::get('/supplies', [AdminsController::class, 'getAllSupplies']);
    Route::get('/supplies/{id}', [AdminsController::class, 'getSupply']);
    Route::put('/supplies/{id}', [AdminsController::class, 'updateSupply']);
    Route::delete('/supplies/{id}', [AdminsController::class, 'deleteSupply']);
});

// Route to get the authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
