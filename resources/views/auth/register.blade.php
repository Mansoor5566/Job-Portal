<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — JobPortal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
     <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

{{-- LEFT PANEL --}}
<div class="left-panel">
    <a href="{{ route('home') }}" class="left-logo">
        <i class="ti ti-briefcase" aria-hidden="true"></i> JobPortal
    </a>
    <div class="left-content">
        <h2>Start your journey with us</h2>
        <p>Create a free account and take the next step in your career or find your perfect hire.</p>
        <div class="role-cards">
            <div class="role-card">
                <div class="role-card-icon"><i class="ti ti-user" aria-hidden="true"></i></div>
                <div>
                    <div class="role-card-title">Job Seekers</div>
                    <div class="role-card-desc">Browse jobs, apply in seconds, and track your applications all in one place.</div>
                </div>
            </div>
            <div class="role-card">
                <div class="role-card-icon"><i class="ti ti-building" aria-hidden="true"></i></div>
                <div>
                    <div class="role-card-title">Employers</div>
                    <div class="role-card-desc">Post jobs, manage applications, and find the best candidates for your team.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="left-footer">© {{ date('Y') }} JobPortal. All rights reserved.</div>
</div>

{{-- RIGHT PANEL --}}
<div class="right-panel">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-title">Create your account</div>
            <div class="auth-sub">It's free and takes less than a minute</div>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <i class="ti ti-alert-circle" aria-hidden="true"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Role Selector --}}
            <div style="margin-bottom:20px;">
                <label class="form-label">I want to</label>
                <div class="role-selector">
                    <label class="role-option {{ old('role','seeker')==='seeker' ? 'selected' : '' }}"
                           id="label-seeker" onclick="selectRole('seeker')">
                        <input type="radio" name="role" value="seeker"
                               {{ old('role','seeker')==='seeker' ? 'checked' : '' }}>
                        <div class="role-option-icon">
                            <i class="ti ti-search" aria-hidden="true"></i>
                        </div>
                        <div class="role-option-title">Find a Job</div>
                        <div class="role-option-desc">I'm a job seeker</div>
                    </label>
                    <label class="role-option {{ old('role')==='employer' ? 'selected' : '' }}"
                           id="label-employer" onclick="selectRole('employer')">
                        <input type="radio" name="role" value="employer"
                               {{ old('role')==='employer' ? 'checked' : '' }}>
                        <div class="role-option-icon">
                            <i class="ti ti-building" aria-hidden="true"></i>
                        </div>
                        <div class="role-option-title">Hire Talent</div>
                        <div class="role-option-desc">I'm an employer</div>
                    </label>
                </div>
                @error('role')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="name">Full name</label>
                <div class="input-wrap">
                    <i class="ti ti-user input-icon" aria-hidden="true"></i>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="form-input" placeholder="John Smith" required autofocus>
                </div>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <div class="input-wrap">
                    <i class="ti ti-mail input-icon" aria-hidden="true"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-input" placeholder="you@example.com" required>
                </div>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <i class="ti ti-lock input-icon" aria-hidden="true"></i>
                    <input type="password" id="password" name="password"
                           class="form-input" placeholder="Min. 8 characters" required>
                </div>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm password</label>
                <div class="input-wrap">
                    <i class="ti ti-lock-check input-icon" aria-hidden="true"></i>
                    <input type="password" id="password_confirmation"
                           name="password_confirmation"
                           class="form-input" placeholder="Repeat your password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="ti ti-user-plus" aria-hidden="true"></i> Create Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account?
            <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>

<script>
function selectRole(role) {
    document.getElementById('label-seeker').classList.toggle('selected', role === 'seeker');
    document.getElementById('label-employer').classList.toggle('selected', role === 'employer');
}
</script>

</body>
</html>