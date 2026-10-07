@extends('layouts.employer')
@section('title', 'Post a New Job')

@section('content')
<div style="max-width:800px;">
    <div style="margin-bottom:20px;">
        <h1 style="font-size:18px;font-weight:700;color:#111827;">Post a New Job</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">Fill in the details below to attract the best candidates.</p>
    </div>

    @if($errors->any())
        <div class="alert-error" style="margin-bottom:16px;">
            <i class="ti ti-alert-circle"></i>
            <ul style="margin-left:16px;margin-top:4px;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('employer.jobs.store') }}">
        @csrf
        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Basic Information</div>
            <div class="form-grid">
                <div class="form-group form-grid-full">
                    <label class="form-label">Job Title <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="e.g. Senior Laravel Developer" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category <span style="color:#dc2626;">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Job Type <span style="color:#dc2626;">*</span></label>
                    <select name="job_type" class="form-select" required>
                        @foreach(['full-time','part-time','contract','internship','freelance'] as $type)
                            <option value="{{ $type }}" {{ old('job_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Location <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="location" value="{{ old('location') }}" class="form-input" placeholder="e.g. Karachi, Pakistan" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Experience Level <span style="color:#dc2626;">*</span></label>
                    <select name="experience_level" class="form-select" required>
                        <option value="entry" {{ old('experience_level')=='entry'?'selected':'' }}>Entry level</option>
                        <option value="mid" {{ old('experience_level')=='mid'?'selected':'' }}>Mid level</option>
                        <option value="senior" {{ old('experience_level')=='senior'?'selected':'' }}>Senior level</option>
                    </select>
                </div>
                <div class="form-group form-grid-full" style="display:flex;align-items:center;gap:10px;padding:12px;background:#f0fdf4;border-radius:8px;border:1px solid #bbf7d0;">
                    <input type="checkbox" name="is_remote" id="is_remote" value="1" {{ old('is_remote')?'checked':'' }} style="width:16px;height:16px;accent-color:#059669;">
                    <label for="is_remote" style="font-size:13px;color:#166534;font-weight:500;cursor:pointer;">
                        <i class="ti ti-home"></i> This is a remote / work from home position
                    </label>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Compensation & Timeline</div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Minimum Salary ($)</label>
                    <input type="number" name="salary_min" value="{{ old('salary_min') }}" class="form-input" placeholder="e.g. 1000">
                </div>
                <div class="form-group">
                    <label class="form-label">Maximum Salary ($)</label>
                    <input type="number" name="salary_max" value="{{ old('salary_max') }}" class="form-input" placeholder="e.g. 3000">
                </div>
                <div class="form-group">
                    <label class="form-label">Application Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Publish Status</label>
                    <select name="status" class="form-select">
                        <option value="active">Active — Publish now</option>
                        <option value="draft">Draft — Save for later</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Job Details</div>
            <div class="form-group">
                <label class="form-label">Skills Required</label>
                <input type="text" name="skills_required" value="{{ old('skills_required') }}" class="form-input" placeholder="e.g. PHP, Laravel, MySQL, Vue.js">
                <div class="form-hint">Separate skills with commas</div>
            </div>
            <div class="form-group">
                <label class="form-label">Job Description <span style="color:#dc2626;">*</span></label>
                <textarea name="description" rows="8" class="form-textarea" placeholder="Describe the role, responsibilities, requirements and benefits..." required>{{ old('description') }}</textarea>
            </div>
        </div>

        <div style="display:flex;gap:12px;align-items:center;">
            <button type="submit" class="btn-primary" style="padding:11px 28px;font-size:14px;">
                <i class="ti ti-send"></i> Post Job
            </button>
            <a href="{{ route('employer.jobs.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection