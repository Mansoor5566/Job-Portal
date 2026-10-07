<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\Category;

use Illuminate\Http\Request;


class JobController extends Controller
{
    public function home()
{
    $featuredJobs = Job::with(['employer.employerProfile', 'category'])
        ->where('status', 'active')
        ->where('is_featured', true)
        ->latest()
        ->take(6)
        ->get();

    $latestJobs = Job::with(['employer.employerProfile', 'category'])
        ->where('status', 'active')
        ->latest()
        ->take(8)
        ->get();

    $categories = Category::withCount(['jobs' => function ($q) {
        $q->where('status', 'active');
    }])->get();

    $totalJobs = Job::where('status', 'active')->count();

    return view('home', compact('featuredJobs', 'latestJobs', 'categories', 'totalJobs'));
}
   public function index(Request $request)
{
    $query = Job::with(['employer.employerProfile', 'category'])
        ->where('status', 'active');

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%'.$request->search.'%')
              ->orWhere('description', 'like', '%'.$request->search.'%');
        });
    }

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->filled('job_type')) {
        $query->whereIn('job_type', (array)$request->job_type);
    }

    if ($request->filled('location')) {
        $query->where('location', 'like', '%'.$request->location.'%');
    }

    if ($request->filled('experience_level')) {
        $query->where('experience_level', $request->experience_level);
    }

    if ($request->filled('is_remote')) {
        $query->where('is_remote', true);
    }

    $jobs       = $query->latest()->paginate(10);
    $categories = Category::withCount(['jobs' => function($q){
        $q->where('status','active');
    }])->get();

    return view('jobs.index', compact('jobs', 'categories'));
}

    public function show($slug)
    {
        $job = Job::with(['employer.employerProfile', 'category'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('jobs.show', compact('job'));
    }
  
}
