@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div style="margin-bottom:24px;">
    <h1 style="font-size:18px;font-weight:700;color:#111827;">Welcome back, {{ auth()->user()->name }}</h1>
    <p style="font-size:13px;color:#6b7280;margin-top:4px;">Here's what's happening on your portal today.</p>
</div>

{{-- Stats --}}
<div class="stats-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;">
    <div class="card" style="padding:18px 20px;">
        <div style="width:40px;height:40px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
            <i class="ti ti-users" style="color:#6d28d9;font-size:20px;"></i>
        </div>
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Total Users</div>
        <div style="font-size:26px;font-weight:700;color:#111827;">{{ $stats['total_users'] }}</div>
        <div style="font-size:12px;color:#6b7280;margin-top:4px;">
            <span style="color:#059669;">{{ $stats['total_employers'] }}</span> employers ·
            <span style="color:#185FA5;">{{ $stats['total_seekers'] }}</span> seekers
        </div>
    </div>
    <div class="card" style="padding:18px 20px;">
        <div style="width:40px;height:40px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
            <i class="ti ti-briefcase" style="color:#185FA5;font-size:20px;"></i>
        </div>
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Total Jobs</div>
        <div style="font-size:26px;font-weight:700;color:#111827;">{{ $stats['total_jobs'] }}</div>
        <div style="font-size:12px;margin-top:4px;">
            <span style="color:#059669;">{{ $stats['active_jobs'] }}</span>
            <span style="color:#6b7280;"> active</span>
        </div>
    </div>
    <div class="card" style="padding:18px 20px;">
        <div style="width:40px;height:40px;border-radius:10px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
            <i class="ti ti-send" style="color:#059669;font-size:20px;"></i>
        </div>
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Applications</div>
        <div style="font-size:26px;font-weight:700;color:#111827;">{{ $stats['total_applications'] }}</div>
        <div style="font-size:12px;color:#6b7280;margin-top:4px;">All time</div>
    </div>
    <div class="card" style="padding:18px 20px;">
        <div style="width:40px;height:40px;border-radius:10px;background:#fefce8;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
            <i class="ti ti-tag" style="color:#d97706;font-size:20px;"></i>
        </div>
        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Categories</div>
        <div style="font-size:26px;font-weight:700;color:#111827;">{{ $stats['total_categories'] }}</div>
        <div style="font-size:12px;color:#6b7280;margin-top:4px;">Job categories</div>
    </div>
</div>

{{-- Recent Tables --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:14px;font-weight:600;color:#111827;">Recent Users</span>
            <a href="{{ route('admin.users.index') }}" style="font-size:12px;color:#4f46e5;text-decoration:none;">View all →</a>
        </div>
        <table>
            <thead><tr>
                <th>User</th><th>Role</th><th>Joined</th>
            </tr></thead>
            <tbody>
                @foreach($recentUsers as $user)
                <tr>
                    <td>
                        <div style="font-weight:500;color:#111827;">{{ $user->name }}</div>
                        <div style="font-size:11px;color:#9ca3af;">{{ $user->email }}</div>
                    </td>
                    <td><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                    <td style="font-size:12px;color:#6b7280;">{{ $user->created_at->format('M d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:14px;font-weight:600;color:#111827;">Recent Jobs</span>
            <a href="{{ route('admin.jobs.index') }}" style="font-size:12px;color:#4f46e5;text-decoration:none;">View all →</a>
        </div>
        <table>
            <thead><tr>
                <th>Title</th><th>Status</th><th>Posted</th>
            </tr></thead>
            <tbody>
                @foreach($recentJobs as $job)
                <tr>
                    <td>
                        <div style="font-weight:500;color:#111827;">{{ Str::limit($job->title,28) }}</div>
                        <div style="font-size:11px;color:#9ca3af;">{{ $job->employer->name }}</div>
                    </td>
                    <td><span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span></td>
                    <td style="font-size:12px;color:#6b7280;">{{ $job->created_at->format('M d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection