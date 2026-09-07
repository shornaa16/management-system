@php
    $currentRoute = Route::currentRouteName() ?? '';
    $navItems = [
        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'bi-speedometer2'],
        ['route' => 'suppliers.index', 'label' => 'Suppliers', 'icon' => 'bi-people'],
        ['route' => 'products.index', 'label' => 'Products', 'icon' => 'bi-box-seam'],
        ['route' => 'purchases.index', 'label' => 'Purchase Orders', 'icon' => 'bi-cart3'],
    ];
@endphp
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="brand-logo"><i class="bi bi-bag-check-fill"></i></span>
        <span>SupplierPurchase<br><small class="text-muted" style="font-size:.7rem;letter-spacing:.6px;">ADMIN PANEL</small></span>
    </div>

    <div class="sidebar-nav">
        <div class="nav-section-title">Main Menu</div>
        <ul class="nav flex-column">
            @foreach ($navItems as $item)
                @php
                    $active = str_starts_with($currentRoute, explode('.', $item['route'])[0]);
                @endphp
                <li class="nav-item">
                    <a href="{{ route($item['route']) }}" class="nav-link {{ $active ? 'active' : '' }}">
                        <i class="bi {{ $item['icon'] }}"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="nav-section-title mt-4">Account</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <form method="post" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit(); return false;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>
<div class="sidebar-backdrop"></div>
