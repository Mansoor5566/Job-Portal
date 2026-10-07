<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_seekers'     => User::where('role', 'seeker')->count(),
            'total_employers'   => User::where('role', 'employer')->count(),
            'total_jobs'        => Job::count(),
            'active_jobs'       => Job::where('status', 'active')->count(),
            'total_applications'=> Application::count(),
            'total_categories'  => Category::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentJobs  = Job::with('employer')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentJobs'));
    }
}