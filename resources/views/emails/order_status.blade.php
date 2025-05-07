<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
</head>
<body>
    <h1>Hello {{ $order->user->name ?? $order->name }},</h1>
    <p>Thank you for your order!</p>

    <p><strong>Order ID:</strong> {{ $order->id }}<br>
    <strong>Total Amount:</strong> ₹{{ $order->total_amount }}<br>
    <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}<br>
    <strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}<br>
    <strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>

    <h3>Items Ordered:</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price (each)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product Deleted' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; border: 1px solid #ccc; padding: 10px;">
        <p><strong>Shipping to:</strong><br>
        {{ $order->address }}<br>
        {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
    </div>

    <p>If you have any questions, feel free to reply to this email.</p>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
