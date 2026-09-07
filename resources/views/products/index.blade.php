@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-header-title">Product List</h3>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-purple me-2">
                <i class="fa fa-plus"></i> Add Product
            </a>
            <a href="{{ url('/') }}" class="btn btn-secondary">
                <i class="fa fa-home"></i> Home Page
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-custom mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold">Brand</label>
                <select class="form-select">
                    <option value="">All Brand</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Category</label>
                <select class="form-select">
                    <option value="">All Category</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Status</label>
                <select class="form-select">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-purple w-100">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </div>
    </div>

    <div class="card-custom">
        <div class="table-responsive">
            <table id="productTable" class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>S/L</th>
                        <th>Code</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->code ?? '5100000001' }}</td>
                            <td>{{ $product->brand->name ?? 'Artisan' }}</td>
                            <td>{{ $product->category->name ?? 'Clothing' }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->unit ?? 'Pcs' }}</td>
                            <td>
                                <span class="badge {{ ($product->status ?? 1) ? 'bg-success' : 'bg-danger' }}">
                                    {{ ($product->status ?? 1) ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('products.show', $product->id) }}">
                                                <i class="fa fa-eye text-info me-2"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                                <i class="fa fa-edit text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa fa-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof jQuery !== 'undefined') {
            $(document).ready(function() {
                if (!$.fn.DataTable.isDataTable('#productTable')) {
                    $('#productTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copy', className: 'btn btn-purple btn-sm' },
                            { extend: 'csv', className: 'btn btn-purple btn-sm', title: 'Product_List', text: 'Export to CSV' },
                            { extend: 'excel', className: 'btn btn-purple btn-sm', title: 'Product_List', text: 'Export to Excel' },
                            { extend: 'print', className: 'btn btn-purple btn-sm' },
                            { extend: 'colvis', className: 'btn btn-purple btn-sm', text: 'Column visibility' }
                        ]
                    });
                }
            });
        }
    });

    
</script>
@endsection