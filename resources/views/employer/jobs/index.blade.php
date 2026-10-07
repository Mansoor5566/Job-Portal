@extends('layouts.employer')
@section('title', 'My Job Listings')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:18px;font-weight:700;color:#111827;">My Job Listings</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">Manage all your posted jobs</p>
    </div>
    <a href="{{ route('employer.jobs.create') }}" class="btn-primary">
        <i class="ti ti-plus"></i> Post New Job
    </a>
</div>

{{-- Stats Row --}}
@php
    $totalJobs  = auth()->user()->jobs()->count();
    $activeJobs = auth()->user()->jobs()->where('status','active')->count();
    $draftJobs  = auth()->user()->jobs()->where('status','draft')->count();
    $closedJobs = auth()->user()->jobs()->where('status','closed')->count();
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;">
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Total Jobs</div>
        <div style="font-size:24px;font-weight:700;color:#111827;">{{ $totalJobs }}</div>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Active</div>
        <div style="font-size:24px;font-weight:700;color:#059669;">{{ $activeJobs }}</div>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Draft</div>
        <div style="font-size:24px;font-weight:700;color:#d97706;">{{ $draftJobs }}</div>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Closed</div>
        <div style="font-size:24px;font-weight:700;color:#6b7280;">{{ $closedJobs }}</div>
    </div>
</div>

{{-- Filter Bar --}}
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;margin-bottom:16px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;width:100%;">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search job title..."
               style="border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;flex:1;min-width:180px;">
        <select name="status" style="border:1px solid #e5e7eb;border-radius:8px;padding:8px 12px;font-size:13px;outline:none;color:#374151;">
            <option value="">All Statuses</option>
            <option value="active"  {{ request('status')==='active'  ?'selected':'' }}>Active</option>
            <option value="draft"   {{ request('status')==='draft'   ?'selected':'' }}>Draft</option>
            <option value="closed"  {{ request('status')==='closed'  ?'selected':'' }}>Closed</option>
        </select>
        <button type="submit" class="btn-primary">
            <i class="ti ti-filter"></i> Filter
        </button>
        <a href="{{ route('employer.jobs.index') }}" class="btn-outline">Clear</a>
    </form>
</div>

