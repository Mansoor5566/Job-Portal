@extends('layouts.employer')
@section('title', 'Applications')

@section('content')
<div style="margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;">
    <h1 style="font-size:18px;font-weight:700;color:#111827;">All Applications</h1>
</div>

<div class="card" style="margin-bottom:16px;padding:16px 20px;">
    <form method="GET" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
        <select name="job_id" class="form-select" style="width:220px;">
            <option value="">All Jobs</option>
            @foreach($jobs as $j)
                <option value="{{ $j->id }}" {{ request('job_id')==$j->id?'selected':'' }}>{{ $j->title }}</option>
            @endforeach
        </select>
        <select name="status" class="form-select" style="width:160px;">
            <option value="">All Statuses</option>
            @foreach(['applied','viewed','shortlisted','rejected','hired'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary"><i class="ti ti-filter"></i> Filter</button>
        <a href="{{ route('employer.applications.index') }}" class="btn-outline">Clear</a>
    </form>
</div>

<div class="card" style="padding:0;overflow:hidden;">
    <table>
        <thead>
            <tr>
                <th>Applicant</th>
                <th>Job</th>
                <th>Status</th>
                <th>Applied</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:36px;height:36px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#185FA5;flex-shrink:0;">
                            {{ strtoupper(substr($app->seeker->name,0,2)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;color:#111827;">{{ $app->seeker->name }}</div>
                            <div style="font-size:12px;color:#9ca3af;">{{ $app->seeker->email }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:#374151;font-weight:500;">{{ $app->job->title }}</td>
                <td><span class="badge badge-{{ $app->status }}">{{ ucfirst($app->status) }}</span></td>
                <td style="color:#6b7280;font-size:12px;">{{ $app->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('employer.applications.show', $app) }}" class="btn-primary" style="padding:6px 14px;font-size:12px;">
                        <i class="ti ti-eye"></i> View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:48px;color:#9ca3af;">
                    <i class="ti ti-inbox" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                    No applications yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:16px;">{{ $applications->withQueryString()->links() }}</div>
@endsection