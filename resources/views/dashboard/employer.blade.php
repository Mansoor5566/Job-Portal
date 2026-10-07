<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Employer Dashboard</h2>
    </x-slot>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-700">Welcome, {{ auth()->user()->name }}!</p>
            <div class="mt-4 flex gap-3">
                <a href="{{ route('employer.jobs.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    + Post a Job
                </a>
                <a href="{{ route('employer.jobs.index') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                    My Listings
                </a>
                <a href="{{ route('employer.applications.index') }}"
                    class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 text-sm">
                    Applications
                </a>
                <a href="{{ route('employer.analytics') }}"
                    class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 text-sm">
                    📊 Analytics
                </a>
                <a href="{{ route('employer.profile.edit') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm">
                    Company Profile
                </a>
            </div>
        </div>
    </div>
</x-app-layout>