{{-- Jobs Table --}}
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
            <thead>
                <tr style="background:#f9fafb;border-bottom:1px solid #f3f4f6;">
                    <th style="text-align:left;padding:12px 16px;color:#6b7280;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:0.04em;">Job</th>
                    <th style="text-align:left;padding:12px 16px;color:#6b7280;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:0.04em;">Type</th>
                    <th style="text-align:left;padding:12px 16px;color:#6b7280;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:0.04em;">Status</th>
                    <th style="text-align:left;padding:12px 16px;color:#6b7280;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:0.04em;">Applications</th>
                    <th style="text-align:left;padding:12px 16px;color:#6b7280;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:0.04em;">Deadline</th>
                    <th style="text-align:left;padding:12px 16px;color:#6b7280;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:0.04em;">Posted</th>
                    <th style="text-align:left;padding:12px 16px;color:#6b7280;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:0.04em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr style="border-bottom:1px solid #f9fafb;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                    <td style="padding:14px 16px;">
                        <div style="font-weight:600;color:#111827;">{{ $job->title }}</div>
                        <div style="font-size:12px;color:#9ca3af;margin-top:2px;display:flex;align-items:center;gap:4px;">
                            <i class="ti ti-map-pin" style="font-size:11px;"></i>
                            {{ $job->location }}
                            @if($job->is_remote)
                                &nbsp;·&nbsp;<span style="color:#059669;">Remote</span>
                            @endif
                        </div>
                        @if($job->skills_required)
                        <div style="margin-top:6px;display:flex;gap:4px;flex-wrap:wrap;">
                            @foreach(array_slice($job->skills_required, 0, 3) as $skill)
                                <span style="font-size:10px;padding:2px 6px;border-radius:4px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">{{ $skill }}</span>
                            @endforeach
                            @if(count($job->skills_required) > 3)
                                <span style="font-size:10px;color:#9ca3af;">+{{ count($job->skills_required)-3 }} more</span>
                            @endif
                        </div>
                        @endif
                    </td>
                    <td style="padding:14px 16px;">
                        <span style="font-size:12px;padding:4px 10px;border-radius:50px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;white-space:nowrap;">
                            {{ ucfirst($job->job_type) }}
                        </span>
                    </td>
                    <td style="padding:14px 16px;">
                        @if($job->status === 'active')
                            <span style="font-size:12px;padding:4px 10px;border-radius:50px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;">Active</span>
                        @elseif($job->status === 'draft')
                            <span style="font-size:12px;padding:4px 10px;border-radius:50px;background:#fffbeb;color:#92400e;border:1px solid #fde68a;">Draft</span>
                        @else
                            <span style="font-size:12px;padding:4px 10px;border-radius:50px;background:#f9fafb;color:#6b7280;border:1px solid #e5e7eb;">Closed</span>
                        @endif
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex;align-items:center;gap:6px;">
                            <span style="font-size:16px;font-weight:700;color:#111827;">{{ $job->applications->count() }}</span>
                            <span style="font-size:12px;color:#9ca3af;">applicants</span>
                        </div>
                        @if($job->applications->where('status','shortlisted')->count() > 0)
                            <div style="font-size:11px;color:#059669;margin-top:2px;">
                                {{ $job->applications->where('status','shortlisted')->count() }} shortlisted
                            </div>
                        @endif
                    </td>
                    <td style="padding:14px 16px;color:#6b7280;font-size:12px;">
                        @if($job->deadline)
                            @if($job->deadline->isPast())
                                <span style="color:#dc2626;">
                                    <i class="ti ti-alert-circle" style="font-size:12px;"></i>
                                    Expired
                                </span>
                            @elseif($job->deadline->diffInDays() <= 3)
                                <span style="color:#d97706;">
                                    <i class="ti ti-clock" style="font-size:12px;"></i>
                                    {{ $job->deadline->diffForHumans() }}
                                </span>
                            @else
                                {{ $job->deadline->format('M d, Y') }}
                            @endif
                        @else
                            <span style="color:#d1d5db;">No deadline</span>
                        @endif
                    </td>
                    <td style="padding:14px 16px;color:#6b7280;font-size:12px;white-space:nowrap;">
                        {{ $job->created_at->format('M d, Y') }}
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex;gap:6px;align-items:center;">
                            {{-- Preview --}}
                           <a href="{{ route('employer.jobs.preview', $job) }}"
                               title="Preview"
                               style="width:32px;height:32px;border-radius:8px;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;"
                               onmouseover="this.style.borderColor='#185FA5';this.style.color='#185FA5'"
                               onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280'">
                                <i class="ti ti-eye" style="font-size:15px;"></i>
                            </a>
                            {{-- Applications --}}
                            <a href="{{ route('employer.applications.index', ['job_id' => $job->id]) }}"
                               title="View Applications"
                               style="width:32px;height:32px;border-radius:8px;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;"
                               onmouseover="this.style.borderColor='#059669';this.style.color='#059669'"
                               onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280'">
                                <i class="ti ti-users" style="font-size:15px;"></i>
                            </a>
                            {{-- Edit --}}
                            <a href="{{ route('employer.jobs.edit', $job) }}"
                               title="Edit"
                               style="width:32px;height:32px;border-radius:8px;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;"
                               onmouseover="this.style.borderColor='#185FA5';this.style.color='#185FA5'"
                               onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280'">
                                <i class="ti ti-edit" style="font-size:15px;"></i>
                            </a>
                            {{-- Delete --}}
                            <form method="POST" action="{{ route('employer.jobs.destroy', $job) }}"
                                  onsubmit="return confirm('Delete this job listing? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Delete"
                                        style="width:32px;height:32px;border-radius:8px;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;color:#6b7280;background:#fff;cursor:pointer;"
                                        onmouseover="this.style.borderColor='#dc2626';this.style.color='#dc2626';this.style.background='#fef2f2'"
                                        onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280';this.style.background='#fff'">
                                    <i class="ti ti-trash" style="font-size:15px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:60px;text-align:center;">
                        <i class="ti ti-file-off" style="font-size:40px;color:#d1d5db;display:block;margin-bottom:12px;"></i>
                        <p style="color:#6b7280;font-size:14px;">No jobs posted yet.</p>
                        <a href="{{ route('employer.jobs.create') }}"
                           style="display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:#185FA5;color:#fff;padding:9px 20px;border-radius:8px;font-size:13px;text-decoration:none;">
                            <i class="ti ti-plus"></i> Post your first job
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div style="margin-top:16px;">{{ $jobs->links() }}</div>

{{-- Responsive --}}
<style>
@media (max-width: 768px) {
    .stats-grid { grid-template-columns: repeat(2,1fr) !important; }
}
</style>

@endsection