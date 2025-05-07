<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddresses;

class UserAddressesController extends Controller
{
    // Fetch all addresses for a user
    public function index($user_id)
    {
        $addresses = UserAddresses::where('user_id', $user_id)->get();

        if ($addresses->isEmpty()) {
            return response()->json([
                'message' => 'No addresses found for the user'
            ], 404);
        }

        return response()->json([
            'message' => 'Addresses fetched successfully',
            'data' => $addresses
        ], 200);
    }

    // Fetch a specific address by ID
    public function show($id)
    {
        $addresses = UserAddresses::find($id);

        if (!$addresses) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Address fetched successfully',
            'data' => $addresses
        ], 200);
    }

    // Add a new address
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phonenumber' => 'required|string|max:15',
            'alternate_phone' => 'nullable|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        $addresses = UserAddresses::create($request->all());

        return response()->json([
            'message' => 'Address added successfully',
            'data' => $addresses
        ], 200);
    }

    // Update an address
    public function update(Request $request, $id)
    {
        $addresses = UserAddresses::find($id);

        if (!$addresses) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'phonenumber' => 'sometimes|required|string|max:15',
            'alternate_phone' => 'nullable|string|max:15',
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string|max:100',
            'state' => 'sometimes|required|string|max:100',
            'pincode' => 'sometimes|required|string|max:10',
        ]);

        $addresses->update($request->all());

        return response()->json([
            'message' => 'Address updated successfully',
            'data' => $addresses
        ], 200);
    }

    // Delete an address
    public function destroy($id)
    {
        $addresses = UserAddresses::find($id);

        if (!$addresses) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        }

        $addresses->delete();

        return response()->json([
            'message' => 'Address deleted successfully'
        ], 200);
    }
}
