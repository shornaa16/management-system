@extends('layouts.app')

@section('content')
<div class="container bg-white p-4 shadow-sm rounded">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Product Details</h4>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-purple text-white me-2">
                <i class="fa fa-list"></i> Product List
            </a>
            <a href="{{ url('/') }}" class="btn btn-secondary">
                <i class="fa fa-home"></i> Home Page
            </a>
        </div>
    </div>

    <hr>

    <div class="row fs-5 g-3">
        <div class="col-md-6">
            <strong>Product Name:</strong> {{ $product->name }}
        </div>
        <div class="col-md-6">
            <strong>Status:</strong> 
            <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                {{ $product->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="col-md-6">
            <strong>Brand:</strong> {{ $product->brand->name ?? 'Artisan' }}
        </div>
        <div class="col-md-6">
            <strong>Category:</strong> {{ $product->category->name ?? 'Clothing' }}
        </div>
        <div class="col-md-6">
            <strong>Unit:</strong> {{ $product->unit ?? 'Pcs' }}
        </div>
        <div class="col-md-6">
            <strong>Code:</strong> {{ $product->code ?? '5100000001' }}
        </div>
    </div>
</div>
@endsection
