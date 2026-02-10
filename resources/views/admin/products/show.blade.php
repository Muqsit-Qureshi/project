@extends('layouts.admin')

@section('content')
<h3 class="mb-3">{{ $product->name }}</h3>

<p>
    <strong>Price:</strong>
    ₹ {{ number_format($product->price, 2) }}
</p>

<hr>

<h5 class="mb-3">Product Images</h5>

<div class="row">
    @forelse($product->images as $image)
        <div class="col-md-3 mb-3">
            <img
                src="{{ asset('storage/' . $image->image_path) }}"
                class="img-fluid rounded border"
                alt="Product Image"
            >
        </div>
    @empty
        <p class="text-muted">No images available.</p>
    @endforelse
</div>

<a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">
    ← Back to Products
</a>
@endsection
