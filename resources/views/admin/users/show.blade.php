@extends('layouts.admin')
@section('title', 'User Detail')

@section('content')
<div style="margin-bottom:20px;">
    <a href="{{ route('admin.users.index') }}"
       style="font-size:13px;color:#6b7280;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
        <i class="ti ti-arrow-left"></i> Back to Users
    </a>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:16px;">
    <div>
        <div class="card" style="margin-bottom:16px;">
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;">
                <div style="width:60px;height:60px;border-radius:50%;background:#ede9fe;border:2px solid #c4b5fd;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:#6d28d9;flex-shrink:0;">
                    {{ strtoupper(substr($user->name,0,2)) }}
                </div>
                <div>
                    <div style="font-size:20px;font-weight:700;color:#111827;">{{ $user->name }}</div>
                    <div style="font-size:13px;color:#6b7280;">{{ $user->email }}</div>
                    <div style="margin-top:6px;display:flex;gap:6px;">
                        <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        <span class="badge {{ $user->is_active ? 'badge-active' : 'badge-banned' }}">
                            {{ $user->is_active ? 'Active' : 'Banned' }}
                        </span>
                    </div>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:13px;border-top:1px solid #f3f4f6;padding-top:16px;">
                <div>
                    <div style="color:#9ca3af;margin-bottom:3px;">Joined</div>
                    <div style="font-weight:500;">{{ $user->created_at->format('M d, Y') }}</div>
                </div>
                @if($user->role === 'employer' && $user->employerProfile)
                <div>
                    <div style="color:#9ca3af;margin-bottom:3px;">Company</div>
                    <div style="font-weight:500;">{{ $user->employerProfile->company_name }}</div>
                </div>
                @endif
            </div>
        </div>

        @if($user->role === 'employer')
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;">
                <span style="font-size:14px;font-weight:600;color:#111827;">Posted Jobs ({{ $user->jobs->count() }})</span>
            </div>
            <table>
                <thead><tr><th>Title</th><th>Status</th><th>Posted</th></tr></thead>
                <tbody>
                    @forelse($user->jobs as $job)
                    <tr>
                        <td style="font-weight:500;">{{ $job->title }}</td>
                        <td><span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span></td>
                        <td style="font-size:12px;color:#6b7280;">{{ $job->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;padding:24px;color:#9ca3af;">No jobs posted.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif

        @if($user->role === 'seeker')
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;">
                <span style="font-size:14px;font-weight:600;color:#111827;">Applications ({{ $user->applications->count() }})</span>
            </div>
            <table>
                <thead><tr><th>Job ID</th><th>Status</th><th>Applied</th></tr></thead>
                <tbody>
                    @forelse($user->applications as $app)
                    <tr>
                        <td>#{{ $app->job_id }}</td>
                        <td><span class="badge badge-{{ $app->status }}">{{ ucfirst($app->status) }}</span></td>
                        <td style="font-size:12px;color:#6b7280;">{{ $app->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;padding:24px;color:#9ca3af;">No applications.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div>
        <div class="card">
            <div class="card-title">Actions</div>
            <form method="POST" action="{{ route('admin.users.toggle', $user) }}" style="margin-bottom:10px;">
                @csrf @method('PATCH')
                <button type="submit" class="{{ $user->is_active ? 'btn-danger' : 'btn-success' }}" style="width:100%;justify-content:center;">
                    <i class="ti ti-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                    {{ $user->is_active ? 'Ban this user' : 'Activate user' }}
                </button>
            </form>
            @if($user->role !== 'admin')
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Permanently delete this user?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" style="width:100%;justify-content:center;">
                    <i class="ti ti-trash"></i> Delete user
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection