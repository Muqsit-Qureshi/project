<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutApiController extends Controller
{
    public function checkout(Request $request)
{
    $userId = 1; // hardcoded as per requirement

    // 1️⃣ Get cart for user
    $cart = Cart::where('user_id', $userId)->first();

    if (!$cart) {
        return response()->json([
            'status' => false,
            'message' => 'Cart not found'
        ], 400);
    }

    // 2️⃣ Get cart items with product
    $cartItems = CartItem::with('product')
        ->where('cart_id', $cart->id)
        ->get();

    if ($cartItems->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Cart is empty'
        ], 400);
    }

    // 3️⃣ Calculate total safely
    $total = 0;

    foreach ($cartItems as $item) {
        if (!$item->product) {
            return response()->json([
                'status' => false,
                'message' => 'One or more products in cart are no longer available'
            ], 400);
        }

        $total += $item->price * $item->quantity;
    }

    // 4️⃣ Stripe Payment (Test Mode)
    Stripe::setApiKey(config('services.stripe.secret'));

    $paymentIntent = PaymentIntent::create([
        'amount' => (int) ($total * 100), // INR paise
        'currency' => 'inr',
        'payment_method_types' => ['card'],
    ]);

    // 5️⃣ Create Order
    $order = Order::create([
        'user_id' => $userId,
        'total_amount' => $total,
        'status' => 'paid'
    ]);

    // 6️⃣ Create Order Items
    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'price' => $item->price,
            'quantity' => $item->quantity,
        ]);
    }

    // 7️⃣ Clear cart
    CartItem::where('cart_id', $cart->id)->delete();
    $cart->delete();

    // 8️⃣ Response
    return response()->json([
        'status' => true,
        'message' => 'Payment successful',
        'client_secret' => $paymentIntent->client_secret,
        'order_id' => $order->id
    ]);
}


}
