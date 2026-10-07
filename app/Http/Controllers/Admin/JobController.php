<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['employer.employerProfile', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $jobs = $query->latest()->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        $job->load(['employer.employerProfile', 'category', 'applications.seeker']);
        return view('admin.jobs.show', compact('job'));
    }

    public function toggle(Job $job)
    {
        $newStatus = $job->status === 'active' ? 'closed' : 'active';
        $job->update(['status' => $newStatus]);
        return back()->with('success', 'Job status updated.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }
}