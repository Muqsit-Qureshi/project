<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withSum('items as total_quantity', 'quantity')
        ->withCount('items')
        ->orderBy('id', 'desc')
        ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])->findOrFail($id);
// dd($order);
        return view('admin.orders.show', compact('order'));
    }
}
