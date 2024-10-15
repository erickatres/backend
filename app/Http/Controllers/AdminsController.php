<?php

namespace App\Http\Controllers;

use App\Models\Supplies;
use App\Models\Services;
use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminsController extends Controller
{
    // Admin management methods
    public function index()
    {
        return Admins::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',  // fullname validation
            'username' => 'required|unique:admins',
            'email' => 'required|email|unique:admins', // Email validation
            'password' => 'required|confirmed',  // password and confirm password validation
        ]);

        // 'password_confirmation' must match 'password'
        $hashedPassword = Hash::make($request->password);

        return Admins::create([
            'fullname' => $request->fullname, // saving fullname
            'username' => $request->username,
            'email' => $request->email, // saving email
            'password' => $hashedPassword,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admins::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $token = $admin->createToken('admin-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function show($id)
    {
        $admin = Admins::find($id);

        if ($admin) {
            return response()->json($admin, 200);
        } else {
            return response()->json(['message' => 'Admin not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $admin = Admins::find($id);

        if ($admin) {
            $request->validate([
                'fullname' => 'sometimes|required|string|max:255',  // fullname validation for update
                'username' => 'required|unique:admins,username,' . $admin->id,
                'email' => 'sometimes|required|email|unique:admins,email,' . $admin->id, // Email validation for update
                'password' => 'sometimes|required|confirmed',  // password and confirm password validation
            ]);

            $admin->fullname = $request->fullname ?? $admin->fullname;  // update fullname
            $admin->username = $request->username;
            $admin->email = $request->email ?? $admin->email; // update email

            if ($request->has('password')) {
                $admin->password = Hash::make($request->password);
            }

            $admin->save();

            return response()->json([
                'message' => 'Admin updated successfully',
                'admin' => $admin
            ], 200);
        } else {
            return response()->json(['message' => 'Admin not found'], 404);
        }
    }

    public function destroy($id)
    {
        $admin = Admins::find($id);

        if ($admin) {
            $admin->delete();
            return response()->json(['message' => 'Admin deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Admin not found'], 404);
        }
    }

    // Supplies management methods
    public function createSupply(Request $request)
    {
        $request->validate([
            'supply_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0', // Added quantity validation
        ]);

        $supply = Supplies::create($request->only(['supply_name', 'description', 'price', 'quantity']));

        return response()->json(['message' => 'Supply created successfully', 'supply' => $supply], 201);
    }

    public function updateSupply(Request $request, $id)
    {
        $supply = Supplies::find($id);

        if (!$supply) {
            return response()->json(['message' => 'Supply not found'], 404);
        }

        $request->validate([
            'supply_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'quantity' => 'sometimes|required|integer|min:0', // Added quantity validation
        ]);

        $supply->update($request->only(['supply_name', 'description', 'price', 'quantity']));

        return response()->json(['message' => 'Supply updated successfully', 'supply' => $supply], 200);
    }

    public function deleteSupply($id)
    {
        $supply = Supplies::find($id);

        if (!$supply) {
            return response()->json(['message' => 'Supply not found'], 404);
        }

        $supply->delete();

        return response()->json(['message' => 'Supply deleted successfully'], 200);
    }

    public function getAllSupplies()
    {
        $supplies = Supplies::all();
        return response()->json($supplies, 200);
    }

    public function getSupply($id)
    {
        $supply = Supplies::find($id);

        if (!$supply) {
            return response()->json(['message' => 'Supply not found'], 404);
        }

        return response()->json($supply, 200);
    }

    // Services management methods
    public function createService(Request $request) 
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $service = Services::create($request->only(['service_name', 'description', 'price']));

        return response()->json(['message' => 'Service created successfully', 'service' => $service], 201);
    }

    public function updateService(Request $request, $id)
    {
        $service = Services::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $request->validate([
            'service_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
        ]);

        $service->update($request->only(['service_name', 'description', 'price']));

        return response()->json(['message' => 'Service updated successfully', 'service' => $service], 200);
    }

    public function deleteService($id)
    {
        $service = Services::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully'], 200);
    }

    public function getAllServices()
    {
        $services = Services::all();
        return response()->json($services, 200);
    }

    public function getService($id)
    {
        $service = Services::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        return response()->json($service, 200);
    }

    // Password reset management
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email', // Validate email
            'password' => 'required|confirmed', // confirm password field
        ]);

        $admin = Admins::where('email', $request->email)->first();
        if ($admin) {
            $admin->password = Hash::make($request->password); // Hash the new password
            $admin->save();

            // Send the email notification
            Mail::send('emails.password_reset', ['admin' => $admin], function ($message) use ($admin) {
                $message->to($admin->email)
                    ->subject('Your Password Has Been Reset');
            });

            return response()->json(['message' => 'Password reset successfully'], 200);
        }

        return response()->json(['message' => 'Admin not found'], 404);
    }
}
