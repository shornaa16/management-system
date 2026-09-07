@extends('layouts.app')

@section('title', 'Edit Product - ' . config('app.name'))
@section('page-title', 'Edit Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0 fw-semibold text-brand">Edit Product</h4>
        <p class="text-muted small mb-0">Update product information for <strong>{{ $product->name }}</strong></p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil-square me-1"></i> Product Information
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('products.update', $product) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Active" {{ old('status', $product->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $product->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-brand">
                            <i class="bi bi-check-lg me-1"></i> Update Product
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history me-1"></i> Record Info
            </div>
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Product ID:</span>
                    <span class="fw-semibold">#{{ $product->id }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Created:</span>
                    <span>{{ $product->created_at?->format('d M, Y H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Last Updated:</span>
                    <span>{{ $product->updated_at?->format('d M, Y H:i') }}</span>
                </div>
                @if ($product->purchaseItems()->exists())
                    <div class="alert alert-info py-2 mt-3 small">
                        <i class="bi bi-info-circle"></i>
                        Used in <strong>{{ $product->purchaseItems()->count() }}</strong> purchase order line item(s).
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
