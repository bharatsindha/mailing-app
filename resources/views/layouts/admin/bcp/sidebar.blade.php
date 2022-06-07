<nav id="sidebarMenu" class="sidebar d-md-block bg-primary text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        <div
            class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="user-avatar lg-avatar mr-4">
                    <img src="{{ asset('img/profile.png') }}" class="card-img-top rounded-circle border-white"
                         alt="Bonnie Green">
                </div>
                <div class="d-block">
                    <h2 class="h6">Hi, {{ auth()->user()->name }}</h2>
                    <a href="{{ route('logout') }}" class="btn btn-secondary text-dark btn-xs"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span
                            class="mr-2"><span class="fas fa-sign-out-alt"></span></span>Sign out</a>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" class="fas fa-times" data-toggle="collapse" data-target="#sidebarMenu"
                   aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation"></a>
            </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="sidebar-icon"><span class="fas fa-chart-pie"></span></span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('admin/track-orders') || request()->is('admin/track-orders/*')) ? 'active' : '' }}">
                <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                      data-toggle="collapse" data-target="#submenu-tracking">
                    <span><span class="sidebar-icon"><span class="fas fa-list"></span></span> Tracking Orders</span>
                    <span class="link-arrow"><span class="fas fa-chevron-right"></span></span>
                </span>
                <div class="multi-level collapse " role="list" id="submenu-tracking" aria-expanded="false">
                    <ul class="flex-column nav">
                        <li class="nav-item "><a class="nav-link" href="{{ route('admin.track-orders.index') }}"><span>All</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            @if(\App\Facades\General::isSuperAdmin())
                <li class="nav-item {{ (request()->is('admin/users') || request()->is('admin/users/*')) ? 'active' : '' }}">
                <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                      data-toggle="collapse" data-target="#submenu-users">
                    <span><span class="sidebar-icon"><span class="fa fa-user"></span></span> Users</span>
                    <span class="link-arrow"><span class="fas fa-chevron-right"></span></span>
                </span>
                    <div class="multi-level collapse " role="list" id="submenu-users" aria-expanded="false">
                        <ul class="flex-column nav">
                            <li class="nav-item "><a class="nav-link"
                                                     href="{{ route('admin.users.index') }}"><span>All</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>
