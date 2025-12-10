<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Daily Entries
            </h2>
            <a href="{{ route('farm.entries.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-pakistan-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pakistan-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Entry
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Farm Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-6">
                <div class="p-4 bg-pakistan-green-50 border-b border-pakistan-green-200">
                    <h3 class="text-lg font-semibold text-pakistan-green-900">{{ $farm->name }}</h3>
                    <p class="text-sm text-pakistan-green-700">District: {{ $farm->district->name ?? 'N/A' }}</p>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Fish Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Feed (kg)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Mortality</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Water Temp (°C)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Remarks</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pakistan-green-700 uppercase tracking-wider">Status</th>
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
                                            {{ number_format($entry->fish_stock) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($entry->feed_quantity, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($entry->mortality) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->water_temp ? number_format($entry->water_temp, 1) : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                            {{ $entry->remarks ? Str::limit($entry->remarks, 50) : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($entry->isEditable())
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Editable
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Locked
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($entry->isEditable())
                                                <div class="flex items-center justify-end space-x-2">
                                                    <a href="{{ route('farm.entries.edit', $entry) }}" 
                                                       class="text-pakistan-green-600 hover:text-pakistan-green-900">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    @if($entries->first()->id === $entry->id)
                                                        <form method="POST" action="{{ route('farm.entries.destroy', $entry) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-xs">No actions</span>
                                            @endif
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
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No entries</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new daily entry.</p>
                        <div class="mt-6">
                            <a href="{{ route('farm.entries.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pakistan-green-600 hover:bg-pakistan-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add First Entry
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Editing Rules:</strong> You can only edit or delete the most recent entry, and only within 3 hours of creation. After 3 hours, entries become permanent and cannot be modified.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

