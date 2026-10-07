<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index(Request $request)
{
    $user = $request->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isEmployer()) {
        return redirect()->route('employer.analytics');
    } else {
        return redirect()->route('seeker.dashboard');
    }
}
}