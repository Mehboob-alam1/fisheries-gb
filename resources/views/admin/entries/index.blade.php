<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                All Farm Entries
            </h2>
            <a href="{{ route('admin.entries.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create New Entry
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Filters Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filters</h3>
                    <form method="GET" action="{{ route('admin.entries.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- District Filter -->
                        <div>
                            <label for="district_id" class="block text-sm font-medium text-gray-700 mb-2">
                                District
                            </label>
                            <select name="district_id" id="district_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500"
                                    onchange="this.form.submit()">
                                <option value="">All Districts</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Farm Filter -->
                        <div>
                            <label for="farm_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Farm
                            </label>
                            <select name="farm_id" id="farm_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500">
                                <option value="">All Farms</option>
                                @foreach($farms as $farm)
                                    <option value="{{ $farm->id }}" {{ request('farm_id') == $farm->id ? 'selected' : '' }}>
                                        {{ $farm->name }} ({{ $farm->district->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">
                                From Date
                            </label>
                            <input type="date" 
                                   name="date_from" 
                                   id="date_from" 
                                   value="{{ request('date_from') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">
                                To Date
                            </label>
                            <input type="date" 
                                   name="date_to" 
                                   id="date_to" 
                                   value="{{ request('date_to') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500">
                        </div>

                        <!-- Filter Buttons -->
                        <div class="md:col-span-4 flex items-end space-x-2">
                            <button type="submit" 
                                    class="px-4 py-2 bg-pakistan-green-600 text-white rounded-md hover:bg-pakistan-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.entries.index') }}" 
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-pakistan-green-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Entries</p>
                            <p class="text-3xl font-bold text-pakistan-green-700 mt-2">{{ $entries->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-pakistan-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-pakistan-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Farms</p>
                            <p class="text-3xl font-bold text-blue-700 mt-2">{{ $farms->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Districts</p>
                            <p class="text-3xl font-bold text-purple-700 mt-2">{{ $districts->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 002 2h2.945M15 11a3 3 0 11-6 0M15 11a3 3 0 00-6 0m6 0a3 3 0 01-3 3m-3-3a3 3 0 013-3m0 0a3 3 0 013 3m-3 3a3 3 0 01-3-3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Entries Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                @if($entries->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-pakistan-green-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Added At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">District</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Farm</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Manager</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Fish Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Feed (kg)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Mortality</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Water Temp</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($entries as $entry)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $entry->date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $entry->created_at->format('M d, Y h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->farm->district->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->farm->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $entry->farm->manager->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($entry->fish_stock) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($entry->feed_quantity, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($entry->mortality) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->water_temp ? number_format($entry->water_temp, 1) . '°C' : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('admin.entries.show', $entry) }}" 
                                                   class="text-pakistan-green-600 hover:text-pakistan-green-900">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.entries.edit', $entry) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.entries.destroy', $entry) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $entries->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No entries found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or check back later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

