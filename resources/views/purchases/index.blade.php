@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Purchase Orders</h3>
</div>

<div class="card p-3 shadow-sm mb-4">
    <a href="{{ route('purchases.create') }}" class="btn btn-purple text-white mb-3" style="width: fit-content;">
        Create Purchase +
    </a>

    <!-- Search & Filter Form -->
    <form action="{{ route('purchases.index') }}" method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label class="form-label fw-bold">Supplier <span class="text-danger">*</span></label>
            <select name="supplier_id" class="form-select">
                <option value="">All Supplier</option>
                @foreach($suppliers ?? [] as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
            <input type="date" name="start_date" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold">End Date <span class="text-danger">*</span></label>
            <input type="date" name="end_date" class="form-control">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-purple text-white w-100">Search</button>
        </div>
    </form>

    <!-- Table Header Actions -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-purple btn-sm">Copy</button>
            <button class="btn btn-purple btn-sm">Export to CSV</button>
            <button class="btn btn-purple btn-sm">Export to Excel</button>
            <button class="btn btn-purple btn-sm">Print</button>
            <button class="btn btn-purple btn-sm dropdown-toggle" data-bs-toggle="dropdown">Column visibility</button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Order No.</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $grandTotal = 0; 
                    $grandPaid = 0; 
                    $grandDue = 0; 
                @endphp
                @forelse($purchases as $purchase)
                    @php
                        $grandTotal += $purchase->total ?? $purchase->due;
                        $grandPaid += $purchase->paid ?? 0;
                        $grandDue += $purchase->due;
                    @endphp
                    <tr>
                        <td>{{ $purchase->order_no }}</td>
                        <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}</td>
                        <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
                        <td class="text-primary fw-bold">{{ number_format($purchase->total ?? $purchase->due, 2) }}</td>
                        <td>{{ number_format($purchase->paid ?? 0, 2) }}</td>
                        <td>{{ number_format($purchase->due, 2) }}</td>
                        <td><span class="badge bg-success">Received</span></td>
                        <td>{{ $purchase->notes }}</td>
                        <td>
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-sm btn-light border">
                                <i class="fa fa-ellipsis-v"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No purchases found.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="fw-bold table-light">
                    <td colspan="3" class="text-center">Total</td>
                    <td>{{ number_format($grandTotal, 2) }}</td>
                    <td>{{ number_format($grandPaid, 2) }}</td>
                    <td>{{ number_format($grandDue, 2) }}</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection