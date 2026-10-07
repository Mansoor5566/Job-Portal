@extends('layouts.admin')
@section('title', 'Add Category')

@section('content')
<div style="margin-bottom:20px;">
    <a href="{{ route('admin.categories.index') }}"
       style="font-size:13px;color:#6b7280;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
        <i class="ti ti-arrow-left"></i> Back to Categories
    </a>
</div>

<div style="max-width:480px;">
    <div class="card">
        <div class="card-title">Add New Category</div>
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="e.g. Information Technology" required>
            </div>
            <div class="form-group">
                <label class="form-label">Icon (emoji)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="form-input" placeholder="e.g. 💻">
                <div class="form-hint">Use an emoji as the category icon</div>
            </div>
            <div style="display:flex;gap:10px;margin-top:20px;">
                <button type="submit" class="btn-primary">
                    <i class="ti ti-plus"></i> Create Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection