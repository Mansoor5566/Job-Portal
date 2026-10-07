<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Show all applications for logged-in seeker
   public function index(Request $request)
{
    $query = Application::with(['job.employer.employerProfile','job.category'])
        ->where('user_id', auth()->id());

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $applications = $query->latest()->paginate(10);
    return view('seeker.applications', compact('applications'));
}

    // Submit application
 public function store(Request $request, Job $job)
{
    // Check job is still active
    if ($job->status !== 'active') {
        return back()->with('error', 'This job listing is no longer accepting applications.');
    }

    // Check deadline not passed
    if ($job->deadline && $job->deadline->isPast()) {
        return back()->with('error', 'The application deadline for this job has passed.');
    }

    // Check if already applied
    $already = Application::where('job_id', $job->id)
        ->where('user_id', auth()->id())
        ->exists();

    if ($already) {
        return back()->with('error', 'You have already applied for this job.');
    }

    $request->validate([
        'cover_letter'  => 'nullable|string|max:2000',
        'resume'        => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'resume_option' => 'nullable|in:profile,new',
    ]);

    // Determine which resume to use
    $resumePath = null;

    if ($request->hasFile('resume')) {
        // Seeker uploaded a new resume
        $resumePath = $request->file('resume')->store('resumes', 'public');
    } elseif ($request->resume_option === 'profile') {
        // Use resume from seeker profile
        $resumePath = auth()->user()->seekerProfile->resume ?? null;
    }

    Application::create([
        'job_id'       => $job->id,
        'user_id'      => auth()->id(),
        'cover_letter' => $request->cover_letter,
        'resume'       => $resumePath,
        'status'       => 'applied',
    ]);

    return back()->with('success', 'Application submitted successfully!');
}
}