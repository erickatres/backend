<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; // Import Mail facade
use App\Mail\PasswordResetMail; // Import the PasswordResetMail mailable (create this if needed)

class ClientsController extends Controller
{
    // Clients registration
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:clients',
            'email' => 'required|email|unique:clients', // Add email validation
            'password' => 'required|min:8|confirmed',
        ]);

        // Save client details
        $hashedPassword = Hash::make($request->password);
        $client = Clients::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email, // Save email
            'password' => $hashedPassword,
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

        $client = Clients::where('username', $request->username)->first();

        if ($client && Hash::check($request->password, $client->password)) {
            $token = $client->createToken('client-token')->plainTextToken;

            // Optional: Send email notification upon successful login (if needed)
            // Mail::to($client->email)->send(new LoginSuccessMail());

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    // Show a single client
    public function show($id)
    {
        $client = Clients::find($id);

        if ($client) {
            return response()->json($client, 200);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }

    // Update client
    public function update(Request $request, $id)
    {
        $client = Clients::find($id);

        if ($client) {
            $request->validate([
                'fullname' => 'sometimes|required|string|max:255',
                'username' => 'sometimes|required|string|max:255|unique:clients,username,' . $client->id,
                'email' => 'sometimes|required|email|unique:clients,email,' . $client->id, // Add email validation for update
                'password' => 'sometimes|required|min:8|confirmed',
            ]);

            $client->fullname = $request->fullname ?? $client->fullname;
            $client->username = $request->username ?? $client->username;
            $client->email = $request->email ?? $client->email; // Update email

            if ($request->has('password')) {
                $client->password = Hash::make($request->password);
            }

            $client->save();

            return response()->json([
                'message' => 'Client updated successfully',
                'client' => $client,
            ], 200);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }

    // Delete client
    public function destroy($id)
    {
        $client = Clients::find($id);

        if ($client) {
            $client->delete();
            return response()->json(['message' => 'Client deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }

    // Send email for password reset
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:clients,email', // Validate email for password reset
        ]);

        // Logic to send password reset email can be added here
        // Optionally, you could generate a password reset link/token if needed
        // Mail::to($request->email)->send(new PasswordResetMail());

        return response()->json(['message' => 'Password reset email sent.'], 200);
    }

    // Reset password without OTP
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:clients,email', // Validate email
            'password' => 'required|min:8|confirmed',
        ]);

        $client = Clients::where('email', $request->email)->first();
        if ($client) {
            $client->password = Hash::make($request->password); // Hash the new password
            $client->save();

            return response()->json(['message' => 'Password reset successfully.'], 200);
        }

        return response()->json(['message' => 'Client not found'], 404);
    }
}
