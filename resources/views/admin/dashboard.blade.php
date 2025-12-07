<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <!-- Districts Card -->
                        <div class="bg-blue-50 dark:bg-blue-900 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Total Districts</h4>
                            <p class="text-3xl font-bold">{{ \App\Models\District::count() }}</p>
                        </div>

                        <!-- Farms Card -->
                        <div class="bg-green-50 dark:bg-green-900 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Total Farms</h4>
                            <p class="text-3xl font-bold">{{ \App\Models\Farm::count() }}</p>
                        </div>

                        <!-- Managers Card -->
                        <div class="bg-purple-50 dark:bg-purple-900 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Total Managers</h4>
                            <p class="text-3xl font-bold">{{ \App\Models\User::where('role', 'manager')->count() }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-xl font-semibold mb-4">Quick Actions</h4>
                        <div class="space-y-2">
                            <p class="text-gray-600 dark:text-gray-400">• Manage Districts</p>
                            <p class="text-gray-600 dark:text-gray-400">• Manage Farms</p>
                            <p class="text-gray-600 dark:text-gray-400">• Manage Users</p>
                            <p class="text-gray-600 dark:text-gray-400">• View Reports</p>
                        </div>
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                            These features will be implemented in the next phase.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

