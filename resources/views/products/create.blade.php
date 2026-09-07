@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Create Product</h3>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="card p-4 shadow-sm border-0" style="max-width: 600px;">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label font-weight-bold">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Laptop / Keyboard">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">SKU / Code</label>
                <input type="text" name="sku" class="form-control" placeholder="e.g. PRD-1001">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="price" class="form-control" required placeholder="0.00">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Initial Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock_quantity" class="form-control" required value="0">
            </div>

            <button type="submit" class="btn btn-primary w-100" style="background-color: #6d28d9; border: none;">Save Product</button>
        </form>
    </div>
</div>
@endsection