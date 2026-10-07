<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobPortal — Find Your Dream Job</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="logo">
            <i class="ti ti-briefcase" aria-hidden="true"></i> JobPortal
        </a>
        <div class="nav-links">
            <a href="{{ route('jobs.index') }}" class="nav-link">Browse Jobs</a>
            @auth
                @if(auth()->user()->isEmployer())
                    <a href="{{ route('employer.jobs.create') }}" class="nav-link">Post a Job</a>
                @endif
                <a href="{{ route('dashboard') }}" class="btn-primary">
                    <i class="ti ti-layout-dashboard" aria-hidden="true"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-outline">Login</a>
                <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
            @endauth
        </div>
        {{-- Mobile --}}
        <div class="hamburger-nav">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary" style="padding:7px 14px;font-size:12px;">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-outline" style="padding:7px 14px;font-size:12px;">Login</a>
                <a href="{{ route('register') }}" class="btn-primary" style="padding:7px 14px;font-size:12px;">Register</a>
            @endauth
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-inner">
        <div class="hero-badge">
            <i class="ti ti-bolt" aria-hidden="true"></i>
            {{ $totalJobs }} jobs available right now
        </div>
        <h1>Find your next <span>opportunity</span></h1>
        <p>Connect with top employers. Land the job you deserve.</p>
        <form method="GET" action="{{ route('jobs.index') }}" class="search-box">
            <div class="search-input-wrap">
                <i class="ti ti-search" style="color:#9ca3af;font-size:18px;" aria-hidden="true"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Job title, skill, or keyword">
            </div>
            <div class="search-divider"></div>
            <div class="search-loc-wrap">
                <i class="ti ti-map-pin" style="color:#9ca3af;font-size:18px;" aria-hidden="true"></i>
                <input type="text" name="location" value="{{ request('location') }}"
                       placeholder="City or remote">
            </div>
            <button type="submit" class="btn-primary" style="padding:12px 28px;font-size:14px;border-radius:8px;white-space:nowrap;">
                Search Jobs
            </button>
        </form>
        <div class="hero-stats">
            <div class="hero-stat"><span>{{ $totalJobs }}+</span> active jobs</div>
            <div class="hero-stat"><span>10</span> categories</div>
            <div class="hero-stat"><span>100%</span> free to use</div>
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
<div class="section">
    <div class="section-header">
        <h2 class="section-title">Browse by category</h2>
    </div>
    <div class="cat-grid">
        @php
            $icons = [
                'Information Technology' => 'ti-code',
                'Design & Creative'      => 'ti-palette',
                'Marketing'              => 'ti-speakerphone',
                'Finance & Accounting'   => 'ti-calculator',
                'Healthcare'             => 'ti-heart-rate-monitor',
                'Education'              => 'ti-school',
                'Engineering'            => 'ti-tool',
                'Sales'                  => 'ti-trending-up',
                'Customer Support'       => 'ti-headset',
                'Human Resources'        => 'ti-users',
            ];
        @endphp
        @foreach($categories as $cat)
        <a href="{{ route('jobs.index', ['category' => $cat->id]) }}" class="cat-card">
            <div class="cat-icon">
                <i class="ti {{ $icons[$cat->name] ?? 'ti-briefcase' }}" aria-hidden="true"></i>
            </div>
            <div class="cat-name">{{ $cat->name }}</div>
            <div class="cat-count">{{ $cat->jobs_count }} jobs</div>
        </a>
        @endforeach
    </div>

    {{-- LATEST JOBS --}}
    <div class="section-header">
        <h2 class="section-title">Latest jobs</h2>
        <a href="{{ route('jobs.index') }}" class="view-all">
            View all jobs <i class="ti ti-arrow-right" style="font-size:12px;" aria-hidden="true"></i>
        </a>
    </div>

    <div style="margin-bottom:52px;">
        @forelse($latestJobs as $job)
        <a href="{{ route('jobs.show', $job->slug) }}" class="job-card">
            <div class="job-avatar">
                {{ strtoupper(substr($job->employer->employerProfile->company_name ?? $job->employer->name, 0, 2)) }}
            </div>
            <div class="job-info">
                <div class="job-title">
                    {{ $job->title }}
                    @if($job->is_featured)
                        <span class="featured-badge">FEATURED</span>
                    @endif
                </div>
                <div class="job-meta">
                    {{ $job->employer->employerProfile->company_name ?? $job->employer->name }}
                    &nbsp;·&nbsp;
                    <i class="ti ti-map-pin" style="font-size:12px;" aria-hidden="true"></i>
                    {{ $job->location }}
                    @if($job->is_remote)
                        &nbsp;·&nbsp; <span style="color:#059669;">Remote</span>
                    @endif
                </div>
                <div class="job-tags">
                    <span class="tag tag-blue">{{ ucfirst($job->job_type) }}</span>
                    <span class="tag">{{ $job->category->name }}</span>
                    <span class="tag tag-purple">{{ ucfirst($job->experience_level) }}</span>
                </div>
            </div>
            <div class="job-right">
                @if($job->salary_min && $job->salary_max)
                    <div class="job-salary">
                        ${{ number_format($job->salary_min) }} – ${{ number_format($job->salary_max) }}
                    </div>
                @endif
                <div class="job-time">{{ $job->created_at->diffForHumans() }}</div>
                <div class="apply-btn">Apply now</div>
            </div>
        </a>
        @empty
        <div style="text-align:center;padding:48px;background:#fff;border-radius:12px;border:1px solid #e5e7eb;color:#9ca3af;">
            <i class="ti ti-briefcase-off" style="font-size:40px;display:block;margin-bottom:12px;" aria-hidden="true"></i>
            No jobs posted yet. Check back soon!
        </div>
        @endforelse
    </div>
</div>

{{-- CTA --}}
<section class="cta-section">
    <h2>Ready to get started?</h2>
    <p>Join thousands of job seekers and employers already using JobPortal</p>
    <div class="cta-btns">
        <a href="{{ route('register') }}" class="btn-white">
            <i class="ti ti-user-plus" aria-hidden="true"></i> Find a Job
        </a>
        <a href="{{ route('register') }}" class="btn-ghost">
            <i class="ti ti-building" aria-hidden="true"></i> Post a Job
        </a>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="footer-inner">
        <div class="footer-logo">
            <i class="ti ti-briefcase" aria-hidden="true"></i> JobPortal
        </div>
        <div class="footer-links">
            <a href="{{ route('jobs.index') }}" class="footer-link">Browse Jobs</a>
            <a href="{{ route('register') }}" class="footer-link">Register</a>
            <a href="{{ route('login') }}" class="footer-link">Login</a>
        </div>
        <div class="footer-copy">© {{ date('Y') }} JobPortal. All rights reserved.</div>
    </div>
</footer>

</body>
</html>