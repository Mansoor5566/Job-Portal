<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // All applications for employer's jobs
    public function index(Request $request)
    {
        $jobIds = Job::where('user_id', auth()->id())->pluck('id');

        $query = Application::with(['job', 'seeker.seekerProfile'])
            ->whereIn('job_id', $jobIds);

        // Filter by job
        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(15);
        $jobs = Job::where('user_id', auth()->id())->get();

        return view('employer.applications.index', compact('applications', 'jobs'));
    }

    // View single application
    public function show(Application $application)
    {
        // Make sure this application belongs to employer's job
        abort_if($application->job->user_id !== auth()->id(), 403);

        // Mark as viewed
        if ($application->status === 'applied') {
            $application->update(['status' => 'viewed']);
        }

        return view('employer.applications.show', compact('application'));
    }

    // Update application status
    public function updateStatus(Request $request, Application $application)
    {
        abort_if($application->job->user_id !== auth()->id(), 403);

        $request->validate([
            'status' => 'required|in:viewed,shortlisted,rejected,hired'
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated.');
    }
}