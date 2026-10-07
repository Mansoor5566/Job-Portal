<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Employer') — JobPortal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/employer.css') }}">
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-logo">
            <i class="ti ti-briefcase"></i> JobPortal
        </a>
        <nav class="sidebar-nav">
            <div class="sidebar-section">Overview</div>
            <a href="{{ route('employer.analytics') }}"
                class="nav-item {{ request()->routeIs('employer.analytics') ? 'active' : '' }}">
                <i class="ti ti-chart-bar"></i> Analytics
            </a>

            <div class="sidebar-section">Jobs</div>
            <a href="{{ route('employer.jobs.index') }}"
                class="nav-item {{ request()->routeIs('employer.jobs.index') ? 'active' : '' }}">
                <i class="ti ti-list"></i> My Listings
            </a>
            <a href="{{ route('employer.jobs.create') }}"
                class="nav-item {{ request()->routeIs('employer.jobs.create') ? 'active' : '' }}">
                <i class="ti ti-plus"></i> Post a Job
            </a>

            <div class="sidebar-section">Candidates</div>
            <a href="{{ route('employer.applications.index') }}"
                class="nav-item {{ request()->routeIs('employer.applications.*') ? 'active' : '' }}">
                <i class="ti ti-users"></i> Applications
                @php $pendingCount = \App\Models\Application::whereIn('job_id', auth()->user()->jobs()->pluck('id'))->where('status','applied')->count(); @endphp
                @if($pendingCount > 0)
                <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>

            <div class="sidebar-section">Account</div>
            <a href="{{ route('employer.profile.edit') }}"
                class="nav-item {{ request()->routeIs('employer.profile.*') ? 'active' : '' }}">
                <i class="ti ti-building"></i> Company Profile
            </a>
            <a href="{{ route('profile.edit') }}"
                class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="ti ti-user"></i> Account Settings
            </a>
        </nav>
        <div style="padding:16px 20px; border-top:1px solid rgba(255,255,255,0.1);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:none; border:none; color:#93c5fd; font-size:13px; cursor:pointer; display:flex; align-items:center; gap:8px; width:100%;">
                    <i class="ti ti-logout" style="font-size:16px;"></i> Logout
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="main">
        {{-- TOPBAR --}}
        <div class="topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="hamburger" onclick="toggleSidebar()" aria-label="Toggle menu">
                    <i class="ti ti-menu-2" style="font-size:22px;"></i>
                </button>
                <div class="topbar-title">@yield('title', 'Dashboard')</div>
            </div>
            <div class="topbar-right">
                <a href="{{ route('employer.jobs.create') }}" class="btn-primary" style="padding:7px 14px; font-size:12px;">
                    <i class="ti ti-plus" style="font-size:14px;"></i> Post a Job
                </a>
                <div class="user-badge">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
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