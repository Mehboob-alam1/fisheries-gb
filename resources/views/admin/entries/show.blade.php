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

                            <div class="bg-red-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-red-700 mb-2">Mortality</label>
                                <p class="text-3xl font-bold text-red-900">{{ number_format($entry->mortality) }}</p>
                                <p class="text-xs text-red-600 mt-1">Number of deaths</p>
                            </div>
                        </div>
                    </div>

                    <!-- Fish Stock Details Section -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Fish Stock Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shifting → In</label>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($entry->shifting_in) }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shifting → Out</label>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($entry->shifting_out) }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sale</label>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($entry->sale) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Fish Feed Section -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Fish Feed</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-blue-700 mb-2">Feed In Stock</label>
                                <p class="text-2xl font-bold text-blue-900">{{ number_format($entry->feed_in_stock, 2) }} kg</p>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-blue-700 mb-2">Feed Consumption</label>
                                <p class="text-2xl font-bold text-blue-900">{{ number_format($entry->feed_consumption, 2) }} kg</p>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-blue-700 mb-2">Feed Quantity (Legacy)</label>
                                <p class="text-2xl font-bold text-blue-900">{{ number_format($entry->feed_quantity, 2) }} kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Medication Section -->
                    @if($entry->medication)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Medication</h3>
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $entry->medication }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Water Parameters Section -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Water Parameters</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($entry->water_temp)
                            <div class="bg-cyan-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-cyan-700 mb-2">Temperature</label>
                                <p class="text-2xl font-bold text-cyan-900">{{ number_format($entry->water_temp, 1) }}°C</p>
                            </div>
                            @endif
                            @if($entry->water_ph)
                            <div class="bg-cyan-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-cyan-700 mb-2">pH</label>
                                <p class="text-2xl font-bold text-cyan-900">{{ number_format($entry->water_ph, 2) }}</p>
                            </div>
                            @endif
                            @if($entry->water_do)
                            <div class="bg-cyan-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-cyan-700 mb-2">DO (Dissolved Oxygen)</label>
                                <p class="text-2xl font-bold text-cyan-900">{{ number_format($entry->water_do, 2) }} mg/L</p>
                            </div>
                            @endif
                        </div>
                        @if(!$entry->water_temp && !$entry->water_ph && !$entry->water_do)
                        <p class="text-sm text-gray-500 mt-2">No water parameters recorded</p>
                        @endif
                    </div>

                    <!-- Offence Cases Section -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Offence Cases</h3>
                        <div class="bg-orange-50 rounded-lg p-4">
                            <p class="text-2xl font-bold text-orange-900">{{ number_format($entry->offence_cases) }}</p>
                            <p class="text-xs text-orange-600 mt-1">Number of offence cases registered</p>
                        </div>
                    </div>

                    <!-- Staff Attendance Section -->
                    @if($entry->staffAttendance->count() > 0)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Staff Attendance</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($entry->staffAttendance as $attendance)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $attendance->staff->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $attendance->staff->position ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Additional Notes Section -->
                    @if($entry->additional_notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Notes</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $entry->additional_notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Remarks Section (Legacy) -->
                    @if($entry->remarks)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Remarks (Legacy)</h3>
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

