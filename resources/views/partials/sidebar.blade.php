<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" wire:navigate>Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}" wire:navigate>Ad</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.dashboard') }}" wire:navigate><i class="fa fa-fire"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">Starter</li>
            <li class="dropdown {{ Request::routeIs('admin.sliders.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-sliders-h"></i>
                    <span>Sliders</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.sliders.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.sliders.create') }}" wire:navigate>
                            Create Slider
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('admin.sliders.list') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.sliders.list') }}" wire:navigate>
                            List Slider
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown {{ Request::routeIs('admin.categories.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-sliders-h"></i>
                    <span>Categories</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.categories.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.categories.create') }}" wire:navigate>
                            Create Category
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('admin.categories.list') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.categories.list') }}" wire:navigate>
                            List Category
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown {{ Request::routeIs('admin.products.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-sliders-h"></i>
                    <span>Products</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.products.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.products.create') }}" wire:navigate>
                            Create Product
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('admin.products.list') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.products.list') }}" wire:navigate>
                            List Product
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
