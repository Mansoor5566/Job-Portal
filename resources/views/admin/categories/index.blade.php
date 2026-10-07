@extends('layouts.admin')
@section('title', 'Categories')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div>
        <h1 style="font-size:18px;font-weight:700;color:#111827;">Categories</h1>
        <p style="font-size:13px;color:#6b7280;margin-top:4px;">Manage job categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">
        <i class="ti ti-plus"></i> Add Category
    </a>
</div>

<div class="card" style="padding:0;overflow:hidden;">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Icon</th>
                <th>Slug</th>
                <th>Jobs</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td style="font-weight:600;color:#111827;">{{ $cat->name }}</td>
                <td style="font-size:20px;">{{ $cat->icon ?? '—' }}</td>
                <td style="font-size:12px;color:#9ca3af;font-family:monospace;">{{ $cat->slug }}</td>
                <td>
                    <span style="font-weight:600;color:#4f46e5;">{{ $cat->jobs_count }}</span>
                    <span style="font-size:12px;color:#9ca3af;"> jobs</span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <a href="{{ route('admin.categories.edit', $cat) }}"
                           style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border:1px solid #c4b5fd;border-radius:8px;color:#6d28d9;background:#ede9fe;text-decoration:none;">
                            <i class="ti ti-edit" style="font-size:15px;"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                              onsubmit="return confirm('Delete {{ addslashes($cat->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border:1px solid #fecaca;border-radius:8px;background:#fef2f2;color:#dc2626;cursor:pointer;">
                                <i class="ti ti-trash" style="font-size:15px;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:48px;color:#9ca3af;">No categories yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:16px;">{{ $categories->links() }}</div>
@endsection