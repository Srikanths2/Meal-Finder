<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;

class CheckoutController extends Controller
{
    // Fetch all addresses for a user
    public function index($user_id)
    {
        $addresses = Checkout::where('user_id', $user_id)->get();

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
        $checkout = Checkout::find($id);

        if (!$checkout) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Address fetched successfully',
            'data' => $checkout
        ], 200);
    }

    // Add a new address
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:15',
            'alternate_phone' => 'nullable|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        $checkout = Checkout::create($request->all());

        return response()->json([
            'message' => 'Address added successfully',
            'data' => $checkout
        ], 200);
    }

    // Update an address
    public function update(Request $request, $id)
    {
        $checkout = Checkout::find($id);

        if (!$checkout) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phonenumber' => 'sometimes|required|string|max:15',
            'alternate_phone' => 'nullable|string|max:15',
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string|max:100',
            'state' => 'sometimes|required|string|max:100',
            'pincode' => 'sometimes|required|string|max:10',
        ]);

        $checkout->update($request->all());

        return response()->json([
            'message' => 'Address updated successfully',
            'data' => $checkout
        ], 200);
    }

    // Delete an address
    public function destroy($id)
    {
        $checkout = Checkout::find($id);

        if (!$checkout) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        }

        $checkout->delete();

        return response()->json([
            'message' => 'Address deleted successfully'
        ], 200);
    }
}
