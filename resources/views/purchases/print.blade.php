@extends('layouts.app')

@section('content')
<h2 class="page-header-title">Purchase Orders Details</h2>

<div class="card card-custom">
    <div class="mb-3">
        <button onclick="window.print()" class="btn btn-purple"><i class="fa fa-print"></i> Print</button>
    </div>

    <div class="p-3 border">
        <div class="row text-center fw-bold fs-5 mb-4">
            <div class="col-md-4">Supplier: {{ $purchase->supplier->name }}</div>
            <div class="col-md-4">ORDER NO. {{ $purchase->order_no }}</div>
            <div class="col-md-4">DATE: {{ date('d-m-Y', strtotime($purchase->date)) }}</div>
        </div>

        <table class="table table-bordered align-middle text-center">
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
                @foreach($purchase->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>Artisan</td>
                    <td>Clothing</td>
                    <td>{{ $item->product->name }}</td>
                    <td>5100000001</td>
                    <td>Pcs</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
                <tr class="fw-bold">
                    <td colspan="7" class="text-end">Total</td>
                    <td>{{ $purchase->items->sum('qty') }}</td>
                    <td>{{ number_format($purchase->total, 2) }}</td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="8" class="text-end">Payment</td>
                    <td>{{ number_format($purchase->paid, 2) }}</td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="8" class="text-end">Due</td>
                    <td>{{ number_format($purchase->due, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="row mt-5 text-center fw-bold pt-4">
            <div class="col-md-6">
                Warehouse<br>Created By
            </div>
            <div class="col-md-6">
                Checked By
            </div>
        </div>
    </div>
</div>
@endsection