@extends('layouts.app')

@section('title', '500 - Server Error')
@section('page-title', 'Server Error')

@section('content')
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-exclamation-octagon text-danger" style="font-size: 4rem;"></i>
        <h2 class="mt-3 fw-bold text-brand">500 - Server Error</h2>
        <p class="text-muted">Something went wrong on our end. Please try again later.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-brand mt-3">
            <i class="bi bi-house me-1"></i> Go to Dashboard
        </a>
    </div>
</div>
@endsection
