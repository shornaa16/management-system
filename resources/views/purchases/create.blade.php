@extends('layouts.app')

@section('content')
<h2 class="page-header-title">Purchase Create</h2>

<form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
    @csrf
    <div class="row">
        <!-- Left Column: Product Table -->
        <div class="col-md-8">
            <div class="card card-custom p-3 shadow-sm">
                <div class="border-bottom pb-2 mb-3 fw-bold text-muted">Product Information</div>
                
                <div class="row g-2 mb-3 align-items-end">
                    <div class="col-md-5">
                        <label class="fw-bold required">Product</label>
                        <select id="product_select" class="form-select">
                            <option value="">Search Name of Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-name="{{ $product->name }}"
                                        data-brand="{{ $product->brand->name ?? 'Artisan' }}"
                                        data-category="{{ $product->category->name ?? 'Clothing' }}"
                                        data-code="{{ $product->code ?? '5100000001' }}"
                                        data-unit="{{ $product->unit ?? 'Pcs' }}">
                                    Brand: {{ $product->brand->name ?? 'Artisan' }} - Category: {{ $product->category->name ?? 'Clothing' }} - {{ $product->name }} - {{ $product->unit ?? 'Pcs' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold required">Qty</label>
                        <input type="number" id="temp_qty" class="form-control" placeholder="Qty" min="1">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold required">Unit Price</label>
                        <input type="number" id="temp_price" class="form-control" placeholder="Unit Price" step="0.01">
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="addItemBtn" class="btn btn-purple w-100"><i class="fa fa-plus"></i></button>
                    </div>
                </div>

                <table class="table table-bordered text-center align-middle" id="itemsTable">
                    <thead class="table-light">
                        <tr>
                            <th>S/L</th>
                            <th>Item Details</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end">Total</td>
                            <td id="grandQty">0</td>
                            <td></td>
                            <td id="grandTotal">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-purple px-4">Save</button>
                    <a href="{{ route('purchases.index') }}" class="btn btn-danger-custom px-4">Cancel</a>
                </div>
            </div>
        </div>

        <!-- Right Column: Other Info -->
        <div class="col-md-4">
            <div class="card card-custom p-3 shadow-sm">
                <div class="border-bottom pb-2 mb-3 fw-bold text-muted">Other Information</div>
                
                <div class="mb-3">
                    <label class="fw-bold required">Date</label>
                    <input type="date" name="purchase_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold required">Supplier</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">Search Name of Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Enter Notes"></textarea>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
let rowCount = 0;

$('#addItemBtn').click(function() {
    let opt = $('#product_select option:selected');
    let pId = opt.val();
    let pName = opt.data('name');
    let brand = opt.data('brand');
    let category = opt.data('category');
    let unit = opt.data('unit');
    let qty = parseFloat($('#temp_qty').val()) || 0;
    let price = parseFloat($('#temp_price').val()) || 0;

    if(!pId || qty <= 0 || price <= 0) {
        alert('Please select product, qty and price correctly!');
        return;
    }

    rowCount++;
    let total = qty * price;
    let html = `
        <tr id="row_${rowCount}">
            <td>${rowCount}</td>
            <td class="text-start">Brand: ${brand} - Category: ${category} - ${pName} - ${unit}</td>
            <td style="width: 90px;"><input type="number" name="items[${rowCount}][qty]" class="form-control text-center item-qty" value="${qty}" onchange="updateRow(${rowCount})"></td>
            <td style="width: 110px;"><input type="number" name="items[${rowCount}][price]" class="form-control text-center item-price" value="${price}" step="0.01" onchange="updateRow(${rowCount})"></td>
            <td class="item-total">${total.toFixed(2)}</td>
            <input type="hidden" name="items[${rowCount}][product_id]" value="${pId}">
            <td><button type="button" class="btn btn-sm btn-danger-custom" onclick="removeRow(${rowCount})"><i class="fa fa-trash"></i></button></td>
        </tr>
    `;

    $('#itemsTable tbody').append(html);
    calculateGrandTotal();
    $('#temp_qty, #temp_price').val('');
    $('#product_select').val('');
});

function removeRow(id) {
    $('#row_' + id).remove();
    calculateGrandTotal();
}

function updateRow(id) {
    let row = $('#row_' + id);
    let qty = parseFloat(row.find('.item-qty').val()) || 0;
    let price = parseFloat(row.find('.item-price').val()) || 0;
    row.find('.item-total').text((qty * price).toFixed(2));
    calculateGrandTotal();
}

function calculateGrandTotal() {
    let totalQty = 0;
    let grandTotal = 0;
    
    $('.item-qty').each(function() { totalQty += parseFloat($(this).val()) || 0; });
    $('.item-total').each(function() { grandTotal += parseFloat($(this).text()) || 0; });

    $('#grandQty').text(totalQty);
    $('#grandTotal').text(grandTotal.toFixed(2));
}
</script>
@endpush
@endsection