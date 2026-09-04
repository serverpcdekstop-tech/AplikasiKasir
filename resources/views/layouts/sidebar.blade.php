<!-- Brand -->
<div class="sidebar-brand">
    <div class="sidebar-brand-icon">✦</div>
    <div class="sidebar-brand-text">{{ config('app.name') }}<span></span></div>
</div>

<!-- Menu -->
<nav class="flex-grow-1 overflow-auto">
    <div class="sidebar-section-title">Main</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>
    </ul>

    <div class="sidebar-section-title mt-3">Management</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('pages.customer') }}"
                class="nav-link {{ request()->routeIs('pages.customer') ? 'active' : '' }}"><i class="bi
                    bi-tv"></i> Tampilan layar</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link"><i class="bi bi-people-fill"></i> Users</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pages.kategori') }}"
                class="nav-link {{ request()->routeIs('pages.kategori') ? 'active' : '' }}"><i
                    class="bi bi-card-list"></i>
                Categories</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pages.produk') }}"
                class="nav-link {{ request()->routeIs('pages.produk') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pages.order') }}"
                class="nav-link {{ request()->routeIs('pages.order') ? 'active' : '' }}"><i
                    class="bi bi-cart-fill"></i>
                Orders</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pages.payment') }}"
                class="nav-link {{ request()->routeIs('pages.payment') ? 'active' : '' }}"><i
                    class="bi bi-credit-card-fill"></i> Payments</a>
        </li>
    </ul>
</nav>

<!-- User -->
<div class="sidebar-user">
    <div class="sidebar-user-avatar">JD</div>
    <div class="flex-grow-1">
        <div class="sidebar-user-name">John Doe</div>
        <div class="sidebar-user-role">Administrator</div>
    </div>
    <div class="sidebar-user-online" title="Online"></div>
</div>
