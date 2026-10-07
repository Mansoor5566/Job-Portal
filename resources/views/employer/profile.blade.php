@extends('layouts.employer')
@section('title', 'Company Profile')

@section('content')
<div style="max-width:700px;">
    <div style="margin-bottom:20px;">
        <h1 style="font-size:18px;font-weight:700;color:#111827;">Company Profile</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">This info appears on all your job listings.</p>
    </div>

    <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Company Logo</div>
            <div style="display:flex;align-items:center;gap:16px;">
                @if($profile->company_logo)
                    <img src="{{ asset('storage/'.$profile->company_logo) }}"
                         style="width:72px;height:72px;border-radius:12px;object-fit:contain;border:1px solid #e5e7eb;padding:4px;">
                @else
                    <div style="width:72px;height:72px;border-radius:12px;background:#eff6ff;border:1px dashed #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;color:#185FA5;">
                        {{ strtoupper(substr($profile->company_name ?? 'C', 0, 1)) }}
                    </div>
                @endif
                <div>
                    <input type="file" name="company_logo" accept="image/*" class="form-input" style="width:auto;">
                    <div class="form-hint">PNG, JPG up to 1MB</div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Company Details</div>
            <div class="form-grid">
                <div class="form-group form-grid-full">
                    <label class="form-label">Company Name <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="company_name" value="{{ old('company_name',$profile->company_name) }}" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Industry</label>
                    <input type="text" name="industry" value="{{ old('industry',$profile->industry) }}" class="form-input" placeholder="e.g. Software Development">
                </div>
                <div class="form-group">
                    <label class="form-label">Company Size</label>
                    <select name="company_size" class="form-select">
                        @foreach(['1-10','11-50','51-200','201-500','500+'] as $size)
                            <option value="{{ $size }}" {{ old('company_size',$profile->company_size)===$size?'selected':'' }}>{{ $size }} employees</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" value="{{ old('website',$profile->website) }}" class="form-input" placeholder="https://yourcompany.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="{{ old('location',$profile->location) }}" class="form-input" placeholder="e.g. Karachi, Pakistan">
                </div>
                <div class="form-group form-grid-full">
                    <label class="form-label">Company Description</label>
                    <textarea name="company_description" rows="5" class="form-textarea" placeholder="Tell candidates about your company, culture and mission...">{{ old('company_description',$profile->company_description) }}</textarea>
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