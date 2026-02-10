<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartApiController extends Controller
{
    public function addToCart(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $userId = 1; // hardcoded

    // 1️⃣ Get or create cart
    $cart = Cart::firstOrCreate([
        'user_id' => $userId
    ]);

    // 2️⃣ Check if product already in cart
    $cartItem = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $request->product_id)
        ->first();

    if ($cartItem) {
        $cartItem->quantity += $request->quantity;
        $cartItem->save();
    } else {
        $product = Product::find($request->product_id);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Product added to cart successfully'
    ]);
}

    public function cartList()
    {
        $userId = 1;

        $cart = Cart::with('items.product.images')
            ->where('user_id', $userId)
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => true,
                'data' => [],
                'total' => 0
            ]);
        }

        $total = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'status' => true,
            'data' => $cart->items,
            'total' => $total
        ]);
    }


    public function updateCartItem(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity'     => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($request->cart_item_id);

        // Optional safety check (user_id = 1)
        if (!$cartItem->cart || $cartItem->cart->user_id !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'status' => true,
            'message' => 'Cart item updated successfully'
        ]);
    }



    public function deleteCartItem(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id'
        ]);

        $cartItem = CartItem::findOrFail($request->cart_item_id);

        // Optional safety check
        if (!$cartItem->cart || $cartItem->cart->user_id !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $cartItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Cart item deleted successfully'
        ]);
    }


    // public function checkout()
    // {
    //     $userId = 1;

    //     $cart = Cart::with('items')->where('user_id', $userId)->first();

    //     if (!$cart || $cart->items->isEmpty()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Cart is empty'
    //         ], 400);
    //     }

    //     $total = $cart->items->sum(function ($item) {
    //         return $item->price * $item->quantity;
    //     });

    //     $order = Order::create([
    //         'user_id' => $userId,
    //         'total_amount' => $total,
    //         'status' => 'pending'
    //     ]);

    //     foreach ($cart->items as $item) {
    //         OrderItem::create([
    //             'order_id' => $order->id,
    //             'product_id' => $item->product_id,
    //             'quantity' => $item->quantity,
    //             'price' => $item->price
    //         ]);
    //     }

    //     // Clear cart
    //     $cart->items()->delete();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Order placed successfully',
    //         'order_id' => $order->id
    //     ]);
    // }

}
