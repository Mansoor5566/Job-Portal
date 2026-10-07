@extends('layouts.seeker')
@section('title', 'My Profile')

@section('content')

<div style="max-width:700px;">
    <div style="margin-bottom:20px;">
        <h1 style="font-size:18px;font-weight:700;color:#111827;">My Profile</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">Complete your profile to attract better opportunities.</p>
    </div>

    {{-- Profile Completion --}}
    @php
        $fields = [$profile->phone, $profile->location, $profile->bio, $profile->resume, $profile->skills, $profile->experience_level, $profile->profile_photo];
        $filled = collect($fields)->filter()->count();
        $pct    = round(($filled / count($fields)) * 100);
    @endphp
    <div class="card" style="margin-bottom:16px;background:#eff6ff;border-color:#bfdbfe;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
            <span style="font-size:13px;font-weight:600;color:#1d4ed8;">Profile Completion</span>
            <span style="font-size:13px;font-weight:700;color:#185FA5;">{{ $pct }}%</span>
        </div>
        <div style="background:#bfdbfe;border-radius:50px;height:8px;overflow:hidden;">
           <div style="background:#185FA5;height:100%;border-radius:50px;width:{{ $pct }}%;transition:width 0.3s;"></div>
        </div>
        @if($pct < 100)
            <p style="font-size:12px;color:#1d4ed8;margin-top:8px;">
                <i class="ti ti-info-circle" style="font-size:13px;"></i>
                Complete your profile to get noticed by employers.
            </p>
        @endif
    </div>

    <form method="POST" action="{{ route('seeker.profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Photo & Resume --}}
        <div class="card" style="margin-bottom:16px;">
            <div style="font-size:14px;font-weight:600;color:#111827;margin-bottom:16px;">Profile Photo & Resume</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                <div>
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:10px;">
                        @if($profile->profile_photo)
                            <img src="{{ asset('storage/'.$profile->profile_photo) }}"
                                 style="width:64px;height:64px;border-radius:50%;object-fit:cover;border:2px solid #bfdbfe;">
                        @else
                            <div style="width:64px;height:64px;border-radius:50%;background:#eff6ff;border:2px dashed #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:#185FA5;flex-shrink:0;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <div class="form-label">Profile Photo</div>
                            <input type="file" name="profile_photo" accept="image/*" style="font-size:12px;color:#6b7280;">
                            <div class="form-hint">JPG/PNG, max 1MB</div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-label">Resume / CV</div>
                    @if($profile->resume)
                        <a href="{{ asset('storage/'.$profile->resume) }}" target="_blank"
                           style="display:inline-flex;align-items:center;gap:6px;font-size:12px;color:#185FA5;text-decoration:none;margin-bottom:8px;background:#eff6ff;padding:6px 12px;border-radius:6px;border:1px solid #bfdbfe;">
                            <i class="ti ti-file" style="font-size:14px;"></i> Current Resume
                        </a>
                    @endif
                    <input type="file" name="resume" accept=".pdf,.doc,.docx" style="font-size:12px;color:#6b7280;display:block;">
                    <div class="form-hint">PDF/DOC, max 2MB</div>
                </div>
            </div>
        </div>

        {{-- Personal Info --}}
        <div class="card" style="margin-bottom:16px;">
            <div style="font-size:14px;font-weight:600;color:#111827;margin-bottom:16px;">Personal Information</div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone',$profile->phone) }}"
                           class="form-input" placeholder="+92 300 0000000">
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="{{ old('location',$profile->location) }}"
                           class="form-input" placeholder="e.g. Karachi, Pakistan">
                </div>
                <div class="form-group">
                    <label class="form-label">Experience Level</label>
                    <select name="experience_level" class="form-select">
                        <option value="">Select level</option>
                        @foreach(['entry'=>'Entry Level','mid'=>'Mid Level','senior'=>'Senior Level'] as $val => $label)
                            <option value="{{ $val }}" {{ old('experience_level',$profile->experience_level)===$val?'selected':'' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Skills</label>
                    <input type="text" name="skills"
                           value="{{ old('skills', is_array($profile->skills) ? implode(', ', $profile->skills) : '') }}"
                           class="form-input" placeholder="e.g. PHP, Laravel, MySQL">
                    <div class="form-hint">Separate with commas</div>
                </div>
                <div class="form-group form-grid-full">
                    <label class="form-label">Bio / About Me</label>
                    <textarea name="bio" rows="4" class="form-textarea"
                              placeholder="Tell employers about yourself, your experience and what you're looking for...">{{ old('bio',$profile->bio) }}</textarea>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn-primary" style="padding:11px 28px;font-size:14px;">
                <i class="ti ti-check"></i> Save Profile
            </button>
        </div>
    </form>
</div>
@endsection