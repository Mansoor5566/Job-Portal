@extends('layouts.employer')
@section('title', 'Application Detail')

@section('content')
<div style="max-width:800px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('employer.applications.index') }}" style="font-size:13px;color:#6b7280;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
            <i class="ti ti-arrow-left"></i> Back to Applications
        </a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:16px;">
        <div>
            {{-- Applicant Info --}}
            <div class="card" style="margin-bottom:16px;">
                <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;">
                    <div style="width:56px;height:56px;border-radius:50%;background:#eff6ff;border:2px solid #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;color:#185FA5;flex-shrink:0;">
                        {{ strtoupper(substr($application->seeker->name,0,2)) }}
                    </div>
                    <div>
                        <div style="font-size:18px;font-weight:700;color:#111827;">{{ $application->seeker->name }}</div>
                        <div style="font-size:13px;color:#6b7280;">{{ $application->seeker->email }}</div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:13px;">
                    <div>
                        <div style="color:#9ca3af;margin-bottom:3px;">Applied for</div>
                        <div style="font-weight:600;color:#111827;">{{ $application->job->title }}</div>
                    </div>
                    <div>
                        <div style="color:#9ca3af;margin-bottom:3px;">Applied on</div>
                        <div style="font-weight:500;">{{ $application->created_at->format('M d, Y') }}</div>
                    </div>
                    @if($application->seeker->seekerProfile)
                    <div>
                        <div style="color:#9ca3af;margin-bottom:3px;">Location</div>
                        <div>{{ $application->seeker->seekerProfile->location ?? '—' }}</div>
                    </div>
                    <div>
                        <div style="color:#9ca3af;margin-bottom:3px;">Experience</div>
                        <div>{{ ucfirst($application->seeker->seekerProfile->experience_level ?? '—') }}</div>
                    </div>
                    @endif
                </div>
                @if($application->seeker->seekerProfile?->skills)
                    <div style="margin-top:14px;border-top:1px solid #f3f4f6;padding-top:14px;">
                        <div style="font-size:12px;color:#9ca3af;margin-bottom:8px;">Skills</div>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;">
                            @foreach($application->seeker->seekerProfile->skills as $skill)
                                <span style="font-size:12px;padding:3px 10px;border-radius:6px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Cover Letter --}}
            @if($application->cover_letter)
            <div class="card" style="margin-bottom:16px;">
                <div class="card-title">Cover Letter</div>
                <p style="font-size:14px;color:#374151;line-height:1.8;white-space:pre-line;">{{ $application->cover_letter }}</p>
            </div>
            @endif

            {{-- Resume --}}
            @if($application->resume)
            <div class="card">
                <div class="card-title">Resume</div>
                <a href="{{ asset('storage/'.$application->resume) }}" target="_blank" class="btn-primary">
                    <i class="ti ti-download"></i> Download Resume
                </a>
            </div>
            @endif
        </div>

        {{-- Status Panel --}}
        <div>
            <div class="card">
                <div class="card-title">Application Status</div>
                <div style="text-align:center;margin-bottom:20px;">
                    <span class="badge badge-{{ $application->status }}" style="font-size:14px;padding:8px 20px;">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
                <form method="POST" action="{{ route('employer.applications.updateStatus', $application) }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">Update Status</label>
                        <select name="status" class="form-select">
                            @foreach(['viewed','shortlisted','rejected','hired'] as $s)
                                <option value="{{ $s }}" {{ $application->status===$s?'selected':'' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                        <i class="ti ti-check"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection