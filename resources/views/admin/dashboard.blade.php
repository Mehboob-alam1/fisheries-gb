<x-app-layout>
    <x-slot name="header">
        Admin Dashboard
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Welcome, {{ Auth::user()->name }}!</h3>
            <p class="text-gray-600">Gilgit-Baltistan Fisheries Management System</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Districts Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-pakistan-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Districts</p>
                        <p class="text-3xl font-bold text-pakistan-green-700 mt-2">{{ \App\Models\District::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-pakistan-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-pakistan-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 002 2h2.945M15 11a3 3 0 11-6 0M15 11a3 3 0 00-6 0m6 0a3 3 0 01-3 3m-3-3a3 3 0 013-3m0 0a3 3 0 013 3m-3 3a3 3 0 01-3-3"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Farms Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-pakistan-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Farms</p>
                        <p class="text-3xl font-bold text-pakistan-green-700 mt-2">{{ \App\Models\Farm::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-pakistan-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-pakistan-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Managers Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-pakistan-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Managers</p>
                        <p class="text-3xl font-bold text-pakistan-green-700 mt-2">{{ \App\Models\User::where('role', 'manager')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-pakistan-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-pakistan-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.districts.index') }}" class="flex items-center p-4 bg-pakistan-green-50 rounded-lg hover:bg-pakistan-green-100 transition border border-pakistan-green-200">
                    <div class="w-10 h-10 bg-pakistan-green-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 002 2h2.945M15 11a3 3 0 11-6 0M15 11a3 3 0 00-6 0m6 0a3 3 0 01-3 3m-3-3a3 3 0 013-3m0 0a3 3 0 013 3m-3 3a3 3 0 01-3-3"></path>
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-semibold text-pakistan-green-900">Manage Districts</h5>
                        <p class="text-sm text-pakistan-green-700">Create and manage districts</p>
                    </div>
                </a>
                <a href="{{ route('admin.farms.index') }}" class="flex items-center p-4 bg-pakistan-green-50 rounded-lg hover:bg-pakistan-green-100 transition border border-pakistan-green-200">
                    <div class="w-10 h-10 bg-pakistan-green-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-semibold text-pakistan-green-900">Manage Farms</h5>
                        <p class="text-sm text-pakistan-green-700">View and manage all farms</p>
                    </div>
                </a>
                <a href="{{ route('admin.managers.index') }}" class="flex items-center p-4 bg-pakistan-green-50 rounded-lg hover:bg-pakistan-green-100 transition border border-pakistan-green-200">
                    <div class="w-10 h-10 bg-pakistan-green-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-semibold text-pakistan-green-900">Manage Farm Managers</h5>
                        <p class="text-sm text-pakistan-green-700">Create managers and view credentials</p>
                    </div>
                </a>
                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="w-10 h-10 bg-gray-400 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-700">View Reports</h5>
                        <p class="text-sm text-gray-500">Coming soon</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

