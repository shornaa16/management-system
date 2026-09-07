<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'mobile_no' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:191'],
            'address' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:Active,Inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The supplier name is required.',
            'mobile_no.required' => 'The mobile number is required.',
            'email.email' => 'Please enter a valid email address.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.',
        ];
    }
}
