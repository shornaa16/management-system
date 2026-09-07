@extends('layouts.app')

@section('content')
<div class="container bg-white p-4 shadow-sm rounded">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Purchase Orders Details</h4>
        <div>
            <!-- Home Button -->
            <a href="{{ url('/') }}" class="btn btn-secondary me-2">
                <i class="fa fa-home"></i> Home Page
            </a>
            <!-- Print Button -->
            <button onclick="window.print()" class="btn btn-purple text-white">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>

    <hr>

    <!-- Header Info -->
    <div class="d-flex justify-content-between fw-bold my-4 fs-5">
        <div>Supplier: <span class="fw-normal">{{ $purchase->supplier->name ?? 'N/A' }}</span></div>
        <div>ORDER NO. <span class="fw-normal">{{ $purchase->order_no }}</span></div>
        <div>DATE: <span class="fw-normal">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-m-Y') }}</span></div>
    </div>

    <!-- Purchase Items Table -->
    <table class="table table-bordered text-center align-middle border-dark">
        <thead>
            <tr>
                <th>S/L</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Product</th>
                <th>Code</th>
                <th>Unit</th>
                <th>Pur. Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @php $totalQty = 0; @endphp
            @foreach($purchase->items as $index => $item)
                @php $totalQty += $item->qty; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->brand->name ?? 'Artisan' }}</td>
                    <td>{{ $item->product->category->name ?? 'Clothing' }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->product->code ?? '5100000001' }}</td>
                    <td>{{ $item->product->unit ?? 'Pcs' }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
            <tr class="fw-bold">
                <td colspan="7" class="text-end">Total</td>
                <td>{{ $totalQty }}</td>
                <td>{{ number_format($purchase->total ?? $purchase->due, 2) }}</td>
            </tr>
            <tr class="fw-bold">
                <td colspan="8" class="text-end">Payment</td>
                <td>{{ number_format($purchase->paid ?? 0, 2) }}</td>
            </tr>
            <tr class="fw-bold">
                <td colspan="8" class="text-end">Due</td>
                <td>{{ number_format($purchase->due, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Signatures -->
    <div class="row mt-5 text-center fw-bold" style="padding-top: 50px;">
        <div class="col-6">
            <p>Warehouse</p>
            <p class="mt-4">Created By</p>
        </div>
        <div class="col-6">
            <p class="mt-5">Checked By</p>
        </div>
    </div>
</div>
@endsection