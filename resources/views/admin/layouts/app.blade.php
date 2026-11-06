<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | 1000 Hills Rugby</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('head')
</head>
<body class="admin-body">
@php($admin = auth()->user())
<div class="admin-topbar py-1 d-none d-lg-block">
    <div class="container-fluid px-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-shield-check me-1"></i>Club administration</span>
        <span>
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="text-white text-decoration-none me-3"><i class="bi bi-box-arrow-up-right me-1"></i>View website</a>
            <span class="opacity-50">{{ now()->format('l, d M Y') }}</span>
        </span>
    </div>
</div>

<div class="d-flex">
    <aside class="admin-sidebar d-none d-lg-flex flex-column flex-shrink-0" style="width: 250px;">
        <div class="p-3 border-bottom" style="border-color:rgba(255,255,255,.08)!important;">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <img src="{{ site_logo() }}" alt="1000 Hills Rugby" style="height:40px;">
                <span class="admin-brand-text">
                    <span class="admin-brand-name text-white" style="font-size:.95rem;">1000 Hills Rugby</span>
                    <span class="admin-brand-sub" style="color:rgba(255,255,255,.45);">Admin panel</span>
                </span>
            </a>
        </div>
        <nav class="nav flex-column py-2 flex-grow-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>

            <p class="admin-sidebar-heading">Content</p>
            <a class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}" href="{{ route('admin.articles.index') }}"><i class="bi bi-newspaper"></i>News articles</a>
            <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}"><i class="bi bi-calendar-event"></i>Events</a>
            <a class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" href="{{ route('admin.schedules.index') }}"><i class="bi bi-calendar-week"></i>Weekly schedule</a>
            <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}"><i class="bi bi-file-earmark-text"></i>Website pages</a>
            <a class="nav-link {{ request()->routeIs('admin.resources.*') ? 'active' : '' }}" href="{{ route('admin.resources.index') }}"><i class="bi bi-folder2-open"></i>Resources</a>

            <p class="admin-sidebar-heading">Rugby</p>
            <a class="nav-link {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}" href="{{ route('admin.teams.index') }}"><i class="bi bi-people"></i>Teams</a>
            <a class="nav-link {{ request()->routeIs('admin.players.*') ? 'active' : '' }}" href="{{ route('admin.players.index') }}"><i class="bi bi-person-badge"></i>Players</a>
            <a class="nav-link {{ request()->routeIs('admin.fixtures.*') ? 'active' : '' }}" href="{{ route('admin.fixtures.index') }}"><i class="bi bi-calendar2-check"></i>Fixtures &amp; results</a>
            <a class="nav-link {{ request()->routeIs('admin.standings.*') ? 'active' : '' }}" href="{{ route('admin.standings.index') }}"><i class="bi bi-bar-chart-line"></i>League standings</a>
            <a class="nav-link {{ request()->routeIs('admin.competitions.*') ? 'active' : '' }}" href="{{ route('admin.competitions.index') }}"><i class="bi bi-trophy"></i>Competitions</a>
            <a class="nav-link {{ request()->routeIs('admin.seasons.*') ? 'active' : '' }}" href="{{ route('admin.seasons.index') }}"><i class="bi bi-calendar3"></i>Seasons</a>
            <a class="nav-link {{ request()->routeIs('admin.clubs.*') ? 'active' : '' }}" href="{{ route('admin.clubs.index') }}"><i class="bi bi-shield"></i>Clubs</a>
            <a class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}" href="{{ route('admin.staff.index') }}"><i class="bi bi-person-workspace"></i>Staff &amp; coaches</a>
            <a class="nav-link {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}" href="{{ route('admin.sponsors.index') }}"><i class="bi bi-hand-thumbs-up"></i>Sponsors</a>

            <p class="admin-sidebar-heading">Community</p>
            <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                <i class="bi bi-envelope"></i>Messages
                @if(($unreadCount ?? 0) > 0)<span class="badge bg-warning text-dark ms-auto">{{ $unreadCount }}</span>@endif
            </a>
            <a class="nav-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}" href="{{ route('admin.donations.index') }}"><i class="bi bi-heart"></i>Donations</a>
            <a class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}" href="{{ route('admin.subscribers.index') }}"><i class="bi bi-envelope-paper"></i>Subscribers</a>

            @if($admin?->isAdmin())
                <p class="admin-sidebar-heading">Administration</p>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people-fill"></i>Users</a>
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}"><i class="bi bi-gear"></i>Site settings</a>
                <a class="nav-link {{ request()->routeIs('admin.activity.*') ? 'active' : '' }}" href="{{ route('admin.activity.index') }}"><i class="bi bi-clock-history"></i>Activity log</a>
            @endif
        </nav>
        <div class="p-3 border-top" style="border-color:rgba(255,255,255,.08)!important;">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm w-100" type="submit"><i class="bi bi-box-arrow-right me-1"></i>Sign out</button>
            </form>
        </div>
    </aside>

    <div class="flex-grow-1 min-vw-0">
        <nav class="navbar admin-navbar px-3 px-lg-4 py-2 sticky-top">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileNav" aria-label="Open navigation"><i class="bi bi-list"></i></button>
                <div class="d-lg-none">
                    <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                        <img src="{{ site_logo() }}" alt="" style="height:34px;">
                        <span class="admin-brand-name" style="font-size:.9rem;">1000 Hills Rugby</span>
                    </a>
                </div>
                <div class="d-none d-lg-block">
                    <div class="fw-semibold">@yield('page_title', 'Dashboard')</div>
                    <div class="text-muted small">@yield('page_subtitle', 'Manage your club website')</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm d-none d-md-inline-flex"><i class="bi bi-box-arrow-up-right me-1"></i>Website</a>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm d-flex align-items-center gap-2 border" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="rounded-circle bg-success text-white d-grid" style="width:30px;height:30px;place-items:center;font-size:.72rem;font-weight:700;">{{ $admin?->initials() }}</span>
                        <span class="d-none d-md-inline">{{ $admin?->name }}</span>
                        <i class="bi bi-chevron-down small"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><span class="dropdown-item-text small text-muted">{{ $admin?->email }}<br>{{ ucfirst($admin?->role ?? '') }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        @if($admin?->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.settings.edit') }}"><i class="bi bi-gear me-2"></i>Site settings</a></li>
                        @endif
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Sign out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="admin-content">
            @include('admin.partials.flash')
            @yield('content')
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="adminMobileNav" style="background:var(--ad-forest-900)!important; max-width:290px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand text-white">
            <img src="{{ site_logo() }}" alt="" style="height:38px;">
            <span class="admin-brand-name text-white">1000 Hills Rugby</span>
        </a>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="nav flex-column py-2">
            <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
            <p class="admin-sidebar-heading">Content</p>
            <a class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}" href="{{ route('admin.articles.index') }}"><i class="bi bi-newspaper"></i>News articles</a>
            <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}"><i class="bi bi-calendar-event"></i>Events</a>
            <a class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" href="{{ route('admin.schedules.index') }}"><i class="bi bi-calendar-week"></i>Weekly schedule</a>
            <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}"><i class="bi bi-file-earmark-text"></i>Website pages</a>
            <a class="nav-link {{ request()->routeIs('admin.resources.*') ? 'active' : '' }}" href="{{ route('admin.resources.index') }}"><i class="bi bi-folder2-open"></i>Resources</a>
            <p class="admin-sidebar-heading">Rugby</p>
            <a class="nav-link {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}" href="{{ route('admin.teams.index') }}"><i class="bi bi-people"></i>Teams</a>
            <a class="nav-link {{ request()->routeIs('admin.players.*') ? 'active' : '' }}" href="{{ route('admin.players.index') }}"><i class="bi bi-person-badge"></i>Players</a>
            <a class="nav-link {{ request()->routeIs('admin.fixtures.*') ? 'active' : '' }}" href="{{ route('admin.fixtures.index') }}"><i class="bi bi-calendar2-check"></i>Fixtures &amp; results</a>
            <a class="nav-link {{ request()->routeIs('admin.standings.*') ? 'active' : '' }}" href="{{ route('admin.standings.index') }}"><i class="bi bi-bar-chart-line"></i>League standings</a>
            <a class="nav-link {{ request()->routeIs('admin.competitions.*') ? 'active' : '' }}" href="{{ route('admin.competitions.index') }}"><i class="bi bi-trophy"></i>Competitions</a>
            <a class="nav-link {{ request()->routeIs('admin.seasons.*') ? 'active' : '' }}" href="{{ route('admin.seasons.index') }}"><i class="bi bi-calendar3"></i>Seasons</a>
            <a class="nav-link {{ request()->routeIs('admin.clubs.*') ? 'active' : '' }}" href="{{ route('admin.clubs.index') }}"><i class="bi bi-shield"></i>Clubs</a>
            <a class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}" href="{{ route('admin.staff.index') }}"><i class="bi bi-person-workspace"></i>Staff &amp; coaches</a>
            <a class="nav-link {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}" href="{{ route('admin.sponsors.index') }}"><i class="bi bi-hand-thumbs-up"></i>Sponsors</a>
            <p class="admin-sidebar-heading">Community</p>
            <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}"><i class="bi bi-envelope"></i>Messages</a>
            <a class="nav-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}" href="{{ route('admin.donations.index') }}"><i class="bi bi-heart"></i>Donations</a>
            <a class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}" href="{{ route('admin.subscribers.index') }}"><i class="bi bi-envelope-paper"></i>Subscribers</a>
            @if($admin?->isAdmin())
                <p class="admin-sidebar-heading">Administration</p>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people-fill"></i>Users</a>
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}"><i class="bi bi-gear"></i>Site settings</a>
                <a class="nav-link {{ request()->routeIs('admin.activity.*') ? 'active' : '' }}" href="{{ route('admin.activity.index') }}"><i class="bi bi-clock-history"></i>Activity log</a>
            @endif
        </nav>
    </div>
</div>

<script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
