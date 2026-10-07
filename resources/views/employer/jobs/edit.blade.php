@extends('layouts.employer')
@section('title', 'Edit Job')

@section('content')
<div style="max-width:800px;">
    <div style="margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;">
        <div>
            <h1 style="font-size:18px;font-weight:700;color:#111827;">Edit Job</h1>
            <p style="font-size:13px;color:#6b7280;margin-top:4px;">{{ $job->title }}</p>
        </div>
        <a href="{{ route('jobs.show', $job->slug) }}" target="_blank" class="btn-outline">
            <i class="ti ti-eye"></i> Preview
        </a>
    </div>

    @if($errors->any())
        <div class="alert-error" style="margin-bottom:16px;">
            <ul style="margin-left:16px;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('employer.jobs.update', $job) }}">
        @csrf @method('PUT')

        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Basic Information</div>
            <div class="form-grid">
                <div class="form-group form-grid-full">
                    <label class="form-label">Job Title</label>
                    <input type="text" name="title" value="{{ old('title', $job->title) }}" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id',$job->category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Job Type</label>
                    <select name="job_type" class="form-select" required>
                        @foreach(['full-time','part-time','contract','internship','freelance'] as $type)
                            <option value="{{ $type }}" {{ old('job_type',$job->job_type)==$type?'selected':'' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="{{ old('location',$job->location) }}" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Experience Level</label>
                    <select name="experience_level" class="form-select" required>
                        @foreach(['entry','mid','senior'] as $level)
                            <option value="{{ $level }}" {{ old('experience_level',$job->experience_level)==$level?'selected':'' }}>{{ ucfirst($level) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['active','draft','closed'] as $s)
                            <option value="{{ $s }}" {{ old('status',$job->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-grid-full" style="display:flex;align-items:center;gap:10px;padding:12px;background:#f0fdf4;border-radius:8px;border:1px solid #bbf7d0;">
                    <input type="checkbox" name="is_remote" id="is_remote" value="1" {{ old('is_remote',$job->is_remote)?'checked':'' }} style="width:16px;height:16px;accent-color:#059669;">
                    <label for="is_remote" style="font-size:13px;color:#166534;font-weight:500;cursor:pointer;">Remote / work from home position</label>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Compensation & Timeline</div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Minimum Salary ($)</label>
                    <input type="number" name="salary_min" value="{{ old('salary_min',$job->salary_min) }}" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Maximum Salary ($)</label>
                    <input type="number" name="salary_max" value="{{ old('salary_max',$job->salary_max) }}" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Application Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline',$job->deadline?->format('Y-m-d')) }}" class="form-input">
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:16px;">
            <div class="card-title">Job Details</div>
            <div class="form-group">
                <label class="form-label">Skills Required</label>
                <input type="text" name="skills_required" class="form-input"
                       value="{{ old('skills_required', is_array($job->skills_required) ? implode(', ', $job->skills_required) : '') }}"
                       placeholder="e.g. PHP, Laravel, MySQL">
                <div class="form-hint">Separate skills with commas</div>
            </div>
            <div class="form-group">
                <label class="form-label">Job Description</label>
                <textarea name="description" rows="8" class="form-textarea" required>{{ old('description',$job->description) }}</textarea>
            </div>
        </div>

        <div style="display:flex;gap:12px;align-items:center;">
            <button type="submit" class="btn-primary" style="padding:11px 28px;font-size:14px;">
                <i class="ti ti-check"></i> Update Job
            </button>
            <a href="{{ route('employer.jobs.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection