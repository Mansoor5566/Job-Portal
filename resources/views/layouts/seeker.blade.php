<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobPortal') — JobPortal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/seeker.css') }}">
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-logo">
        <i class="ti ti-briefcase"></i> JobPortal
    </a>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Overview</div>
        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="ti ti-layout-dashboard"></i> Dashboard
        </a>

        <div class="sidebar-section">Jobs</div>
        <a href="{{ route('jobs.index') }}"
           class="nav-item {{ request()->routeIs('jobs.index') ? 'active' : '' }}">
            <i class="ti ti-search"></i> Browse Jobs
        </a>
        <a href="{{ route('seeker.applications') }}"
           class="nav-item {{ request()->routeIs('seeker.applications') ? 'active' : '' }}">
            <i class="ti ti-send"></i> My Applications
          @php
    $pendingApps = auth()->check() ? auth()->user()->applications()->where('status','applied')->count() : 0;
@endphp
            @if($pendingApps > 0)
                <span class="nav-badge">{{ $pendingApps }}</span>
            @endif
        </a>

        <div class="sidebar-section">Account</div>
        <a href="{{ route('seeker.profile.edit') }}"
           class="nav-item {{ request()->routeIs('seeker.profile.*') ? 'active' : '' }}">
            <i class="ti ti-user"></i> My Profile
        </a>
        <a href="{{ route('profile.edit') }}"
           class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="ti ti-settings"></i> Account Settings
        </a>
    </nav>
    <div style="padding:16px 20px; border-top:1px solid rgba(255,255,255,0.1);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:#93c5fd;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:8px;width:100%;">
                <i class="ti ti-logout" style="font-size:16px;"></i> Logout
            </button>
        </form>
    </div>
</div>

{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <div style="display:flex;align-items:center;gap:12px;">
            <button class="hamburger" onclick="toggleSidebar()" aria-label="Toggle menu">
                <i class="ti ti-menu-2" style="font-size:22px;"></i>
            </button>
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('jobs.index') }}" class="btn-primary" style="padding:7px 14px;font-size:12px;">
                <i class="ti ti-search" style="font-size:14px;"></i> Browse Jobs
            </a>
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#374151;">
                <div class="user-avatar">{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : '' }}</div>
                <span style="display:none;" class="user-name-lg">{{ auth()->check() ? auth()->user()->name : '' }}</span>
            </div>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert-success">
                <i class="ti ti-circle-check" style="font-size:16px;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error">
                <i class="ti ti-alert-circle" style="font-size:16px;"></i>
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>
</div>

<div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>
<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('open');
}
</script>
</body>
</html>