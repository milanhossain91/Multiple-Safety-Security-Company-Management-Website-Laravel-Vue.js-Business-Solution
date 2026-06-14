        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="sidebar-brand-text mx-2">ATSL CMS</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="{{ Request::is('dashboard') ? 'nav-link active' : 'nav-link' }}" href="{{ url('/dashboard') }}">
                    <i class="fas fa-fw fa-gauge-high"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Content</div>

            <li class="nav-item">
                <a class="{{ Request::is('admin/pages*') ? 'nav-link active' : 'nav-link' }}" href="{{ url('/admin/pages') }}">
                    <i class="fas fa-fw fa-file-lines"></i>
                    <span>Pages</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Request::is('admin/posts*') || Request::is('admin/post-categories*') ? 'nav-link active' : 'nav-link' }}" href="{{ url('/admin/posts') }}">
                    <i class="fas fa-fw fa-newspaper"></i>
                    <span>Blog</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Request::is('admin/menus*') ? 'nav-link active' : 'nav-link' }}" href="{{ url('/admin/menus') }}">
                    <i class="fas fa-fw fa-bars-staggered"></i>
                    <span>Menus</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">System</div>

            <li class="nav-item">
                <a class="{{ Request::is('admin/users*') ? 'nav-link active' : 'nav-link' }}" href="{{ url('/admin/users') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Request::is('admin/settings*') ? 'nav-link active' : 'nav-link' }}" href="{{ url('/admin/settings') }}">
                    <i class="fas fa-fw fa-gear"></i>
                    <span>Site Settings</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item">
                <a class="nav-link" target="_blank" href="{{ url('/') }}">
                    <i class="fas fa-fw fa-up-right-from-square"></i>
                    <span>View Website</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/logout') }}">
                    <i class="fas fa-fw fa-right-from-bracket"></i>
                    <span>Logout</span></a>
            </li>

        </ul>
