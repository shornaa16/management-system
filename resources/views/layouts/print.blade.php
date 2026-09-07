<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <style>
        /* Inline minimal Bootstrap-equivalent CSS for print view (avoids asset build dependencies on print page) */
        @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #2d2d3a; background: #fff; padding: 30px; }
        .invoice-header { border-bottom: 2px solid #6c5ce7; padding-bottom: 12px; margin-bottom: 20px; }
        .text-brand { color: #6c5ce7; }
        .table > :not(caption) > * > * { padding: .55rem .6rem; }
        @media print { .no-print { display: none !important; } body { padding: 0; } }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
