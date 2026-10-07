@extends('layouts.admin')
@section('title', 'Job Detail')

@section('content')
<div style="margin-bottom:20px;">
    <a href="{{ route('admin.jobs.index') }}"
       style="font-size:13px;color:#6b7280;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
        <i class="ti ti-arrow-left"></i> Back to Jobs
    </a>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:16px;">
    <div>
        <div class="card" style="margin-bottom:16px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
                <div>
                    <h2 style="font-size:20px;font-weight:700;color:#111827;">{{ $job->title }}</h2>
                    <p style="font-size:13px;color:#6b7280;margin-top:4px;">
                        {{ $job->employer->employerProfile->company_name ?? $job->employer->name }}
                        · <i class="ti ti-map-pin" style="font-size:12px;"></i> {{ $job->location }}
                        @if($job->is_remote) · <span style="color:#059669;">Remote</span> @endif
                    </p>
                </div>
                <span class="badge badge-{{ $job->status }}" style="font-size:13px;padding:6px 14px;">
                    {{ ucfirst($job->status) }}
                </span>
            </div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;font-size:13px;border-top:1px solid #f3f4f6;padding-top:16px;">
                <div><div style="color:#9ca3af;margin-bottom:3px;">Type</div><div style="font-weight:500;">{{ ucfirst($job->job_type) }}</div></div>
                <div><div style="color:#9ca3af;margin-bottom:3px;">Category</div><div style="font-weight:500;">{{ $job->category->name }}</div></div>
                <div><div style="color:#9ca3af;margin-bottom:3px;">Experience</div><div style="font-weight:500;">{{ ucfirst($job->experience_level) }}</div></div>
                @if($job->salary_min)
                <div><div style="color:#9ca3af;margin-bottom:3px;">Salary</div><div style="font-weight:500;">${{ number_format($job->salary_min) }} – ${{ number_format($job->salary_max) }}</div></div>
                @endif
                <div><div style="color:#9ca3af;margin-bottom:3px;">Applications</div><div style="font-weight:700;color:#4f46e5;">{{ $job->applications->count() }}</div></div>
                <div><div style="color:#9ca3af;margin-bottom:3px;">Posted</div><div style="font-weight:500;">{{ $job->created_at->format('M d, Y') }}</div></div>
            </div>
        </div>

        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Description</div>
            <p style="font-size:13px;color:#374151;line-height:1.8;">{{ $job->description }}</p>
        </div>

        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;">
                <span style="font-size:14px;font-weight:600;color:#111827;">Applications ({{ $job->applications->count() }})</span>
            </div>
            <table>
                <thead><tr><th>Applicant</th><th>Status</th><th>Applied</th></tr></thead>
                <tbody>
                    @forelse($job->applications as $app)
                    <tr>
                        <td>
                            <div style="font-weight:500;">{{ $app->seeker->name }}</div>
                            <div style="font-size:12px;color:#9ca3af;">{{ $app->seeker->email }}</div>
                        </td>
                        <td><span class="badge badge-{{ $app->status }}">{{ ucfirst($app->status) }}</span></td>
                        <td style="font-size:12px;color:#6b7280;">{{ $app->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;padding:24px;color:#9ca3af;">No applications yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="card">
            <div class="card-title">Actions</div>
            <form method="POST" action="{{ route('admin.jobs.toggle', $job) }}" style="margin-bottom:10px;">
                @csrf @method('PATCH')
                <button type="submit" class="{{ $job->status==='active' ? 'btn-danger' : 'btn-success' }}" style="width:100%;justify-content:center;">
                    <i class="ti ti-{{ $job->status==='active' ? 'ban' : 'check' }}"></i>
                    {{ $job->status==='active' ? 'Close this job' : 'Activate job' }}
                </button>
            </form>
            <a href="{{ route('jobs.show', $job->slug) }}" target="_blank" class="btn-outline" style="width:100%;justify-content:center;margin-bottom:10px;">
                <i class="ti ti-external-link"></i> View public listing
            </a>
            <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}"
                  onsubmit="return confirm('Permanently delete this job?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" style="width:100%;justify-content:center;">
                    <i class="ti ti-trash"></i> Delete job
                </button>
            </form>
        </div>
    </div>
</div>
@endsection