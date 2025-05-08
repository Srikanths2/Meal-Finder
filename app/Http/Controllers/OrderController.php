<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // Place a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'name' => 'required_without:user_id|string|max:255',
            'email' => 'required_without:user_id|email|max:255',
            'phone_number' => 'required|string|max:15',
            'alternate_phone' => 'nullable|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|in:cod',
            'payment_status' => 'nullable|in:pending,completed,failed',
            'order_status' => 'nullable|in:processing,shipped,delivered,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0'
        ]);

        $validated['payment_method'] = $validated['payment_method'] ?? 'cod';

        $order = Order::create($validated); // excluding items

        foreach ($request->items as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Email
        $email = $order->email ?? $order->user?->email;
        if ($email) {
            Mail::to($email)->send(new OrderStatusMail($order));
        }

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order->load('orderItems.product')
        ], 200);
    }

    // View order by ID
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['order' => $order]);
    }

    // View orders by user ID
    public function showByUser($userId)
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        if (!$orders) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['orders' => $orders]);
    }

    // Admin: list all orders
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product'])->latest()->get();

        return response()->json(['orders' => $orders]);
    }

    // Update status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'order_status' => 'nullable|in:processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,completed,failed'
        ]);

        $order->update($validated);

        $email = $order->email ?? $order->user?->email;
        if ($email) {
            Mail::to($email)->send(new OrderStatusMail($order));
        }

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order->load('orderItems.product')
        ]);
    }

    // Delete order
    public function destroy($id)
    {
        $order = Order::find($id);
        $orderItems = OrderItem::where('order_id', $id)->get();
        
        if ($orderItems->isEmpty()) {
            return response()->json(['message' => 'No items found for this order'], 404);
        }
        foreach ($orderItems as $item) {
            $item->delete();
        }

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
