<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->seekerProfile;
        return view('seeker.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone'            => 'nullable|string|max:20',
            'location'         => 'nullable|string|max:255',
            'bio'              => 'nullable|string|max:1000',
            'experience_level' => 'nullable|in:entry,mid,senior',
            'skills'           => 'nullable|string',
            'profile_photo'    => 'nullable|image|max:1024',
            'resume'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $profile = auth()->user()->seekerProfile;
        $data    = $request->only(['phone', 'location', 'bio', 'experience_level']);

        if ($request->filled('skills')) {
            $data['skills'] = array_map('trim', explode(',', $request->skills));
        }

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')
                ->store('photos', 'public');
        }

        if ($request->hasFile('resume')) {
            $data['resume'] = $request->file('resume')
                ->store('resumes', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}