@extends('layouts.app')

@section('title', '404 - Page Not Found')
@section('page-title', '404 - Not Found')

@section('content')
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
        <h2 class="mt-3 fw-bold text-brand">404 - Page Not Found</h2>
        <p class="text-muted">The page you are looking for could not be found. It may have been moved, removed, renamed, or never existed.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-brand mt-3">
            <i class="bi bi-house me-1"></i> Go to Dashboard
        </a>
    </div>
</div>
@endsection
