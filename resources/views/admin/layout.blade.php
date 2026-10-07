<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — JobPortal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-indigo-800 text-white flex flex-col">
        <div class="p-6 text-xl font-bold border-b border-indigo-700">
            💼 Admin Panel
        </div>
        <nav class="flex-1 p-4 space-y-1 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded hover:bg-indigo-700 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : '' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="block px-4 py-2 rounded hover:bg-indigo-700 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-700' : '' }}">
                👥 Users
            </a>
            <a href="{{ route('admin.jobs.index') }}"
               class="block px-4 py-2 rounded hover:bg-indigo-700 {{ request()->routeIs('admin.jobs.*') ? 'bg-indigo-700' : '' }}">
                💼 Jobs
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="block px-4 py-2 rounded hover:bg-indigo-700 {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-700' : '' }}">
                🏷️ Categories
            </a>
        </nav>
        <div class="p-4 border-t border-indigo-700 text-xs text-indigo-300">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:text-white">← Logout</button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-gray-700">@yield('title', 'Dashboard')</h1>
            <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
        </header>
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>