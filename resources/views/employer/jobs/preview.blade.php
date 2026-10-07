@extends('layouts.employer')
@section('title', 'Job Preview')

@section('content')

<div style="max-width:900px;">

    {{-- Back + Actions --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
        <a href="{{ route('employer.jobs.index') }}"
           style="font-size:13px;color:#6b7280;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
            <i class="ti ti-arrow-left"></i> Back to Listings
        </a>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('employer.jobs.edit', $job) }}" class="btn-outline">
                <i class="ti ti-edit"></i> Edit Job
            </a>
            <a href="{{ route('employer.applications.index', ['job_id' => $job->id]) }}" class="btn-primary">
                <i class="ti ti-users"></i> View Applications
                @if($job->applications->count() > 0)
                    ({{ $job->applications->count() }})
                @endif
            </a>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:16px;">

        {{-- LEFT: Job Detail --}}
        <div>
            {{-- Header Card --}}
            <div class="card" style="margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;">
                    <div style="display:flex;gap:14px;align-items:flex-start;">
                        <div style="width:56px;height:56px;border-radius:12px;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#185FA5;flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->employerProfile->company_name ?? auth()->user()->name, 0, 2)) }}
                        </div>
                        <div>
                            <h1 style="font-size:20px;font-weight:700;color:#111827;margin-bottom:4px;">{{ $job->title }}</h1>
                            <p style="font-size:13px;color:#6b7280;display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                <span>{{ auth()->user()->employerProfile->company_name ?? auth()->user()->name }}</span>
                                <span style="color:#d1d5db;">·</span>
                                <i class="ti ti-map-pin" style="font-size:13px;"></i>
                                <span>{{ $job->location }}</span>
                                @if($job->is_remote)
                                    <span style="color:#d1d5db;">·</span>
                                    <span style="color:#059669;font-weight:500;">Remote</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    {{-- Status Badge --}}
                    @if($job->status === 'active')
                        <span style="font-size:12px;padding:5px 14px;border-radius:50px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;font-weight:500;">
                            <i class="ti ti-circle-check" style="font-size:12px;"></i> Active
                        </span>
                    @elseif($job->status === 'draft')
                        <span style="font-size:12px;padding:5px 14px;border-radius:50px;background:#fffbeb;color:#92400e;border:1px solid #fde68a;font-weight:500;">
                            <i class="ti ti-pencil" style="font-size:12px;"></i> Draft
                        </span>
                    @else
                        <span style="font-size:12px;padding:5px 14px;border-radius:50px;background:#f9fafb;color:#6b7280;border:1px solid #e5e7eb;font-weight:500;">
                            <i class="ti ti-ban" style="font-size:12px;"></i> Closed
                        </span>
                    @endif
                </div>

                {{-- Tags Row --}}
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:16px;padding-top:16px;border-top:1px solid #f3f4f6;">
                    <span style="font-size:12px;padding:4px 12px;border-radius:6px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">
                        <i class="ti ti-clock" style="font-size:11px;"></i> {{ ucfirst($job->job_type) }}
                    </span>
                    <span style="font-size:12px;padding:4px 12px;border-radius:6px;background:#f5f3ff;color:#6d28d9;border:1px solid #ddd6fe;">
                        <i class="ti ti-chart-bar" style="font-size:11px;"></i> {{ ucfirst($job->experience_level) }}
                    </span>
                    <span style="font-size:12px;padding:4px 12px;border-radius:6px;background:#f3f4f6;color:#4b5563;border:1px solid #e5e7eb;">
                        <i class="ti ti-category" style="font-size:11px;"></i> {{ $job->category->name }}
                    </span>
                    @if($job->deadline)
                        <span style="font-size:12px;padding:4px 12px;border-radius:6px;
                            {{ $job->deadline->isPast() ? 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;' : 'background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;' }}">
                            <i class="ti ti-calendar" style="font-size:11px;"></i>
                            Deadline: {{ $job->deadline->format('M d, Y') }}
                            @if($job->deadline->isPast()) (Expired) @endif
                        </span>
                    @endif
                </div>
            </div>

            {{-- Description --}}
            <div class="card" style="margin-bottom:16px;">
                <div style="font-size:15px;font-weight:600;color:#111827;margin-bottom:14px;">Job Description</div>
                <div style="font-size:14px;color:#374151;line-height:1.8;white-space:pre-line;">{{ $job->description }}</div>
            </div>

            {{-- Skills --}}
            @if($job->skills_required)
            <div class="card" style="margin-bottom:16px;">
                <div style="font-size:15px;font-weight:600;color:#111827;margin-bottom:14px;">Skills Required</div>
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    @foreach($job->skills_required as $skill)
                        <span style="font-size:13px;padding:5px 14px;border-radius:8px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Recent Applications --}}
            <div class="card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                    <div style="font-size:15px;font-weight:600;color:#111827;">
                        Recent Applications
                        <span style="font-size:13px;font-weight:400;color:#6b7280;margin-left:6px;">({{ $job->applications->count() }} total)</span>
                    </div>
                    @if($job->applications->count() > 0)
                        <a href="{{ route('employer.applications.index', ['job_id' => $job->id]) }}"
                           style="font-size:13px;color:#185FA5;text-decoration:none;">
                            View all <i class="ti ti-arrow-right" style="font-size:12px;"></i>
                        </a>
                    @endif
                </div>

                @forelse($job->applications->take(5) as $app)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #f9fafb;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:36px;height:36px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#185FA5;flex-shrink:0;">
                            {{ strtoupper(substr($app->seeker->name, 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#111827;">{{ $app->seeker->name }}</div>
                            <div style="font-size:12px;color:#9ca3af;">{{ $app->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        @php
                            $statusStyles = [
                                'applied'     => 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;',
                                'viewed'      => 'background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;',
                                'shortlisted' => 'background:#fefce8;color:#92400e;border:1px solid #fde68a;',
                                'rejected'    => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                                'hired'       => 'background:#f5f3ff;color:#6d28d9;border:1px solid #ddd6fe;',
                            ];
                        @endphp
                        <span style="font-size:11px;padding:3px 10px;border-radius:50px;{{ $statusStyles[$app->status] ?? '' }}">
                            {{ ucfirst($app->status) }}
                        </span>
                        <a href="{{ route('employer.applications.show', $app) }}"
                           style="font-size:12px;color:#185FA5;text-decoration:none;display:flex;align-items:center;gap:3px;">
                            View <i class="ti ti-arrow-right" style="font-size:11px;"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:32px;color:#9ca3af;">
                    <i class="ti ti-inbox" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                    No applications yet.
                </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT: Sidebar Info --}}
        <div>
            {{-- Salary --}}
            @if($job->salary_min && $job->salary_max)
            <div class="card" style="margin-bottom:12px;background:#f0fdf4;border-color:#bbf7d0;">
                <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Salary Range</div>
                <div style="font-size:20px;font-weight:700;color:#166534;">
                    ${{ number_format($job->salary_min) }} – ${{ number_format($job->salary_max) }}
                </div>
                <div style="font-size:12px;color:#6b7280;margin-top:2px;">per month</div>
            </div>
            @endif

            {{-- Quick Stats --}}
            <div class="card" style="margin-bottom:12px;">
                <div style="font-size:14px;font-weight:600;color:#111827;margin-bottom:14px;">Quick Stats</div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;">
                        <span style="color:#6b7280;display:flex;align-items:center;gap:6px;">
                            <i class="ti ti-send" style="font-size:14px;color:#185FA5;"></i> Total Applications
                        </span>
                        <strong style="color:#111827;">{{ $job->applications->count() }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;">
                        <span style="color:#6b7280;display:flex;align-items:center;gap:6px;">
                            <i class="ti ti-star" style="font-size:14px;color:#d97706;"></i> Shortlisted
                        </span>
                        <strong style="color:#111827;">{{ $job->applications->where('status','shortlisted')->count() }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;">
                        <span style="color:#6b7280;display:flex;align-items:center;gap:6px;">
                            <i class="ti ti-check" style="font-size:14px;color:#059669;"></i> Hired
                        </span>
                        <strong style="color:#111827;">{{ $job->applications->where('status','hired')->count() }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:13px;">
                        <span style="color:#6b7280;display:flex;align-items:center;gap:6px;">
                            <i class="ti ti-x" style="font-size:14px;color:#dc2626;"></i> Rejected
                        </span>
                        <strong style="color:#111827;">{{ $job->applications->where('status','rejected')->count() }}</strong>
                    </div>
                </div>
            </div>

            {{-- Job Info --}}
            <div class="card" style="margin-bottom:12px;">
                <div style="font-size:14px;font-weight:600;color:#111827;margin-bottom:14px;">Job Info</div>
                <div style="display:flex;flex-direction:column;gap:10px;font-size:13px;">
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#6b7280;">Posted</span>
                        <span style="color:#111827;font-weight:500;">{{ $job->created_at->format('M d, Y') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#6b7280;">Last Updated</span>
                        <span style="color:#111827;font-weight:500;">{{ $job->updated_at->diffForHumans() }}</span>
                    </div>
                    @if($job->deadline)
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#6b7280;">Deadline</span>
                        <span style="color:{{ $job->deadline->isPast() ? '#dc2626' : '#111827' }};font-weight:500;">
                            {{ $job->deadline->format('M d, Y') }}
                        </span>
                    </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#6b7280;">Category</span>
                        <span style="color:#111827;font-weight:500;">{{ $job->category->name }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#6b7280;">Experience</span>
                        <span style="color:#111827;font-weight:500;">{{ ucfirst($job->experience_level) }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card">
                <div style="font-size:14px;font-weight:600;color:#111827;margin-bottom:14px;">Quick Actions</div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('employer.jobs.edit', $job) }}" class="btn-primary" style="justify-content:center;text-align:center;">
                        <i class="ti ti-edit"></i> Edit This Job
                    </a>
                    <a href="{{ route('employer.applications.index', ['job_id' => $job->id]) }}" class="btn-outline" style="justify-content:center;text-align:center;">
                        <i class="ti ti-users"></i> Manage Applications
                    </a>
                    <form method="POST" action="{{ route('employer.jobs.destroy', $job) }}"
                          onsubmit="return confirm('Delete this job? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" style="width:100%;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:9px;border-radius:8px;font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                            <i class="ti ti-trash"></i> Delete Job
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Responsive --}}
<style>
@media (max-width: 768px) {
    .preview-grid { grid-template-columns: 1fr !important; }
}
</style>
<script>
document.querySelector('.preview-grid') && (document.querySelector('[style*="grid-template-columns:1fr 300px"]').classList.add('preview-grid'));
</script>

@endsection