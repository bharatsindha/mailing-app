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
                <a href="{{ route('home') }}" class="nav-link d-flex align-items-center">
                    <span class="sidebar-icon">
                    <img src="{{ asset('img/logo.png') }}" height="20" width="20"
                         alt="Volt Logo">
{{--                        <i class="fa-solid fa-envelope"></i>--}}
                    </span>
                    <span class="mt-1 ms-1 sidebar-text">{{ (env('APP_NAME'))  }}</span>
                </a>
            </li>
            {{--<li class="nav-item  {{ (request()->is('dashboard') || request()->is('dashboard/*')) ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="sidebar-icon">
                        @include('icons.dashboard')
                    </span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>--}}
            @if(\Illuminate\Support\Facades\Auth::user()->role == \Modules\User\Entities\User::ADMIN_ROLE)
                <li class="nav-item {{ (request()->is('domains') || request()->is('domains/*')) ? 'active' : '' }}">
                    <a href="{{ route('admin.domains.index') }}" class="nav-link">
                        <span class="sidebar-icon">
                            @include('icons.dashboard')
                        </span>
                        <span class="sidebar-text">Domains</span>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('emails') || request()->is('emails/*')) ? 'active' : '' }}">
                    <a href="{{ route('admin.emails.index') }}" class="nav-link">
                    <span class="sidebar-icon">
                        <i class="fa-solid fa-at"></i>
                    </span>
                        <span class="sidebar-text">Sender Emails</span>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <span
                    class="nav-link d-flex justify-content-between align-items-center {{ !(request()->is('mail/*') ) ? 'collapsed' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#submenu-pages"
                    aria-expanded="{{ (request()->is('mail/*') ) ? 'true' : 'false' }}">
                    <span>
                        <span class="sidebar-icon">
                            <i class="fa-solid fa-paper-plane"></i>
                        </span>
                        <span class="sidebar-text">Start Mail</span>
                    </span>
                    <span class="link-arrow">
                        @include('icons.arrow')
                    </span>
                </span>
                <div
                    class="multi-level collapse {{ (request()->is('mail/*') ) ? 'show' : '' }}"
                    role="list" id="submenu-pages" aria-expanded="{{ (request()->is('mail/*') ) ? 'true' : 'false' }}">
                    <ul class="flex-column nav">
                        <li class="nav-item {{ (request()->is('*/drafts') || request()->is('*/drafts/*')) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.drafts.index') }}">
                                <span class="sidebar-text-contracted">
                                    <span class="sidebar-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                </span>
                                <span class="sidebar-text">
                                    <span class="sidebar-icon"><i class="fa-solid fa-pen-to-square"></i></span> Drafts
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ (request()->is('*/bounceTrack') || request()->is('*/bounceTrack/*')) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.mail.bounceTrack') }}">
                                <span class="sidebar-text-contracted">
                                    <span class="sidebar-icon"><i class="fa-solid fa-filter"></i></span>
                                </span>
                                <span class="sidebar-text">
                                    <span class="sidebar-icon"><i class="fa-solid fa-filter"></i></span> Bounce Track
                                </span>
                            </a>
                        </li>
                        <li class="nav-item {{ (request()->is('*/sentReport') || request()->is('*/sentReport/*')) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.mail.sentReport') }}">
                                <span class="sidebar-text-contracted">
                                    <span class="sidebar-icon"><i class="fa-solid fa-table"></i></span>
                                </span>
                                <span class="sidebar-text">
                                    <span class="sidebar-icon"><i class="fa-solid fa-table"></i></span>Email Report
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @if(\Illuminate\Support\Facades\Auth::user()->role == \Modules\User\Entities\User::ADMIN_ROLE)
                <li class="nav-item {{ (request()->is('users') || request()->is('users/*')) ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <span class="sidebar-icon">
                        @include('icons.users')
                    </span>
                        <span class="sidebar-text">Users</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
