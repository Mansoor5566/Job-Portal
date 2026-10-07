@extends('layouts.public')
@section('title', 'Browse Jobs')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:18px;font-weight:700;color:#111827;">Browse Jobs</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">
            <span style="font-weight:600;color:#185FA5;">{{ $jobs->total() }}</span> jobs found
            @if(request('search')) for "<strong>{{ request('search') }}</strong>" @endif
        </p>
    </div>
</div>

<div class="filter-sidebar-wrap">

    {{-- FILTERS SIDEBAR --}}
   <div id="filterToggleBtn" style="display:none;width:100%;margin-bottom:10px;">
    <button onclick="document.getElementById('filterSidebar').classList.toggle('open')"
            style="width:100%;background:#185FA5;color:#fff;border:none;padding:10px;border-radius:8px;font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;">
            <i class="ti ti-filter"></i> Show / Hide Filters
        </button>
    </div>

    <aside id="filterSidebar" style="width:250px;flex-shrink:0;">
        <form method="GET" action="{{ route('jobs.index') }}">

            {{-- Search --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px;margin-bottom:12px;">
                <div style="font-size:13px;font-weight:600;color:#111827;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                    <i class="ti ti-search" style="color:#185FA5;"></i> Keyword
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Title or skill"
                    style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:9px 12px;font-size:13px;outline:none;color:#111827;">
            </div>

            {{-- Location --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px;margin-bottom:12px;">
                <div style="font-size:13px;font-weight:600;color:#111827;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                    <i class="ti ti-map-pin" style="color:#185FA5;"></i> Location
                </div>
                <input type="text" name="location" value="{{ request('location') }}"
                    placeholder="City or country"
                    style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:9px 12px;font-size:13px;outline:none;color:#111827;">
                <label style="display:flex;align-items:center;gap:8px;margin-top:10px;font-size:13px;color:#374151;cursor:pointer;">
                    <input type="checkbox" name="is_remote" value="1"
                        {{ request('is_remote') ? 'checked' : '' }}
                        style="accent-color:#185FA5;">
                    Remote only
                </label>
            </div>

            {{-- Category --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px;margin-bottom:12px;">
                <div style="font-size:13px;font-weight:600;color:#111827;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                    <i class="ti ti-category" style="color:#185FA5;"></i> Category
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;max-height:200px;overflow-y:auto;">
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#374151;cursor:pointer;">
                        <input type="radio" name="category" value=""
                            {{ !request('category') ? 'checked' : '' }}
                            style="accent-color:#185FA5;"> All Categories
                    </label>
                    @foreach($categories as $cat)
                    <label style="display:flex;align-items:center;justify-content:space-between;font-size:13px;color:#374151;cursor:pointer;">
                        <span style="display:flex;align-items:center;gap:8px;">
                            <input type="radio" name="category" value="{{ $cat->id }}"
                                {{ request('category') == $cat->id ? 'checked' : '' }}
                                style="accent-color:#185FA5;">
                            {{ $cat->name }}
                        </span>
                        <span style="font-size:11px;color:#9ca3af;">{{ $cat->jobs_count }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Job Type --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px;margin-bottom:12px;">
                <div style="font-size:13px;font-weight:600;color:#111827;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                    <i class="ti ti-clock" style="color:#185FA5;"></i> Job Type
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach(['full-time'=>'Full-time','part-time'=>'Part-time','contract'=>'Contract','internship'=>'Internship','freelance'=>'Freelance'] as $val => $label)
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#374151;cursor:pointer;">
                        <input type="checkbox" name="job_type[]" value="{{ $val }}"
                            {{ in_array($val, (array)request('job_type')) ? 'checked' : '' }}
                            style="accent-color:#185FA5;">
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Experience --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px;margin-bottom:12px;">
                <div style="font-size:13px;font-weight:600;color:#111827;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                    <i class="ti ti-chart-bar" style="color:#185FA5;"></i> Experience
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach(['entry'=>'Entry Level','mid'=>'Mid Level','senior'=>'Senior Level'] as $val => $label)
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#374151;cursor:pointer;">
                        <input type="radio" name="experience_level" value="{{ $val }}"
                            {{ request('experience_level') === $val ? 'checked' : '' }}
                            style="accent-color:#185FA5;">
                        {{ $label }}
                    </label>
                    @endforeach
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#374151;cursor:pointer;">
                        <input type="radio" name="experience_level" value=""
                            {{ !request('experience_level') ? 'checked' : '' }}
                            style="accent-color:#185FA5;"> Any Level
                    </label>
                </div>
            </div>

            <button type="submit"
                style="width:100%;background:#185FA5;color:#fff;border:none;padding:11px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                <i class="ti ti-filter"></i> Apply Filters
            </button>
            <a href="{{ route('jobs.index') }}"
                style="display:block;text-align:center;font-size:13px;color:#6b7280;margin-top:10px;text-decoration:none;">
                Clear all filters
            </a>
        </form>
    </aside>

    {{-- JOB LISTINGS --}}
    <div style="flex:1;min-width:0;">

        {{-- Sort Bar --}}
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:12px 16px;margin-bottom:14px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                @foreach(['','full-time','part-time','remote','contract'] as $quickFilter)
                @php
                $label = $quickFilter === '' ? 'All' : ($quickFilter === 'remote' ? 'Remote' : ucfirst($quickFilter));
                $isActive = $quickFilter === '' ? !request('job_type') && !request('is_remote') : (request('job_type') === $quickFilter || ($quickFilter === 'remote' && request('is_remote')));
                @endphp
                <a href="{{ $quickFilter === '' ? route('jobs.index') : ($quickFilter === 'remote' ? route('jobs.index', ['is_remote'=>1]) : route('jobs.index', ['job_type'=>$quickFilter])) }}"
                    style="font-size:12px;padding:5px 14px;border-radius:50px;text-decoration:none;
                           {{ $isActive ? 'background:#185FA5;color:#fff;border:1px solid #185FA5;' : 'background:#fff;color:#6b7280;border:1px solid #e5e7eb;' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
            <div style="font-size:13px;color:#6b7280;">
                {{ $jobs->firstItem() ?? 0 }}–{{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
            </div>
        </div>

        {{-- Job Cards --}}
        <div style="display:flex;flex-direction:column;gap:10px;">
            @forelse($jobs as $job)
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px 22px;transition:all 0.15s;{{ $job->is_featured ? 'border-left:3px solid #185FA5;' : '' }}"
                onmouseover="this.style.borderColor='#185FA5';this.style.boxShadow='0 4px 20px rgba(24,95,165,0.08)'"
                @php
                $borderColor=$job->is_featured ? '#185FA5' : '#e5e7eb';
                @endphp

                <div
                    onmouseout="this.style.borderColor='{{ $borderColor }}'; this.style.boxShadow='none'">

                   <div class="job-card-inner" style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;">
                        {{-- Left --}}
                        <div style="display:flex;gap:14px;align-items:flex-start;flex:1;min-width:0;">
                            <div style="width:48px;height:48px;border-radius:10px;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:#185FA5;flex-shrink:0;">
                                {{ strtoupper(substr($job->employer->employerProfile->company_name ?? $job->employer->name, 0, 2)) }}
                            </div>
                            <div style="min-width:0;">
                                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                    <a href="{{ route('jobs.show', $job->slug) }}"
                                        style="font-size:15px;font-weight:700;color:#111827;text-decoration:none;">
                                        {{ $job->title }}
                                    </a>
                                    @if($job->is_featured)
                                    <span style="font-size:10px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;padding:2px 8px;border-radius:50px;font-weight:600;white-space:nowrap;">
                                        FEATURED
                                    </span>
                                    @endif
                                </div>
                                <div style="font-size:13px;color:#6b7280;margin-top:3px;display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                    <span style="font-weight:500;">{{ $job->employer->employerProfile->company_name ?? $job->employer->name }}</span>
                                    <span style="color:#d1d5db;">·</span>
                                    <i class="ti ti-map-pin" style="font-size:12px;"></i>
                                    <span>{{ $job->location }}</span>
                                    @if($job->is_remote)
                                    <span style="color:#d1d5db;">·</span>
                                    <span style="color:#059669;font-weight:500;">Remote</span>
                                    @endif
                                </div>
                                <div style="margin-top:10px;display:flex;gap:6px;flex-wrap:wrap;">
                                    <span style="font-size:11px;padding:3px 10px;border-radius:6px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">
                                        {{ ucfirst($job->job_type) }}
                                    </span>
                                    <span style="font-size:11px;padding:3px 10px;border-radius:6px;background:#f3f4f6;color:#4b5563;border:1px solid #e5e7eb;">
                                        {{ $job->category->name }}
                                    </span>
                                    <span style="font-size:11px;padding:3px 10px;border-radius:6px;background:#f5f3ff;color:#6d28d9;border:1px solid #ddd6fe;">
                                        {{ ucfirst($job->experience_level) }}
                                    </span>
                                    @if($job->deadline)
                                    <span style="font-size:11px;padding:3px 10px;border-radius:6px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;">
                                        <i class="ti ti-clock" style="font-size:10px;"></i>
                                        {{ $job->deadline->format('M d') }}
                                    </span>
                                    @endif
                                </div>
                                @if($job->skills_required)
                                <div style="margin-top:8px;display:flex;gap:4px;flex-wrap:wrap;">
                                    @foreach(array_slice($job->skills_required, 0, 4) as $skill)
                                    <span style="font-size:11px;padding:2px 8px;border-radius:4px;background:#f9fafb;color:#6b7280;border:1px solid #f3f4f6;">
                                        {{ $skill }}
                                    </span>
                                    @endforeach
                                    @if(count($job->skills_required) > 4)
                                    <span style="font-size:11px;color:#9ca3af;">+{{ count($job->skills_required)-4 }}</span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Right --}}
                        <div style="text-align:right;flex-shrink:0;">
                            @if($job->salary_min && $job->salary_max)
                            <div style="font-size:15px;font-weight:700;color:#111827;">
                                ${{ number_format($job->salary_min) }}–${{ number_format($job->salary_max) }}
                            </div>
                            <div style="font-size:11px;color:#9ca3af;">per month</div>
                            @endif
                            <div style="font-size:11px;color:#9ca3af;margin-top:4px;">
                                {{ $job->created_at->diffForHumans() }}
                            </div>
                            <div style="margin-top:12px;display:flex;gap:6px;justify-content:flex-end;">
                                @auth
                                @if(auth()->user()->isSeeker())
                                @php $applied = auth()->user()->applications()->where('job_id',$job->id)->exists(); @endphp
                                @if($applied)
                                <span style="font-size:12px;padding:7px 14px;border-radius:8px;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;display:inline-flex;align-items:center;gap:4px;">
                                    <i class="ti ti-check" style="font-size:13px;"></i> Applied
                                </span>
                                @else
                                <a href="{{ route('jobs.show', $job->slug) }}"
                                    style="font-size:12px;padding:7px 14px;border-radius:8px;background:#185FA5;color:#fff;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
                                    Apply Now
                                </a>
                                @endif
                                @endif
                                @else
                                <a href="{{ route('jobs.show', $job->slug) }}"
                                    style="font-size:12px;padding:7px 14px;border-radius:8px;background:#185FA5;color:#fff;text-decoration:none;">
                                    View Job
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:60px;text-align:center;">
                    <i class="ti ti-search-off" style="font-size:40px;color:#d1d5db;display:block;margin-bottom:12px;"></i>
                    <p style="color:#6b7280;font-size:14px;">No jobs found matching your criteria.</p>
                    <a href="{{ route('jobs.index') }}"
                        style="display:inline-flex;align-items:center;gap:6px;margin-top:16px;background:#185FA5;color:#fff;padding:9px 20px;border-radius:8px;font-size:13px;text-decoration:none;">
                        Clear Filters
                    </a>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div style="margin-top:20px;">{{ $jobs->withQueryString()->links() }}</div>
        </div>
    </div>

    {{-- Responsive --}}
    <style>
        .filter-sidebar-wrap {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        @media(max-width: 768px) {
            .filter-sidebar-wrap {
                flex-direction: column;
            }

            #filterToggleBtn {
                display: block !important;
            }

            #filterSidebar {
                display: none;
                width: 100% !important;
            }

            #filterSidebar.open {
                display: block !important;
            }

            .job-right-col {
                flex-direction: column !important;
            }

            .job-actions {
                justify-content: flex-start !important;
                margin-top: 10px;
            }

            .quick-filters {
                overflow-x: auto;
                flex-wrap: nowrap !important;
                padding-bottom: 4px;
            }
        }

        @media(max-width: 480px) {
            .page-content {
                padding: 1rem !important;
            }

            .job-card-inner {
                flex-direction: column !important;
            }

            .job-right {
                text-align: left !important;
            }
        }
    </style>
  

    @endsection