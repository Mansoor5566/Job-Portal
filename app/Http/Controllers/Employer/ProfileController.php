<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->employerProfile;
        return view('employer.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name'        => 'required|string|max:255',
            'company_description' => 'nullable|string|max:2000',
            'website'             => 'nullable|url|max:255',
            'industry'            => 'nullable|string|max:255',
            'company_size'        => 'nullable|string|max:50',
            'location'            => 'nullable|string|max:255',
            'company_logo'        => 'nullable|image|max:1024',
        ]);

        $profile = auth()->user()->employerProfile;
        $data    = $request->only([
            'company_name', 'company_description', 'website',
            'industry', 'company_size', 'location'
        ]);

        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $request->file('company_logo')
                ->store('logos', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Company profile updated!');
    }
}