<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalApps   = auth()->user()->applications()->count();
        $pendingApps = auth()->user()->applications()->where('status','applied')->count();
        $shortlisted = auth()->user()->applications()->where('status','shortlisted')->count();
        $hired       = auth()->user()->applications()->where('status','hired')->count();
        $recentApps  = auth()->user()->applications()
                            ->with(['job.employer.employerProfile','job.category'])
                            ->latest()->take(5)->get();

        return view('dashboard.seeker', compact(
            'totalApps','pendingApps','shortlisted','hired','recentApps'
        ));
    }
}