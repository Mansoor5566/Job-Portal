<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get employer's job IDs
        $jobIds = Job::where('user_id', $userId)->pluck('id');

        // Top-level stats
        $totalJobs         = Job::where('user_id', $userId)->count();
        $activeJobs        = Job::where('user_id', $userId)->where('status', 'active')->count();
        $totalApplications = Application::whereIn('job_id', $jobIds)->count();
        $shortlisted       = Application::whereIn('job_id', $jobIds)->where('status', 'shortlisted')->count();
        $hired             = Application::whereIn('job_id', $jobIds)->where('status', 'hired')->count();
        $rejected          = Application::whereIn('job_id', $jobIds)->where('status', 'rejected')->count();

        // Applications per week (last 7 weeks)
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end   = now()->subWeeks($i)->endOfWeek();
            $weeklyData[] = [
                'week'         => $start->format('M d'),
                'applications' => Application::whereIn('job_id', $jobIds)
                    ->whereBetween('created_at', [$start, $end])->count(),
                'shortlisted'  => Application::whereIn('job_id', $jobIds)
                    ->where('status', 'shortlisted')
                    ->whereBetween('created_at', [$start, $end])->count(),
            ];
        }

        // Status breakdown
        $statusBreakdown = Application::whereIn('job_id', $jobIds)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Top jobs by applications
        $topJobs = Job::where('user_id', $userId)
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->take(5)
            ->get();

        return view('employer.analytics', compact(
            'totalJobs', 'activeJobs', 'totalApplications',
            'shortlisted', 'hired', 'rejected',
            'weeklyData', 'statusBreakdown', 'topJobs'
        ));
    }
}