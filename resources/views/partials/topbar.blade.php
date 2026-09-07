<header class="topbar">
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" data-bs-toggle="sidebar" aria-label="Toggle navigation">
            <i class="bi bi-list fs-5"></i>
        </button>
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted small d-none d-md-inline">
            <i class="bi bi-calendar3"></i> {{ now()->format('d M, Y') }}
        </span>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="bg-brand text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;font-weight:600;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
                <span class="d-none d-md-inline text-dark small fw-semibold">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li class="px-3 py-2 small text-muted">
                    <i class="bi bi-envelope me-1"></i> {{ auth()->user()->email }}
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
