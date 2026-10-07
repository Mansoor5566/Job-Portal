<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — JobPortal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="sidebar" id="sidebar">
    <a href="{{ route('home') }}" class="sidebar-logo">
        <i class="ti ti-shield"></i> Admin Panel
    </a>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="ti ti-chart-bar"></i> Dashboard
        </a>

        <div class="sidebar-section">Manage</div>
        <a href="{{ route('admin.users.index') }}"
           class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="ti ti-users"></i> Users
           @php $newUsers = \App\Models\User::where('created_at','>=',now()->subDay())->count(); @endphp
            @if($newUsers > 0)
                <span class="nav-badge">{{ $newUsers }}</span>
            @endif
        </a>
        <a href="{{ route('admin.jobs.index') }}"
           class="nav-item {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
            <i class="ti ti-briefcase"></i> Jobs
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="ti ti-tag"></i> Categories
        </a>

        <div class="sidebar-section">Portal</div>
        <a href="{{ route('home') }}" target="_blank" class="nav-item">
            <i class="ti ti-external-link"></i> View Site
        </a>
    </nav>
    <div style="padding:16px 20px; border-top:1px solid rgba(255,255,255,0.1);">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
            <div>
                <div style="font-size:12px;color:#fff;font-weight:500;">{{ auth()->user()->name }}</div>
                <div style="font-size:11px;color:#a5b4fc;">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:#a5b4fc;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:8px;width:100%;">
                <i class="ti ti-logout" style="font-size:16px;"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>

<div class="main">
    <div class="topbar">
        <div style="display:flex;align-items:center;gap:12px;">
            <button class="hamburger" onclick="toggleSidebar()" aria-label="Toggle menu">
                <i class="ti ti-menu-2" style="font-size:22px;"></i>
            </button>
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <span style="font-size:12px;background:#ede9fe;color:#6d28d9;padding:4px 10px;border-radius:50px;font-weight:500;">
                <i class="ti ti-shield" style="font-size:11px;"></i> Admin
            </span>
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

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('open');
}
</script>
</body>
</html>