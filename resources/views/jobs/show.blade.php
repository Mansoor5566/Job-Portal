@extends('layouts.seeker')
@section('title', $job->title)

@section('content')

    <div style="max-width:900px;">

        {{-- Back --}}
        <a href="{{ route('jobs.index') }}"
            style="font-size:13px;color:#6b7280;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:20px;">
            <i class="ti ti-arrow-left"></i> Back to Jobs
        </a>

        <div style="display:grid;grid-template-columns:1fr 300px;gap:16px;" class="job-detail-grid">

            {{-- LEFT --}}
            <div>
                {{-- Header Card --}}
                <div class="card" style="margin-bottom:16px;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;">
                        <div style="display:flex;gap:14px;align-items:flex-start;">
                            <div
                                style="width:60px;height:60px;border-radius:12px;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;color:#185FA5;flex-shrink:0;">
                                {{ strtoupper(substr($job->employer->employerProfile->company_name ?? $job->employer->name, 0, 2)) }}
                            </div>
                            <div>
                                <h1 style="font-size:20px;font-weight:700;color:#111827;margin-bottom:4px;">
                                    {{ $job->title }}
                                </h1>
                                <div
                                    style="font-size:13px;color:#6b7280;display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                    <span style="font-weight:500;color:#374151;">
                                        {{ $job->employer->employerProfile->company_name ?? $job->employer->name }}
                                    </span>
                                    <span style="color:#d1d5db;">·</span>
                                    <i class="ti ti-map-pin" style="font-size:13px;"></i>
                                    <span>{{ $job->location }}</span>
                                    @if ($job->is_remote)
                                        <span style="color:#d1d5db;">·</span>
                                        <span style="color:#059669;font-weight:500;">
                                            <i class="ti ti-home" style="font-size:12px;"></i> Remote
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($job->is_featured)
                            <span
                                style="font-size:11px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;padding:4px 12px;border-radius:50px;font-weight:600;white-space:nowrap;">
                                ⭐ FEATURED
                            </span>
                        @endif
                    </div>

                    {{-- Tags --}}
                    <div
                        style="display:flex;gap:8px;flex-wrap:wrap;margin-top:16px;padding-top:16px;border-top:1px solid #f3f4f6;">
                        <span
                            style="font-size:12px;padding:5px 12px;border-radius:6px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;display:inline-flex;align-items:center;gap:5px;">
                            <i class="ti ti-clock" style="font-size:12px;"></i> {{ ucfirst($job->job_type) }}
                        </span>
                        <span
                            style="font-size:12px;padding:5px 12px;border-radius:6px;background:#f5f3ff;color:#6d28d9;border:1px solid #ddd6fe;display:inline-flex;align-items:center;gap:5px;">
                            <i class="ti ti-chart-bar" style="font-size:12px;"></i> {{ ucfirst($job->experience_level) }}
                        </span>
                        <span
                            style="font-size:12px;padding:5px 12px;border-radius:6px;background:#f3f4f6;color:#4b5563;border:1px solid #e5e7eb;display:inline-flex;align-items:center;gap:5px;">
                            <i class="ti ti-category" style="font-size:12px;"></i> {{ $job->category->name }}
                        </span>
                        @if ($job->deadline)
                            <span
                                style="font-size:12px;padding:5px 12px;border-radius:6px;display:inline-flex;align-items:center;gap:5px;
                            {{ $job->deadline->isPast() ? 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;' : 'background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;' }}">
                                <i class="ti ti-calendar" style="font-size:12px;"></i>
                                Deadline: {{ $job->deadline->format('M d, Y') }}
                                @if ($job->deadline->isPast())
                                    <strong>(Expired)</strong>
                                @endif
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                <div class="card" style="margin-bottom:16px;">
                    <div
                        style="font-size:15px;font-weight:600;color:#111827;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                        <i class="ti ti-file-description" style="color:#185FA5;"></i> Job Description
                    </div>
                    <div style="font-size:14px;color:#374151;line-height:1.9;white-space:pre-line;">{{ $job->description }}
                    </div>
                </div>

                {{-- Skills --}}
                @if ($job->skills_required)
                    <div class="card" style="margin-bottom:16px;">
                        <div
                            style="font-size:15px;font-weight:600;color:#111827;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                            <i class="ti ti-tool" style="color:#185FA5;"></i> Skills Required
                        </div>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            @foreach ($job->skills_required as $skill)
                                <span
                                    style="font-size:13px;padding:6px 14px;border-radius:8px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;font-weight:500;">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Apply Section --}}
                <div class="card" style="background:#f8fafc;">
                    <div
                        style="font-size:15px;font-weight:600;color:#111827;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                        <i class="ti ti-send" style="color:#185FA5;"></i> Apply for this Position
                    </div>

                    @auth
                        @if (auth()->user()->isSeeker())
                            @php
                                $applied = auth()->user()->applications()->where('job_id', $job->id)->exists();
                                $expired = $job->deadline && $job->deadline->isPast();
                                $isClosed = $job->status !== 'active';
                            @endphp

                            @if ($isClosed)
                                <div
                                    style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:16px;display:flex;align-items:center;gap:10px;">
                                    <i class="ti ti-ban" style="font-size:24px;color:#6b7280;"></i>
                                    <div>
                                        <div style="font-size:14px;font-weight:600;color:#374151;">Job Closed</div>
                                        <div style="font-size:13px;color:#6b7280;margin-top:2px;">This job is no longer
                                            accepting applications.</div>
                                    </div>
                                </div>
                            @elseif($expired)
                                <div
                                    style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:16px;display:flex;align-items:center;gap:10px;">
                                    <i class="ti ti-clock-off" style="font-size:24px;color:#dc2626;"></i>
                                    <div>
                                        <div style="font-size:14px;font-weight:600;color:#dc2626;">Deadline Passed</div>
                                        <div style="font-size:13px;color:#ef4444;margin-top:2px;">
                                            The application deadline was {{ $job->deadline->format('M d, Y') }}. This job is no
                                            longer accepting applications.
                                        </div>
                                    </div>
                                </div>
                            @elseif($applied)
                                <div
                                    style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:16px;display:flex;align-items:center;gap:10px;">
                                    <i class="ti ti-circle-check" style="font-size:24px;color:#059669;"></i>
                                    <div>
                                        <div style="font-size:14px;font-weight:600;color:#166534;">Application Submitted!</div>
                                        <div style="font-size:13px;color:#4ade80;margin-top:2px;">You have already applied for
                                            this job. Track your status in My Applications.</div>
                                    </div>
                                    <a href="{{ route('seeker.applications') }}"
                                        style="margin-left:auto;font-size:12px;padding:7px 14px;border-radius:8px;background:#059669;color:#fff;text-decoration:none;white-space:nowrap;">
                                        Track Status
                                    </a>
                                </div>
                            @else
                                @if (session('success'))
                                    <div
                                        style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                                        <i class="ti ti-circle-check"></i> {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div
                                        style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('jobs.apply', $job) }}" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Cover Letter --}}
                                    <div style="margin-bottom:16px;">
                                        <label
                                            style="display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:6px;">
                                            Cover Letter <span style="color:#9ca3af;font-weight:400;">(optional)</span>
                                        </label>
                                        <textarea name="cover_letter" rows="5"
                                            style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:13px;color:#111827;outline:none;resize:vertical;"
                                            placeholder="Tell the employer why you're a great fit...">{{ old('cover_letter') }}</textarea>
                                    </div>

                                    {{-- Resume Options --}}
                                    <div style="margin-bottom:16px;">
                                        <label
                                            style="display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:10px;">
                                            Resume
                                        </label>

                                        @php $profileResume = auth()->user()->seekerProfile->resume ?? null; @endphp

                                        @if ($profileResume)
                                            {{-- Option 1: Use profile resume --}}
                                            <label
                                                style="display:flex;align-items:center;gap:10px;padding:12px 14px;border:2px solid #e5e7eb;border-radius:8px;cursor:pointer;margin-bottom:8px;transition:all 0.2s;"
                                                id="option-profile-label" onclick="selectResumeOption('profile')">
                                                <input type="radio" name="resume_option" value="profile" id="option-profile"
                                                    checked style="accent-color:#185FA5;">
                                                <div style="flex:1;">
                                                    <div style="font-size:13px;font-weight:600;color:#111827;">
                                                        <i class="ti ti-file-check" style="color:#059669;"></i>
                                                        Use my profile resume
                                                    </div>
                                                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">
                                                        Your uploaded CV will be sent to the employer
                                                    </div>
                                                </div>
                                                <a href="{{ asset('storage/' . $profileResume) }}" target="_blank"
                                                    onclick="event.stopPropagation();"
                                                    style="font-size:12px;color:#185FA5;white-space:nowrap;text-decoration:none;display:flex;align-items:center;gap:4px;">
                                                    <i class="ti ti-eye"></i> View
                                                </a>
                                            </label>

                                            {{-- Option 2: Upload new resume --}}
                                            <label
                                                style="display:flex;align-items:center;gap:10px;padding:12px 14px;border:2px solid #e5e7eb;border-radius:8px;cursor:pointer;transition:all 0.2s;"
                                                id="option-new-label" onclick="selectResumeOption('new')">
                                                <input type="radio" name="resume_option" value="new" id="option-new"
                                                    style="accent-color:#185FA5;">
                                                <div style="flex:1;">
                                                    <div style="font-size:13px;font-weight:600;color:#111827;">
                                                        <i class="ti ti-upload" style="color:#185FA5;"></i>
                                                        Upload a different resume
                                                    </div>
                                                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">
                                                        PDF, DOC or DOCX — max 2MB
                                                    </div>
                                                </div>
                                            </label>

                                            {{-- File upload (hidden until new selected) --}}
                                            <div id="upload-wrap" style="display:none;margin-top:8px;">
                                                <input type="file" name="resume" accept=".pdf,.doc,.docx"
                                                    style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:9px 12px;font-size:13px;">
                                            </div>
                                        @else
                                            {{-- No profile resume — show upload only --}}
                                            <div
                                                style="padding:12px 14px;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:8px;">
                                                <div style="font-size:13px;font-weight:500;color:#374151;margin-bottom:8px;">
                                                    <i class="ti ti-upload" style="color:#185FA5;"></i>
                                                    Upload Resume <span style="color:#9ca3af;font-weight:400;">(PDF, DOC — max
                                                        2MB)</span>
                                                </div>
                                                <input type="file" name="resume" accept=".pdf,.doc,.docx"
                                                    style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:9px 12px;font-size:13px;">
                                            </div>
                                            <div
                                                style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:10px 14px;font-size:12px;color:#92400e;display:flex;align-items:center;gap:6px;">
                                                <i class="ti ti-info-circle"></i>
                                                No resume on your profile.
                                                <a href="{{ route('seeker.profile.edit') }}"
                                                    style="color:#185FA5;font-weight:500;">Upload one to your profile</a>
                                                to apply faster next time.
                                            </div>
                                        @endif
                                    </div>

                                    <button type="submit"
                                        style="background:#185FA5;color:#fff;border:none;padding:11px 28px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;width:100%;justify-content:center;">
                                        <i class="ti ti-send"></i> Submit Application
                                    </button>
                                </form>

                                <script>
                                    function selectResumeOption(option) {
                                        const profileLabel = document.getElementById('option-profile-label');
                                        const newLabel = document.getElementById('option-new-label');
                                        const uploadWrap = document.getElementById('upload-wrap');

                                        if (option === 'profile') {
                                            profileLabel.style.borderColor = '#185FA5';
                                            profileLabel.style.background = '#eff6ff';
                                            newLabel.style.borderColor = '#e5e7eb';
                                            newLabel.style.background = '#fff';
                                            uploadWrap.style.display = 'none';
                                        } else {
                                            newLabel.style.borderColor = '#185FA5';
                                            newLabel.style.background = '#eff6ff';
                                            profileLabel.style.borderColor = '#e5e7eb';
                                            profileLabel.style.background = '#fff';
                                            uploadWrap.style.display = 'block';
                                        }
                                    }

                                    // Set initial style on page load
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const profileOption = document.getElementById('option-profile');
                                        if (profileOption && profileOption.checked) {
                                            selectResumeOption('profile');
                                        }
                                    });
                                </script>
                            @endif
                        @else
                            <div
                                style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:16px;font-size:13px;color:#92400e;">
                                <i class="ti ti-info-circle" style="font-size:16px;"></i>
                                Only job seekers can apply. Please login as a seeker.
                            </div>
                        @endif
                    @else
                        <div style="text-align:center;padding:20px 0;">
                            <p style="font-size:14px;color:#6b7280;margin-bottom:16px;">Login to apply for this job</p>
                            <div style="display:flex;gap:10px;justify-content:center;">
                                <a href="{{ route('login') }}"
                                    style="background:#185FA5;color:#fff;padding:10px 24px;border-radius:8px;font-size:13px;text-decoration:none;font-weight:500;">
                                    Login
                                </a>
                                <a href="{{ route('register') }}"
                                    style="background:#fff;color:#185FA5;border:1px solid #185FA5;padding:10px 24px;border-radius:8px;font-size:13px;text-decoration:none;font-weight:500;">
                                    Register
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div>
                {{-- Salary --}}
                @if ($job->salary_min && $job->salary_max)
                    <div class="card" style="margin-bottom:12px;background:#f0fdf4;border-color:#bbf7d0;">
                        <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Monthly Salary</div>
                        <div style="font-size:22px;font-weight:700;color:#166534;">
                            ${{ number_format($job->salary_min) }} – ${{ number_format($job->salary_max) }}
                        </div>
                        <div style="font-size:12px;color:#6b7280;margin-top:2px;">per month</div>
                    </div>
                @endif

                {{-- Job Overview --}}
                <div class="card" style="margin-bottom:12px;">
                    <div style="font-size:14px;font-weight:600;color:#111827;margin-bottom:14px;">Job Overview</div>
                    <div style="display:flex;flex-direction:column;gap:12px;font-size:13px;">
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="ti ti-calendar"
                                style="font-size:16px;color:#185FA5;margin-top:1px;flex-shrink:0;"></i>
                            <div>
                                <div style="color:#9ca3af;font-size:11px;">Date Posted</div>
                                <div style="font-weight:500;color:#111827;">{{ $job->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="ti ti-clock" style="font-size:16px;color:#185FA5;margin-top:1px;flex-shrink:0;"></i>
                            <div>
                                <div style="color:#9ca3af;font-size:11px;">Job Type</div>
                                <div style="font-weight:500;color:#111827;">{{ ucfirst($job->job_type) }}</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="ti ti-map-pin"
                                style="font-size:16px;color:#185FA5;margin-top:1px;flex-shrink:0;"></i>
                            <div>
                                <div style="color:#9ca3af;font-size:11px;">Location</div>
                                <div style="font-weight:500;color:#111827;">{{ $job->location }}</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="ti ti-chart-bar"
                                style="font-size:16px;color:#185FA5;margin-top:1px;flex-shrink:0;"></i>
                            <div>
                                <div style="color:#9ca3af;font-size:11px;">Experience</div>
                                <div style="font-weight:500;color:#111827;">{{ ucfirst($job->experience_level) }} level
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="ti ti-category"
                                style="font-size:16px;color:#185FA5;margin-top:1px;flex-shrink:0;"></i>
                            <div>
                                <div style="color:#9ca3af;font-size:11px;">Category</div>
                                <div style="font-weight:500;color:#111827;">{{ $job->category->name }}</div>
                            </div>
                        </div>
                        @if ($job->deadline)
                            <div style="display:flex;gap:10px;align-items:flex-start;">
                                <i class="ti ti-calendar-off"
                                    style="font-size:16px;color:{{ $job->deadline->isPast() ? '#dc2626' : '#185FA5' }};margin-top:1px;flex-shrink:0;"></i>
                                <div>
                                    <div style="color:#9ca3af;font-size:11px;">Deadline</div>
                                    <div
                                        style="font-weight:500;color:{{ $job->deadline->isPast() ? '#dc2626' : '#111827' }};">
                                        {{ $job->deadline->format('M d, Y') }}
                                        @if ($job->deadline->isPast())
                                            (Expired)
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($job->is_remote)
                            <div style="display:flex;gap:10px;align-items:flex-start;">
                                <i class="ti ti-home"
                                    style="font-size:16px;color:#059669;margin-top:1px;flex-shrink:0;"></i>
                                <div>
                                    <div style="color:#9ca3af;font-size:11px;">Work Style</div>
                                    <div style="font-weight:500;color:#059669;">Remote / Work from home</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Company --}}
                <div class="card" style="margin-bottom:12px;">
                    <div style="font-size:14px;font-weight:600;color:#111827;margin-bottom:14px;">About the Company</div>
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                        <div
                            style="width:44px;height:44px;border-radius:10px;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:#185FA5;flex-shrink:0;">
                            {{ strtoupper(substr($job->employer->employerProfile->company_name ?? $job->employer->name, 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#111827;">
                                {{ $job->employer->employerProfile->company_name ?? $job->employer->name }}
                            </div>
                            @if ($job->employer->employerProfile?->industry)
                                <div style="font-size:12px;color:#6b7280;">{{ $job->employer->employerProfile->industry }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @if ($job->employer->employerProfile?->company_description)
                        <p style="font-size:13px;color:#6b7280;line-height:1.7;">
                            {{ Str::limit($job->employer->employerProfile->company_description, 150) }}
                        </p>
                    @endif
                    @if ($job->employer->employerProfile?->website)
                        <a href="{{ $job->employer->employerProfile->website }}" target="_blank"
                            style="display:inline-flex;align-items:center;gap:5px;margin-top:10px;font-size:12px;color:#185FA5;text-decoration:none;">
                            <i class="ti ti-world" style="font-size:14px;"></i>
                            Visit Website
                        </a>
                    @endif
                    @if ($job->employer->employerProfile?->company_size)
                        <div style="font-size:12px;color:#6b7280;margin-top:8px;display:flex;align-items:center;gap:5px;">
                            <i class="ti ti-users" style="font-size:14px;"></i>
                            {{ $job->employer->employerProfile->company_size }} employees
                        </div>
                    @endif
                </div>

                {{-- Share --}}
                <div class="card">
                    <div style="font-size:14px;font-weight:600;color:#111827;margin-bottom:12px;">Share this Job</div>
                    <div style="display:flex;gap:8px;">
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                            target="_blank"
                            style="flex:1;text-align:center;padding:8px;border-radius:8px;background:#0077b5;color:#fff;text-decoration:none;font-size:12px;display:flex;align-items:center;justify-content:center;gap:4px;">
                            <i class="ti ti-brand-linkedin" style="font-size:16px;"></i> LinkedIn
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($job->title) }}"
                            target="_blank"
                            style="flex:1;text-align:center;padding:8px;border-radius:8px;background:#1da1f2;color:#fff;text-decoration:none;font-size:12px;display:flex;align-items:center;justify-content:center;gap:4px;">
                            <i class="ti ti-brand-twitter" style="font-size:16px;"></i> Twitter
                        </a>
                        <button
                            onclick="navigator.clipboard.writeText(window.location.href);this.innerHTML='<i class=\'ti ti-check\'></i> Copied'"
                            style="flex:1;text-align:center;padding:8px;border-radius:8px;background:#f3f4f6;color:#374151;border:1px solid #e5e7eb;font-size:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:4px;">
                            <i class="ti ti-link" style="font-size:16px;"></i> Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media(max-width:768px) {
            .job-detail-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

@endsection
