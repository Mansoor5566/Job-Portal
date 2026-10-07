@extends('layouts.seeker')
@section('title', 'Dashboard')

@section('content')

@php
    $totalApps      = auth()->user()->applications()->count();
    $pendingApps    = auth()->user()->applications()->where('status','applied')->count();
    $shortlisted    = auth()->user()->applications()->where('status','shortlisted')->count();
    $hired          = auth()->user()->applications()->where('status','hired')->count();
    $recentApps     = auth()->user()->applications()->with(['job.employer.employerProfile','job.category'])->latest()->take(5)->get();
@endphp

{{-- Welcome Banner --}}
<div style="background:#0C447C;border-radius:12px;padding:24px 28px;margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:20px;font-weight:700;color:#fff;margin-bottom:4px;">
            Welcome back, {{ auth()->user()->name }}! 👋
        </h1>
        <p style="font-size:13px;color:#93c5fd;">Track your applications and find your next opportunity.</p>
    </div>
    <a href="{{ route('jobs.index') }}" class="btn-primary" style="background:#fff;color:#185FA5;font-weight:600;">
        <i class="ti ti-search"></i> Browse Jobs
    </a>
</div>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;display:flex;align-items:center;gap:6px;">
            <i class="ti ti-send" style="color:#185FA5;font-size:14px;"></i> Total Applied
        </div>
        <div style="font-size:24px;font-weight:700;color:#111827;">{{ $totalApps }}</div>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;display:flex;align-items:center;gap:6px;">
            <i class="ti ti-clock" style="color:#d97706;font-size:14px;"></i> Pending
        </div>
        <div style="font-size:24px;font-weight:700;color:#d97706;">{{ $pendingApps }}</div>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;display:flex;align-items:center;gap:6px;">
            <i class="ti ti-star" style="color:#059669;font-size:14px;"></i> Shortlisted
        </div>
        <div style="font-size:24px;font-weight:700;color:#059669;">{{ $shortlisted }}</div>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;display:flex;align-items:center;gap:6px;">
            <i class="ti ti-check" style="color:#6d28d9;font-size:14px;"></i> Hired
        </div>
        <div style="font-size:24px;font-weight:700;color:#6d28d9;">{{ $hired }}</div>
    </div>
</div>

{{-- Recent Applications --}}
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <div style="font-size:15px;font-weight:600;color:#111827;">Recent Applications</div>
        <a href="{{ route('seeker.applications') }}" style="font-size:13px;color:#185FA5;text-decoration:none;">
            View all <i class="ti ti-arrow-right" style="font-size:12px;"></i>
        </a>
    </div>

    @forelse($recentApps as $app)
    <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid #f9fafb;flex-wrap:wrap;gap:10px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:10px;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#185FA5;flex-shrink:0;">
                {{ strtoupper(substr($app->job->employer->employerProfile->company_name ?? $app->job->employer->name, 0, 2)) }}
            </div>
            <div>
                <a href="{{ route('jobs.show', $app->job->slug) }}"
                   style="font-size:14px;font-weight:600;color:#111827;text-decoration:none;">
                    {{ $app->job->title }}
                </a>
                <div style="font-size:12px;color:#9ca3af;margin-top:2px;">
                    {{ $app->job->employer->employerProfile->company_name ?? $app->job->employer->name }}
                    &nbsp;·&nbsp; {{ $app->job->location }}
                </div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            @php
                $statusStyles = [
                    'applied'     => 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;',
                    'viewed'      => 'background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;',
                    'shortlisted' => 'background:#fefce8;color:#92400e;border:1px solid #fde68a;',
                    'rejected'    => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                    'hired'       => 'background:#f5f3ff;color:#6d28d9;border:1px solid #ddd6fe;',
                ];
            @endphp
            <span style="font-size:11px;padding:4px 12px;border-radius:50px;{{ $statusStyles[$app->status] ?? '' }}">
                {{ ucfirst($app->status) }}
            </span>
            <span style="font-size:12px;color:#9ca3af;">{{ $app->created_at->diffForHumans() }}</span>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:40px;color:#9ca3af;">
        <i class="ti ti-send" style="font-size:36px;display:block;margin-bottom:10px;"></i>
        <p style="font-size:14px;">No applications yet.</p>
        <a href="{{ route('jobs.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:#185FA5;color:#fff;padding:9px 20px;border-radius:8px;font-size:13px;text-decoration:none;">
            <i class="ti ti-search"></i> Browse Jobs
        </a>
    </div>
    @endforelse
</div>

<style>
@media(max-width:768px){
    .stats-grid{grid-template-columns:repeat(2,1fr)!important;}
}
</style>
@endsection