<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/admin/dashboard" wire:navigate>Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/admin/dashboard" wire:navigate>Ad</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><a class="nav-link" href="/admin/dashboard" wire:navigate><i class="fa fa-fire"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">Starter</li>
            <li class="dropdown {{ Request::is('admin/sliders*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-sliders-h"></i>
                    <span>Sliders</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/sliders/create') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/sliders/create" wire:navigate>
                            Create Slider
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/sliders') ? 'active' : '' }}">
                        <a class="nav-link" href="/admin/sliders" wire:navigate>
                            List Slider
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
