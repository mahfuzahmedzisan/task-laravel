<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin.dashboard') }}" class="logo text-white">
                {{ __(auth('admin')->user()->name) }} {{ __('Dashboard') }}
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('c.category.index') }}">
                        <i class="fas fa-cog"></i>
                        <p>{{ __('Category Management') }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pm.product.index') }}">
                        <i class="icon-settings"></i>
                        <p>{{ __('Product Management') }}</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
