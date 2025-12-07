<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Farm Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    
                    @php
                        $farm = Auth::user()->farm;
                        $entries = $farm ? $farm->entries()->orderBy('date', 'desc')->take(5)->get() : collect();
                    @endphp

                    @if($farm)
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold mb-2">Your Farm: {{ $farm->name }}</h4>
                            <p class="text-gray-600 dark:text-gray-400">District: {{ $farm->district->name ?? 'N/A' }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Total Entries Card -->
                            <div class="bg-blue-50 dark:bg-blue-900 p-6 rounded-lg">
                                <h4 class="text-lg font-semibold mb-2">Total Entries</h4>
                                <p class="text-3xl font-bold">{{ $farm->entries()->count() }}</p>
                            </div>

                            <!-- Last Entry Date Card -->
                            <div class="bg-green-50 dark:bg-green-900 p-6 rounded-lg">
                                <h4 class="text-lg font-semibold mb-2">Last Entry</h4>
                                <p class="text-2xl font-bold">
                                    @if($entries->count() > 0)
                                        {{ $entries->first()->date->format('M d, Y') }}
                                    @else
                                        No entries yet
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h4 class="text-xl font-semibold mb-4">Recent Entries</h4>
                            @if($entries->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fish Stock</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Feed (kg)</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mortality</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($entries as $entry)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $entry->date->format('M d, Y') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $entry->fish_stock }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $entry->feed_quantity }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $entry->mortality }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-600 dark:text-gray-400">No entries yet. Start by adding your first daily entry!</p>
                            @endif
                        </div>

                        <div class="mt-8">
                            <h4 class="text-xl font-semibold mb-4">Quick Actions</h4>
                            <div class="space-y-2">
                                <p class="text-gray-600 dark:text-gray-400">• Add New Daily Entry</p>
                                <p class="text-gray-600 dark:text-gray-400">• View All Entries</p>
                                <p class="text-gray-600 dark:text-gray-400">• Edit/Delete Last Entry (within 3 hours)</p>
                                <p class="text-gray-600 dark:text-gray-400">• Export Data to CSV</p>
                            </div>
                            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                These features will be implemented in the next phase.
                            </p>
                        </div>
                    @else
                        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                            <p class="text-yellow-800 dark:text-yellow-200">
                                No farm assigned to your account. Please contact the administrator.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

