<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Get all cart items for logged-in user
    public function index($id)
    {
        $cart = Cart::where('user_id', $id)
                    ->with('product') // Assuming 'product' is the correct relation name
                    ->get();

        $count = $cart->count('product_id'); // Sum of all item quantities

        return response()->json([
            'message' => $count > 0 ? 'Cart items retrieved successfully' : 'No items found in cart',
            'count' => $count,
            'cart' => $cart,
        ], 200);
    }

    // Add a food item to cart
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = Cart::where('user_id', $request->input('user_id'))
                    ->where('product_id', $request->input('product_id'))
                    ->first();

        if ($cart) {
            // Increment by 1 if already exists
            $cart->quantity += 1;
            $cart->save();

            return response()->json([
                'message' => 'Cart item quantity increased by 1',
                'cart' => $cart
            ], 200);
        } else {
            // Create new item with quantity = 1
            $cart = Cart::create([
                'user_id' => $request->input('user_id'),
                'product_id' => $request->input('product_id'),
                'quantity' => 1,
            ]);

            return response()->json([
                'message' => 'Item added to cart with quantity 1',
                'cart' => $cart
            ], 200);
        }
    }
    
    public function destroy(Request $request, $id)
    {
        $cart = Cart::where('id', $id)->first();
        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }
        $cart->delete();
        return response()->json(['message' => 'Item removed from cart'],200);
    }

    // Update the quantity of a food item in the cart
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'nullable|in:increase,decrease,set',
            'quantity' => 'required|integer|min:1', // only required for 'set'
        ]);

        $cart = Cart::where('id', $id)
                    ->where('user_id', $request->user_id)
                    ->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        // Check if action is valid
        switch ($request->action) {
            case 'increase':
                $cart->quantity += 1;
                break;

            case 'decrease':
                $cart->quantity -= 1;
                if ($cart->quantity <= 0) {
                    $cart->delete();
                    return response()->json(['message' => 'Item removed from cart as quantity is 0']);
                }
                break;

            case 'set':
                $cart->quantity = $request->quantity;
                break;
        }

        $cart->save();

        return response()->json(['message' => 'Cart updated', 'cart' => $cart]);
    }

}
