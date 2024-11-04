<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
{
    // Clients registration
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:clients,username',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|min:8',
        ], [
            'username.unique' => 'This username is already taken. Please choose another one.',
            'email.unique' => 'This email is already registered. Please use a different email address.',
        ]);

        // Save client details
        $hashedPassword = Hash::make($request->password);
        $client = Clients::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'message' => 'Registration successful.',
            'client' => $client,
        ], 201);
    }

    // Client login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find the client by username
        $client = Clients::where('username', $request->username)->first();

        // Check if the client exists
        if (!$client) {
            return response()->json(['message' => 'Username not found'], 404);
        }
        // Verify the password using Hash::check
        else if (Hash::check($request->password, $client->password)) {
            // If the password is correct, generate a token
            $token = $client->createToken('client-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ], 200);
        }
        else {
            return response()->json(['message' => 'Invalid password'], 401);
        }
    }

    // Reset password without OTP
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:clients,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $client = Clients::where('email', $request->email)->first();
        if ($client) {
            $client->password = Hash::make($request->password);
            $client->save();

            return response()->json(['message' => 'Password reset successfully.'], 200);
        }

        return response()->json(['message' => 'Invalid username or password'], 401);
    }
}