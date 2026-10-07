@extends('layouts.admin')
@section('title', 'Jobs')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div>
        <h1 style="font-size:18px;font-weight:700;color:#111827;">All Jobs</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">Monitor and manage all job listings</p>
    </div>
</div>

<div class="card" style="margin-bottom:16px;padding:16px 20px;">
    <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
        <div style="position:relative;flex:1;min-width:200px;">
            <i class="ti ti-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:15px;"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search job title"
                   class="form-input" style="padding-left:32px;">
        </div>
        <select name="status" class="form-select" style="width:160px;">
            <option value="">All Statuses</option>
            @foreach(['active','closed','draft'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary"><i class="ti ti-filter"></i> Filter</button>
        <a href="{{ route('admin.jobs.index') }}" class="btn-outline">Clear</a>
    </form>
</div>

<div class="card" style="padding:0;overflow:hidden;">
    <table>
        <thead>
            <tr>
                <th>Job</th>
                <th>Employer</th>
                <th>Category</th>
                <th>Status</th>
                <th>Apps</th>
                <th>Posted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
            <tr>
                <td>
                    <div style="font-weight:600;color:#111827;">{{ Str::limit($job->title,30) }}</div>
                    <div style="font-size:12px;color:#9ca3af;margin-top:2px;">
                        <i class="ti ti-map-pin" style="font-size:11px;"></i> {{ $job->location }}
                    </div>
                </td>
                <td style="font-size:13px;color:#374151;">
                    {{ $job->employer->employerProfile->company_name ?? $job->employer->name }}
                </td>
                <td style="font-size:12px;color:#6b7280;">{{ $job->category->name }}</td>
                <td><span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span></td>
                <td style="font-weight:600;color:#111827;">{{ $job->applications->count() }}</td>
                <td style="font-size:12px;color:#6b7280;">{{ $job->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <a href="{{ route('admin.jobs.show', $job) }}"
                           style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;border-radius:8px;color:#6b7280;text-decoration:none;">
                            <i class="ti ti-eye" style="font-size:15px;"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.jobs.toggle', $job) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;cursor:pointer;border:1px solid {{ $job->status==='active' ? '#fecaca' : '#bbf7d0' }};background:{{ $job->status==='active' ? '#fef2f2' : '#f0fdf4' }};color:{{ $job->status==='active' ? '#dc2626' : '#166534' }};"
                                    title="{{ $job->status==='active' ? 'Close job' : 'Activate job' }}">
                                <i class="ti ti-{{ $job->status==='active' ? 'ban' : 'check' }}" style="font-size:15px;"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}"
                              onsubmit="return confirm('Delete this job?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border:1px solid #fecaca;border-radius:8px;background:#fef2f2;color:#dc2626;cursor:pointer;">
                                <i class="ti ti-trash" style="font-size:15px;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:48px;color:#9ca3af;">
                    <i class="ti ti-briefcase-off" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                    No jobs found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:16px;">{{ $jobs->withQueryString()->links() }}</div>
@endsection