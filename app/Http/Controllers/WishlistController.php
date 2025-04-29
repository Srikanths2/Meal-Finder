<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
// use App\Models\FoodCategory;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Get all wishlist items for logged-in user
    public function index($id)
    {

        $wishlist = Wishlist::where('user_id', $id) 
                    ->with('foodCategory')
                    ->get();

        if($wishlist->isEmpty()) {
            return response()->json(['message' => 'No items found in wishlist'], 200);
        }
        return response()->json([
            'message' => 'Wishlist items retrieved successfully',
            'wishlist' => $wishlist,
        ], 200);
    }

    // Add a food item to wishlist
    public function store(Request $request)
    {

        $request->validate([
            'food_category_id' => 'required|exists:food_categories,id',
        ]);

        // Check if already exists
        $exists = Wishlist::where('user_id', $request->user_id)
                          ->where('food_category_id', $request->food_category_id)
                          ->exists();

        if ($exists) {
            return response()->json(['message' => 'Item already in wishlist'], 409);
        }

        $wishlist = Wishlist::create([
            'user_id' =>$request->user_id,
            'food_category_id' => $request->food_category_id,
        ]);

        return response()->json(['message' => 'Item added to wishlist', 'wishlist' => $wishlist], 201);
    }

    // Remove an item from wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);

        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist item not found'], 404);
        }

        $wishlist->delete();

        return response()->json(['message' => 'Item removed from wishlist']);
    }
}
