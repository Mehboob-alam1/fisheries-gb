<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Entry Details
            </h2>
            <a href="{{ route('admin.entries.index') }}" class="text-sm text-pakistan-green-600 hover:text-pakistan-green-700">
                ← Back to All Entries
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <!-- Entry Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Entry Date</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $entry->date->format('F d, Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Created At</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $entry->created_at->format('F d, Y h:i A') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Farm</label>
                                <p class="mt-1 text-lg font-semibold text-pakistan-green-700">{{ $entry->farm->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">District</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $entry->farm->district->name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Farm Manager</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $entry->farm->manager->name ?? 'N/A' }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $entry->farm->manager->email ?? '' }}</p>
                            </div>

                            @if($entry->farm->location)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Farm Location</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $entry->farm->location }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div class="bg-pakistan-green-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-pakistan-green-700 mb-2">Fish Stock</label>
                                <p class="text-3xl font-bold text-pakistan-green-900">{{ number_format($entry->fish_stock) }}</p>
                                <p class="text-xs text-pakistan-green-600 mt-1">Total number of fish</p>
                            </div>

                            <div class="bg-blue-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-blue-700 mb-2">Feed Quantity</label>
                                <p class="text-3xl font-bold text-blue-900">{{ number_format($entry->feed_quantity, 2) }} kg</p>
                                <p class="text-xs text-blue-600 mt-1">Feed consumed</p>
                            </div>

                            <div class="bg-red-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-red-700 mb-2">Mortality</label>
                                <p class="text-3xl font-bold text-red-900">{{ number_format($entry->mortality) }}</p>
                                <p class="text-xs text-red-600 mt-1">Number of deaths</p>
                            </div>

                            @if($entry->water_temp)
                            <div class="bg-cyan-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-cyan-700 mb-2">Water Temperature</label>
                                <p class="text-3xl font-bold text-cyan-900">{{ number_format($entry->water_temp, 1) }}°C</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Remarks Section -->
                    @if($entry->remarks)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $entry->remarks }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Status Information -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Entry Status</label>
                                @if($entry->isEditable())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Editable (until {{ $entry->editable_until->format('M d, Y h:i A') }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                        Locked (editing period expired)
                                    </span>
                                @endif
                            </div>
                            <div class="text-right">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                                <p class="text-sm text-gray-600">{{ $entry->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

