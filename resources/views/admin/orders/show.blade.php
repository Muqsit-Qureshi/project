@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📦 Order #{{ $order->id }}</h3>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <p><strong>User ID:</strong> {{ $order->user_id }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-warning text-dark">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>Total:</strong> ₹ {{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Order Items</h5>

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                                <td>₹ {{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹ {{ $item->price * $item->quantity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
