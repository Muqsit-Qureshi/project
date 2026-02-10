@extends('layouts.admin')

@section('content')
<h3 class="mb-4">Add New Product</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Images</label>
                <input type="file" name="images[]" multiple class="form-control">
                <small class="text-muted">
                    Hold <b>Ctrl</b> (Windows) or <b>Cmd</b> (Mac) to select multiple images
                </small>
            </div>

            <button class="btn btn-success">Save Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary ms-2">
                Back
            </a>
        </form>
    </div>
</div>
@endsection
