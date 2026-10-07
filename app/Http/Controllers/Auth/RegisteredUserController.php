<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SeekerProfile;
use App\Models\EmployerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:seeker,employer'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create empty profile based on role
        if ($request->role === 'employer') {
            EmployerProfile::create(['user_id' => $user->id, 'company_name' => '']);
        } else {
            SeekerProfile::create(['user_id' => $user->id]);
        }

        event(new Registered($user));
        Auth::login($user);

        $role = $user->role;

        if ($role === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($role === 'employer') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }
}
