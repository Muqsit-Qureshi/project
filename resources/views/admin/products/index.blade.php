@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Product List</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        + Add Product
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Images</th>
                    <th width="180">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>₹ {{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $product->images->count() }} Images
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.show', $product->id) }}"
                               class="btn btn-sm btn-info">
                                View
                            </a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this product?')"
                                        class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            No products found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
