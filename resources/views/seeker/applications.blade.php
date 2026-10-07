@extends('layouts.seeker')
@section('title', 'My Applications')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:18px;font-weight:700;color:#111827;">My Applications</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">Track all your job applications in one place</p>
    </div>
    <a href="{{ route('jobs.index') }}" class="btn-primary">
        <i class="ti ti-search"></i> Find More Jobs
    </a>
</div>

{{-- Status Filter --}}
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;margin-bottom:16px;">
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
        <select name="status" class="form-select" style="width:180px;">
            <option value="">All Statuses</option>
            @foreach(['applied','viewed','shortlisted','hired','rejected'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary"><i class="ti ti-filter"></i> Filter</button>
        <a href="{{ route('seeker.applications') }}" class="btn-outline">Clear</a>
    </form>
</div>

{{-- Applications List --}}
<div style="display:flex;flex-direction:column;gap:10px;">
    @forelse($applications as $app)
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 22px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;"
         onmouseover="this.style.borderColor='#185FA5'"
         onmouseout="this.style.borderColor='#e5e7eb'">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:#185FA5;flex-shrink:0;">
                {{ strtoupper(substr($app->job->employer->employerProfile->company_name ?? $app->job->employer->name, 0, 2)) }}
            </div>
            <div>
                <a href="{{ route('jobs.show', $app->job->slug) }}"
                   style="font-size:15px;font-weight:600;color:#111827;text-decoration:none;">
                    {{ $app->job->title }}
                </a>
                <div style="font-size:13px;color:#6b7280;margin-top:3px;display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                    <span>{{ $app->job->employer->employerProfile->company_name ?? $app->job->employer->name }}</span>
                    <span style="color:#d1d5db;">·</span>
                    <i class="ti ti-map-pin" style="font-size:12px;"></i>
                    <span>{{ $app->job->location }}</span>
                </div>
                <div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap;">
                    <span style="font-size:11px;padding:3px 10px;border-radius:6px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">
                        {{ ucfirst($app->job->job_type) }}
                    </span>
                    <span style="font-size:11px;padding:3px 10px;border-radius:6px;background:#f3f4f6;color:#4b5563;border:1px solid #e5e7eb;">
                        {{ $app->job->category->name }}
                    </span>
                </div>
            </div>
        </div>

        <div style="text-align:right;">
            @php
                $statusStyles = [
                    'applied'     => 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;',
                    'viewed'      => 'background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;',
                    'shortlisted' => 'background:#fefce8;color:#92400e;border:1px solid #fde68a;',
                    'rejected'    => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                    'hired'       => 'background:#f5f3ff;color:#6d28d9;border:1px solid #ddd6fe;',
                ];
                $statusIcons = [
                    'applied'     => 'ti-send',
                    'viewed'      => 'ti-eye',
                    'shortlisted' => 'ti-star',
                    'rejected'    => 'ti-x',
                    'hired'       => 'ti-check',
                ];
            @endphp
           <span 
    style="font-size:12px;padding:5px 14px;border-radius:50px;display:inline-flex;align-items:center;gap:5px;"
    @if(isset($statusStyles[$app->status]))
        style="{{ $statusStyles[$app->status] }}"
    @endif
>
                <i class="ti {{ $statusIcons[$app->status] ?? 'ti-clock' }}" style="font-size:12px;"></i>
                {{ ucfirst($app->status) }}
            </span>
            <div style="font-size:12px;color:#9ca3af;margin-top:6px;">
                Applied {{ $app->created_at->diffForHumans() }}
            </div>
            @if($app->job->salary_min && $app->job->salary_max)
            <div style="font-size:13px;font-weight:600;color:#111827;margin-top:4px;">
                ${{ number_format($app->job->salary_min) }} – ${{ number_format($app->job->salary_max) }}
            </div>
            @endif
        </div>
    </div>
    @empty
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:60px;text-align:center;">
        <i class="ti ti-send" style="font-size:40px;color:#d1d5db;display:block;margin-bottom:12px;"></i>
        <p style="color:#6b7280;font-size:14px;margin-bottom:16px;">No applications found.</p>
        <a href="{{ route('jobs.index') }}" class="btn-primary">
            <i class="ti ti-search"></i> Browse Jobs
        </a>
    </div>
    @endforelse
</div>

<div style="margin-top:16px;">{{ $applications->withQueryString()->links() }}</div>

@endsection