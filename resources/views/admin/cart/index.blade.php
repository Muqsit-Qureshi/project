@extends('layouts.admin')

@section('content')
<h3 class="mb-3">Cart Items <span class="text-muted">(User ID: 1)</span></h3>

@if(!$cart || $cart->items->isEmpty())
    <div class="alert alert-info">
        Cart is empty
    </div>
@else
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th width="80">Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp

                    @foreach($cart->items as $item)
                        @php
                            $lineTotal = $item->price * $item->quantity;
                            $grandTotal += $lineTotal;
                        @endphp
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>₹ {{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹ {{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-end mt-3">
        <h5>
            Grand Total:
            <span class="badge bg-success">
                ₹ {{ number_format($grandTotal, 2) }}
            </span>
        </h5>
    </div>
@endif
@endsection
