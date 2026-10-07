<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — JobPortal</title>
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
            <h2>Welcome back to your career hub</h2>
            <p>Sign in to access thousands of job opportunities and connect with top employers.</p>
            <div class="left-features">
                <div class="feature-item">
                    <div class="feature-icon"><i class="ti ti-search" aria-hidden="true"></i></div>
                    <div class="feature-text">Browse thousands of active job listings</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="ti ti-send" aria-hidden="true"></i></div>
                    <div class="feature-text">Apply with one click and track your applications</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="ti ti-building" aria-hidden="true"></i></div>
                    <div class="feature-text">Connect with top employers across all industries</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="ti ti-bell" aria-hidden="true"></i></div>
                    <div class="feature-text">Get notified when your application status changes</div>
                </div>
            </div>
        </div>
        <div class="left-footer">© {{ date('Y') }} JobPortal. All rights reserved.</div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-title">Sign in to your account</div>
                <div class="auth-sub">Enter your credentials to continue</div>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="ti ti-alert-circle" aria-hidden="true"></i>
                    {{ $errors->first() }}
                </div>
            @endif
           
            @if (session('status'))
                <div
                    style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:20px;">
                    {{ session('status') }}
                </div>
            @endif
             @if (session('error'))
                <div class="alert-error" style="margin-bottom:20px;">
                    <i class="ti ti-ban" aria-hidden="true"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email address</label>
                    <div class="input-wrap">
                        <i class="ti ti-mail input-icon" aria-hidden="true"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="form-input" placeholder="you@example.com" required autofocus>
                    </div>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrap">
                        <i class="ti ti-lock input-icon" aria-hidden="true"></i>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Your password" required>
                    </div>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    <i class="ti ti-login" aria-hidden="true"></i> Sign In
                </button>
            </form>

            <div class="auth-footer">
                Don't have an account?
                <a href="{{ route('register') }}">Create one free</a>
            </div>
        </div>
    </div>

</body>

</html>
