@extends('layouts.app')

@section('title', 'Database Error')
@section('page-title', 'Database Error')

@section('content')
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-database-exclamation text-danger" style="font-size: 4rem;"></i>
        <h2 class="mt-3 fw-bold text-brand">Database Error</h2>
        <p class="text-muted">We encountered an issue while communicating with the database. Please try again later or contact the administrator if the problem persists.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-brand mt-3">
            <i class="bi bi-house me-1"></i> Go to Dashboard
        </a>
    </div>
</div>
@endsection
