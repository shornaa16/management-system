@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Suppliers</div>
                    <div class="stat-value">{{ $supplierCount }}</div>
                </div>
                <i class="bi bi-people-fill text-brand" style="font-size:2.4rem;opacity:.35;"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Products</div>
                    <div class="stat-value">{{ $productCount }}</div>
                </div>
                <i class="bi bi-box-seam-fill text-brand" style="font-size:2.4rem;opacity:.35;"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Purchase Orders</div>
                    <div class="stat-value">{{ $purchaseCount }}</div>
                </div>
                <i class="bi bi-cart-check-fill text-brand" style="font-size:2.4rem;opacity:.35;"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Total Purchases</div>
                    <div class="stat-value">৳{{ number_format($totalPurchaseAmount, 2) }}</div>
                </div>
                <i class="bi bi-cash-stack text-brand" style="font-size:2.4rem;opacity:.35;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up-arrow me-1"></i> Payment Summary</span>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Paid</span>
                    <span class="fw-semibold text-success">৳{{ number_format($totalPaid, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Due</span>
                    <span class="fw-semibold text-danger">৳{{ number_format($totalDue, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                    <span class="text-muted small">Total Purchase Value</span>
                    <span class="fw-bold text-brand">৳{{ number_format($totalPurchaseAmount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-1"></i> Recent Purchase Orders</span>
                <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-outline-brand">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="bg-brand-light">
                        <tr>
                            <th class="ps-3">Order #</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th class="text-end pe-3">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentPurchases as $purchase)
                            <tr>
                                <td class="ps-3 fw-semibold text-brand">
                                    <a href="{{ route('purchases.show', $purchase) }}" class="text-decoration-none">{{ $purchase->order_no }}</a>
                                </td>
                                <td>{{ $purchase->supplier->name ?? '—' }}</td>
                                <td>{{ $purchase->purchase_date->format('d M, Y') }}</td>
                                <td class="text-end pe-3">৳{{ number_format($purchase->subtotal, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No purchases yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-4">
        <div class="card text-decoration-none text-reset h-100">
            <a href="{{ route('suppliers.create') }}" class="text-decoration-none text-reset d-block p-3 text-center">
                <i class="bi bi-person-plus-fill text-brand" style="font-size:2rem;"></i>
                <div class="fw-semibold mt-2">Add New Supplier</div>
                <small class="text-muted">Register a new supplier</small>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-decoration-none text-reset h-100">
            <a href="{{ route('products.create') }}" class="text-decoration-none text-reset d-block p-3 text-center">
                <i class="bi bi-plus-square-fill text-brand" style="font-size:2rem;"></i>
                <div class="fw-semibold mt-2">Add New Product</div>
                <small class="text-muted">Create a product entry</small>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-decoration-none text-reset h-100">
            <a href="{{ route('purchases.create') }}" class="text-decoration-none text-reset d-block p-3 text-center">
                <i class="bi bi-bag-plus-fill text-brand" style="font-size:2rem;"></i>
                <div class="fw-semibold mt-2">Create Purchase Order</div>
                <small class="text-muted">Issue a new purchase order</small>
            </a>
        </div>
    </div>
</div>
@endsection
