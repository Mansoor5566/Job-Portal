<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['seekerProfile', 'employerProfile', 'applications', 'jobs']);
        return view('admin.users.show', compact('user'));
    }

    public function toggle(User $user)
{
    $user->update(['is_active' => !$user->is_active]);

    // Verify it saved
    $user->refresh();
    $status = $user->is_active ? 'activated' : 'deactivated';

    return back()->with('success', "User {$status} successfully.");
}
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}