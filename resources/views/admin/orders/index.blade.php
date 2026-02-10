@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4"> Orders</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User ID</th>
                        <th>Total</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user_id }}</td>
                        <td>₹ {{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ $order->total_quantity }}</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No Orders Found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
