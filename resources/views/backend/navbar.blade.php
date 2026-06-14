<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <span class="d-none d-sm-inline text-gray-500 small font-weight-bold">
        <i class="fas fa-layer-group mr-1 text-primary"></i> {{ \App\Models\Setting::get('site_name', 'ATSL') }} CMS
    </span>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto align-items-center">

        <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-light mr-3 d-none d-sm-inline-block">
            <i class="fas fa-up-right-from-square mr-1"></i> View Site
        </a>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-700 small font-weight-bold">{{ optional(auth()->user())->name ?? 'Admin' }}</span>
                <span class="topbar-avatar">{{ strtoupper(substr(optional(auth()->user())->name ?? 'A', 0, 1)) }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ url('/admin/users') }}">
                    <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i> Users
                </a>
                <a class="dropdown-item" href="{{ url('/admin/settings') }}">
                    <i class="fas fa-gear fa-sm fa-fw mr-2 text-gray-400"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
