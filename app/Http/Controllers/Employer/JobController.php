<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index(Request $request)
{
    $query = Job::where('user_id', auth()->id())
                ->withCount('applications')
                ->with('applications');

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $jobs = $query->latest()->paginate(10);
    return view('employer.jobs.index', compact('jobs'));
}

    public function create()
    {
        $categories = Category::all();
        return view('employer.jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'description'      => 'required|string',
            'location'         => 'required|string|max:255',
            'job_type'         => 'required|in:full-time,part-time,contract,internship,freelance',
            'experience_level' => 'required|in:entry,mid,senior',
            'salary_min'       => 'nullable|numeric',
            'salary_max'       => 'nullable|numeric',
            'deadline'         => 'nullable|date',
            'skills_required'  => 'nullable|string',
        ]);

        $skills = null;
        if ($request->filled('skills_required')) {
            $skills = array_map('trim', explode(',', $request->skills_required));
        }

        Job::create([
            'user_id'          => auth()->id(),
            'category_id'      => $request->category_id,
            'title'            => $request->title,
            'slug'             => Str::slug($request->title) . '-' . time(),
            'description'      => $request->description,
            'location'         => $request->location,
            'is_remote'        => $request->boolean('is_remote'),
            'job_type'         => $request->job_type,
            'experience_level' => $request->experience_level,
            'salary_min'       => $request->salary_min,
            'salary_max'       => $request->salary_max,
            'skills_required'  => $skills,
            'deadline'         => $request->deadline,
            'status'           => $request->input('status', 'active'),
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job posted successfully!');
    }
  public function preview(Job $job)
{
    abort_if($job->user_id !== auth()->id(), 403);
    $job->load(['category', 'applications.seeker']);
    return view('employer.jobs.preview', compact('job'));
}
    public function edit(Job $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);
        $categories = Category::all();
        return view('employer.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, Job $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);

        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'description'      => 'required|string',
            'location'         => 'required|string|max:255',
            'job_type'         => 'required|in:full-time,part-time,contract,internship,freelance',
            'experience_level' => 'required|in:entry,mid,senior',
            'salary_min'       => 'nullable|numeric',
            'salary_max'       => 'nullable|numeric',
            'deadline'         => 'nullable|date',
        ]);

        $skills = null;
        if ($request->filled('skills_required')) {
            $skills = array_map('trim', explode(',', $request->skills_required));
        }

        $job->update([
            'category_id'      => $request->category_id,
            'title'            => $request->title,
            'slug'             => Str::slug($request->title) . '-' . time(),
            'description'      => $request->description,
            'location'         => $request->location,
            'is_remote'        => $request->boolean('is_remote'),
            'job_type'         => $request->job_type,
            'experience_level' => $request->experience_level,
            'salary_min'       => $request->salary_min,
            'salary_max'       => $request->salary_max,
            'skills_required'  => $skills,
            'deadline'         => $request->deadline,
            'status'           => $request->input('status', $job->status),
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);
        $job->delete();
        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }
}