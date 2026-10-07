@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div>
        <h1 style="font-size:18px;font-weight:700;color:#111827;">All Users</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">Manage seekers, employers and admins</p>
    </div>
</div>

<div class="card" style="margin-bottom:16px;padding:16px 20px;">
    <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
        <div style="position:relative;flex:1;min-width:200px;">
            <i class="ti ti-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:15px;"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search name or email"
                   class="form-input" style="padding-left:32px;">
        </div>
        <select name="role" class="form-select" style="width:150px;">
            <option value="">All Roles</option>
            <option value="seeker"   {{ request('role')==='seeker'   ?'selected':'' }}>Seeker</option>
            <option value="employer" {{ request('role')==='employer' ?'selected':'' }}>Employer</option>
            <option value="admin"    {{ request('role')==='admin'    ?'selected':'' }}>Admin</option>
        </select>
        <button type="submit" class="btn-primary"><i class="ti ti-filter"></i> Filter</button>
        <a href="{{ route('admin.users.index') }}" class="btn-outline">Clear</a>
    </form>
</div>

<div class="card" style="padding:0;overflow:hidden;">
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:36px;height:36px;border-radius:50%;background:#ede9fe;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#6d28d9;flex-shrink:0;">
                            {{ strtoupper(substr($user->name,0,2)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;color:#111827;">{{ $user->name }}</div>
                            <div style="font-size:12px;color:#9ca3af;">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                <td>
                    <span class="badge {{ $user->is_active ? 'badge-active' : 'badge-banned' }}">
                        {{ $user->is_active ? 'Active' : 'Banned' }}
                    </span>
                </td>
                <td style="font-size:12px;color:#6b7280;">{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <a href="{{ route('admin.users.show', $user) }}"
                           style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border:1px solid #e5e7eb;border-radius:8px;color:#6b7280;text-decoration:none;">
                            <i class="ti ti-eye" style="font-size:15px;"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;cursor:pointer;border:1px solid {{ $user->is_active ? '#fecaca' : '#bbf7d0' }};background:{{ $user->is_active ? '#fef2f2' : '#f0fdf4' }};color:{{ $user->is_active ? '#dc2626' : '#166534' }};"
                                    title="{{ $user->is_active ? 'Ban user' : 'Activate user' }}">
                                <i class="ti ti-{{ $user->is_active ? 'ban' : 'check' }}" style="font-size:15px;"></i>
                            </button>
                        </form>
                        @if($user->role !== 'admin')
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border:1px solid #fecaca;border-radius:8px;background:#fef2f2;color:#dc2626;cursor:pointer;">
                                <i class="ti ti-trash" style="font-size:15px;"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:48px;color:#9ca3af;">
                    <i class="ti ti-users-off" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                    No users found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:16px;">{{ $users->withQueryString()->links() }}</div>
@endsection