<x-app-layout>
    <x-slot name="header">
        Farm Manager Dashboard
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Welcome, {{ Auth::user()->name }}!</h3>
            <p class="text-gray-600">Gilgit-Baltistan Fisheries Management System</p>
        </div>

        @php
            $farm = Auth::user()->farm;
            $entries = $farm ? $farm->entries()->orderBy('date', 'desc')->take(5)->get() : collect();
        @endphp

        @if($farm)
            <!-- Farm Info -->
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-pakistan-green-500">
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Your Farm: {{ $farm->name }}</h4>
                <p class="text-gray-600">District: {{ $farm->district->name ?? 'N/A' }}</p>
                @if($farm->location)
                    <p class="text-sm text-gray-500 mt-1">Location: {{ $farm->location }}</p>
                @endif
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Total Entries Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-pakistan-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Entries</p>
                            <p class="text-3xl font-bold text-pakistan-green-700 mt-2">{{ $farm->entries()->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-pakistan-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-pakistan-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Last Entry Date Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-pakistan-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Last Entry</p>
                            <p class="text-2xl font-bold text-pakistan-green-700 mt-2">
                                @if($entries->count() > 0)
                                    {{ $entries->first()->date->format('M d, Y') }}
                                @else
                                    No entries yet
                                @endif
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-pakistan-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-pakistan-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Entries -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">Recent Entries</h4>
                @if($entries->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-pakistan-green-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Fish Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Feed (kg)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Mortality</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($entries as $entry)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->date->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($entry->fish_stock) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($entry->feed_quantity, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entry->mortality }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-gray-600">No entries yet. Start by adding your first daily entry!</p>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h4 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="#" class="flex items-center p-4 bg-pakistan-green-50 rounded-lg hover:bg-pakistan-green-100 transition border border-pakistan-green-200">
                        <div class="w-10 h-10 bg-pakistan-green-500 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-pakistan-green-900">Add New Entry</h5>
                            <p class="text-sm text-pakistan-green-700">Record daily farm data</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center p-4 bg-pakistan-green-50 rounded-lg hover:bg-pakistan-green-100 transition border border-pakistan-green-200">
                        <div class="w-10 h-10 bg-pakistan-green-500 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-pakistan-green-900">View All Entries</h5>
                            <p class="text-sm text-pakistan-green-700">Browse entry history</p>
                        </div>
                    </a>
                </div>
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>No farm assigned.</strong> Please contact the administrator to assign a farm to your account.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

