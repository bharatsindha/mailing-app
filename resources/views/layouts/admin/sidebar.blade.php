<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        <div
            class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="{{ asset('img/profile.png') }}" class="card-img-top rounded-circle border-white"
                         alt="Bonnie Green">
                </div>
                <div class="d-block">
                    <h2 class="h5 mb-3">Hi, {{ auth()->user()->name }}</h2>
                    <a href="{{ route('logout') }}" class="btn btn-secondary btn-sm d-inline-flex align-items-center"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        @include('icons.sign-out')
                        Sign Out
                    </a>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse"
                   data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true"
                   aria-label="Toggle navigation">
                    @include('icons.toggle')
                </a>
            </div>
        </div>
        <ul class="nav flex-column pt-3 pt-md-0">
            <li class="nav-item">
                <a href="#" class="nav-link d-flex align-items-center">
                    <span class="sidebar-icon">
                    <img src="{{ asset('img/logo.png') }}" height="20" width="20"
                         alt="Volt Logo">
                    </span>
                    <span class="mt-1 ms-1 sidebar-text">{{ strtoupper(env('APP_NAME') )  }}</span>
                </a>
            </li>
            <li class="nav-item  {{ (request()->is('dashboard') || request()->is('dashboard/*')) ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="sidebar-icon">
                        @include('icons.dashboard')
                    </span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('users') || request()->is('users/*')) ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <span class="sidebar-icon">
                        @include('icons.users')
                    </span>
                    <span class="sidebar-text">Users</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
