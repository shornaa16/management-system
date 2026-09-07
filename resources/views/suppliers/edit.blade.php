@extends('layouts.app')

@section('title', 'Edit Supplier - ' . config('app.name'))
@section('page-title', 'Edit Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0 fw-semibold text-brand">Edit Supplier</h4>
        <p class="text-muted small mb-0">Update supplier information for <strong>{{ $supplier->name }}</strong></p>
    </div>
    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil-square me-1"></i> Supplier Information
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('suppliers.update', $supplier) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $supplier->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="mobile_no" class="form-label">Mobile No. <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_no" id="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror"
                                value="{{ old('mobile_no', $supplier->mobile_no) }}" required>
                            @error('mobile_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $supplier->email) }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Active" {{ old('status', $supplier->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $supplier->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $supplier->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-brand">
                            <i class="bi bi-check-lg me-1"></i> Update Supplier
                        </button>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clock-history me-1"></i> Record Info
            </div>
            <div class="card-body small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Supplier ID:</span>
                    <span class="fw-semibold">#{{ $supplier->id }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Created:</span>
                    <span>{{ $supplier->created_at?->format('d M, Y H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Last Updated:</span>
                    <span>{{ $supplier->updated_at?->format('d M, Y H:i') }}</span>
                </div>
                @if ($supplier->purchases()->exists())
                    <div class="alert alert-info py-2 mt-3 small">
                        <i class="bi bi-info-circle"></i>
                        This supplier has <strong>{{ $supplier->purchases()->count() }}</strong> purchase order(s) and cannot be deleted.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
