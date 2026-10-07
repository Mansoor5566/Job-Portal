<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobPortal') — JobPortal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }

        .navbar { background: #fff; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 50; }
        .navbar-inner { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; height: 64px; display: flex; align-items: center; justify-content: space-between; }
        .navbar-logo { font-size: 20px; font-weight: 700; color: #185FA5; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .navbar-links { display: flex; align-items: center; gap: 20px; }
        .navbar-link { font-size: 14px; color: #4b5563; text-decoration: none; }
        .navbar-link:hover { color: #185FA5; }
        .btn-primary { background: #185FA5; color: #fff; border: none; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-primary:hover { background: #0C447C; color: #fff; }
        .btn-outline { background: #fff; color: #374151; border: 1px solid #e5e7eb; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-outline:hover { border-color: #185FA5; color: #185FA5; }

        .page-content { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }

        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px 24px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }

        .hamburger-nav { display: none; }
        .mobile-menu { display: none; background: #fff; border-top: 1px solid #e5e7eb; padding: 1rem 1.5rem; }
        .mobile-menu a { display: block; padding: 10px 0; font-size: 14px; color: #374151; text-decoration: none; border-bottom: 1px solid #f3f4f6; }

        @media(max-width: 768px) {
            .navbar-links { display: none; }
            .hamburger-nav { display: flex; align-items: center; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-logo">
            <i class="ti ti-briefcase"></i> JobPortal
        </a>
        <div class="navbar-links">
            <a href="{{ route('jobs.index') }}" class="navbar-link">Browse Jobs</a>
            @auth
                @if(auth()->user()->isSeeker())
                    <a href="{{ route('seeker.applications') }}" class="navbar-link">My Applications</a>
                    <a href="{{ route('seeker.dashboard') }}" class="btn-primary">Dashboard</a>
                @elseif(auth()->user()->isEmployer())
                    <a href="{{ route('employer.analytics') }}" class="btn-primary">Dashboard</a>
                @elseif(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary">Admin Panel</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-outline">Login</a>
                <a href="{{ route('register') }}" class="btn-primary">Register</a>
            @endauth
        </div>
        {{-- Mobile Hamburger --}}
        <button class="hamburger-nav" onclick="toggleMobileMenu()"
                style="background:none;border:none;cursor:pointer;color:#374151;">
            <i class="ti ti-menu-2" style="font-size:24px;"></i>
        </button>
    </div>
    {{-- Mobile Menu --}}
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('jobs.index') }}">Browse Jobs</a>
        @auth
            @if(auth()->user()->isSeeker())
                <a href="{{ route('seeker.applications') }}">My Applications</a>
                <a href="{{ route('seeker.profile.edit') }}">My Profile</a>
                <a href="{{ route('seeker.dashboard') }}">Dashboard</a>
            @elseif(auth()->user()->isEmployer())
                <a href="{{ route('employer.analytics') }}">Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="border:none;">
                @csrf
                <button type="submit" style="background:none;border:none;color:#dc2626;font-size:14px;padding:10px 0;cursor:pointer;width:100%;text-align:left;">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>

{{-- CONTENT --}}
<div class="page-content">
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

<script>
function toggleMobileMenu(){
    const m = document.getElementById('mobileMenu');
    m.style.display = m.style.display === 'block' ? 'none' : 'block';
}
</script>
</body>
</html>