@extends('layouts.app')

@section('title', 'Create Supplier - ' . config('app.name'))
@section('page-title', 'Create Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0 fw-semibold text-brand">Create Supplier</h4>
        <p class="text-muted small mb-0">Add a new supplier record</p>
    </div>
    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-vcard me-1"></i> Supplier Information
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('suppliers.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="e.g. ABC Supplier" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="mobile_no" class="form-label">Mobile No. <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_no" id="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror"
                                value="{{ old('mobile_no') }}" placeholder="e.g. +8801712345678" required>
                            @error('mobile_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="supplier@example.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                placeholder="Enter full address">{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-brand">
                            <i class="bi bi-check-lg me-1"></i> Save Supplier
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
                <i class="bi bi-info-circle me-1"></i> Tips
            </div>
            <div class="card-body small text-muted">
                <p><strong class="text-brand">Required fields</strong> are marked with a red asterisk.</p>
                <p>The email field is optional but, if provided, must be a valid email address.</p>
                <p>Status can be toggled to <em>Inactive</em> if you wish to retire a supplier without deleting their record.</p>
            </div>
        </div>
    </div>
</div>
@endsection
