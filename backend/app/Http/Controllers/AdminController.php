<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all(['id', 'employee_id', 'email']); // hide password
        return response()->json($admins, 200);
    }

    // Create a new admin (registration)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:255|unique:admins',
            'email'       => 'required|email|unique:admins',
            'password'    => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'employee_id' => $validated['employee_id'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Admin created successfully',
            'admin'   => [
                'id'          => $admin->id,
                'employee_id' => $admin->employee_id,
                'email'       => $admin->email,
            ]
        ], 201);
    }

    // Sign in admin using both email and employee_id
    public function sign_in(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|string',
            'email'       => 'required|email',
            'password'    => 'required|string',
        ]);

        $admin = Admin::where('employee_id', $request->employee_id)
                      ->where('email', $request->email)
                      ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $token = $admin->createToken('admin-token')->plainTextToken;

            return response()->json([
                'message' => 'Signin successful',
                'token'   => $token,
                'admin'   => [
                    'id'          => $admin->id,
                    'employee_id' => $admin->employee_id,
                    'email'       => $admin->email,
                ]
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Forgot password - generate and send/reset code
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        $resetCode = rand(1000, 9999);
        $admin->reset_code = $resetCode;
        $admin->save();

        try {
            Mail::raw("Your password reset code is: $resetCode", function ($message) use ($request) {
                $message->to($request->email) 
                        ->from(config('mail.from.address'), config('mail.from.name')) 
                        ->subject('Password Reset Code');
            });

            return response()->json([
                'message' => 'Reset code sent to your email',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message'    => 'Mail not configured. Returning reset code for testing only.',
                'reset_code' => $resetCode
            ], 200);
        }
    }

    // Verify reset code
    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'reset_code' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)
                      ->where('reset_code', $request->reset_code)
                      ->first();

        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid reset code or email.'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Reset code verified successfully.'
        ]);
    }

    // Reset password using verification code
    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:admins,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        return response()->json(['message' => 'Admin not found.'], 404);
    }

    $admin->password = Hash::make($request->password);
    $admin->save();

    return response()->json(['message' => 'Password reset successful.'], 200);
}


    public function show($id)
    {
        $admin = Admin::find($id, ['id', 'employee_id', 'email']);

        if ($admin) {
            return response()->json($admin, 200);
        }
        return response()->json(['message' => 'Admin not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|string|max:255|unique:admins,employee_id,' . $admin->id,
            'email'       => 'sometimes|required|email|unique:admins,email,' . $admin->id,
            'password'    => 'sometimes|required|string|min:6',
        ]);

        $admin->employee_id = $validated['employee_id'] ?? $admin->employee_id;
        $admin->email       = $validated['email'] ?? $admin->email;

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return response()->json([
            'message' => 'Admin updated successfully',
            'admin'   => [
                'id'          => $admin->id,
                'employee_id' => $admin->employee_id,
                'email'       => $admin->email,
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $admin->delete();
        return response()->json(['message' => 'Admin deleted successfully'], 200);
    }
}
