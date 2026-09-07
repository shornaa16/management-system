@extends('layouts.app')

@section('title', '403 - Forbidden')
@section('page-title', '403 - Forbidden')

@section('content')
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-shield-lock text-danger" style="font-size: 4rem;"></i>
        <h2 class="mt-3 fw-bold text-brand">403 - Forbidden</h2>
        <p class="text-muted">You do not have permission to access this page.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-brand mt-3">
            <i class="bi bi-house me-1"></i> Go to Dashboard
        </a>
    </div>
</div>
@endsection
