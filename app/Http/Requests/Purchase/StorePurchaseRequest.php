<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchase_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'paid' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', Rule::in(['Pending', 'Received', 'Cancelled'])],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.001'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'Please select a supplier.',
            'supplier_id.exists' => 'The selected supplier does not exist.',
            'purchase_date.required' => 'The purchase date is required.',
            'purchase_date.date' => 'Please enter a valid date.',
            'paid.numeric' => 'The paid amount must be a number.',
            'paid.min' => 'The paid amount cannot be negative.',
            'items.required' => 'Please add at least one product to the purchase order.',
            'items.min' => 'Please add at least one product to the purchase order.',
            'items.*.product_id.required' => 'Each line item must reference a product.',
            'items.*.product_id.exists' => 'One of the selected products does not exist.',
            'items.*.quantity.required' => 'Quantity is required for each line item.',
            'items.*.quantity.min' => 'Quantity must be greater than 0.',
            'items.*.unit_price.required' => 'Unit price is required for each line item.',
            'items.*.unit_price.min' => 'Unit price cannot be negative.',
        ];
    }
}
