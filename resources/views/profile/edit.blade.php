@extends(auth()->user()->isEmployer() ? 'layouts.employer' : 'layouts.seeker')
@section('title', 'Account Settings')

@section('content')
<div style="max-width:700px;">
    <div style="margin-bottom:20px;">
        <h1 style="font-size:18px;font-weight:700;color:#111827;">Account Settings</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">Manage your login email, name and password.</p>
    </div>

    {{-- Update Name & Email --}}
    <div class="card" style="margin-bottom:16px;">
        <div class="card-title">Profile Information</div>

        @if(session('status') === 'profile-updated')
            <div class="alert-success" style="margin-bottom:16px;">
                <i class="ti ti-circle-check"></i> Profile updated successfully.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                       class="form-input" required>
                @error('name')
                    <div style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                       class="form-input" required>
                @error('email')
                    <div style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn-primary">
                <i class="ti ti-check"></i> Save Changes
            </button>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="card" style="margin-bottom:16px;">
        <div class="card-title">Change Password</div>

        @if(session('status') === 'password-updated')
            <div class="alert-success" style="margin-bottom:16px;">
                <i class="ti ti-circle-check"></i> Password updated successfully.
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-input">
                @error('current_password')
                    <div style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-input">
                @error('password')
                    <div style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-input">
            </div>
            <button type="submit" class="btn-primary">
                <i class="ti ti-lock"></i> Update Password
            </button>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="card" style="border:1px solid #fecaca;">
        <div class="card-title" style="color:#dc2626;">
            <span><i class="ti ti-alert-triangle"></i> Danger Zone</span>
        </div>
        <p style="font-size:13px;color:#6b7280;margin-bottom:16px;">
            Once you delete your account, all your data including job listings and applications will be permanently removed. This action cannot be undone.
        </p>
        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Are you absolutely sure? This cannot be undone.')">
            @csrf @method('DELETE')
            <div class="form-group">
                <label class="form-label">Enter your password to confirm</label>
                <input type="password" name="password" class="form-input"
                       placeholder="Your current password" style="max-width:300px;">
                @error('password', 'userDeletion')
                    <div style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" style="background:#dc2626;color:#fff;border:none;padding:9px 18px;border-radius:8px;font-size:13px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                <i class="ti ti-trash"></i> Delete My Account
            </button>
        </form>
    </div>
</div>
@endsection