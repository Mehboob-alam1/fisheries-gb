<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Daily Entry
            </h2>
            <a href="{{ route('farm.entries.index') }}" class="text-sm text-pakistan-green-600 hover:text-pakistan-green-700">
                ← Back to Entries
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
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

                    <form method="POST" action="{{ route('farm.entries.store') }}" class="space-y-8" id="entryForm">
                        @csrf

                        <!-- Section 1: Basic Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                            
                            <!-- Unit Name (Auto Selected) -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Unit Name
                                </label>
                                <input type="text" 
                                       value="{{ $farm->name }}" 
                                       disabled
                                       class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                                <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="date" 
                                       id="date" 
                                       value="{{ old('date', date('Y-m-d')) }}"
                                       max="{{ date('Y-m-d') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('date') border-red-300 @enderror"
                                       required>
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 2: Fish Stock -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Fish Stock</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Fish Stock -->
                                <div>
                                    <label for="fish_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                        Total Fish Stock <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="fish_stock" 
                                           id="fish_stock" 
                                           value="{{ old('fish_stock') }}"
                                           min="0"
                                           step="1"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('fish_stock') border-red-300 @enderror"
                                           required>
                                    @error('fish_stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mortality -->
                                <div>
                                    <label for="mortality" class="block text-sm font-medium text-gray-700 mb-2">
                                        3.1. Mortality <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="mortality" 
                                           id="mortality" 
                                           value="{{ old('mortality', 0) }}"
                                           min="0"
                                           step="1"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('mortality') border-red-300 @enderror"
                                           required>
                                    @error('mortality')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Shifting In -->
                                <div>
                                    <label for="shifting_in" class="block text-sm font-medium text-gray-700 mb-2">
                                        3.2. Shifting → In <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="shifting_in" 
                                           id="shifting_in" 
                                           value="{{ old('shifting_in', 0) }}"
                                           min="0"
                                           step="1"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('shifting_in') border-red-300 @enderror"
                                           required>
                                    @error('shifting_in')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Shifting Out -->
                                <div>
                                    <label for="shifting_out" class="block text-sm font-medium text-gray-700 mb-2">
                                        3.2. Shifting → Out <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="shifting_out" 
                                           id="shifting_out" 
                                           value="{{ old('shifting_out', 0) }}"
                                           min="0"
                                           step="1"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('shifting_out') border-red-300 @enderror"
                                           required>
                                    @error('shifting_out')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Sale -->
                                <div>
                                    <label for="sale" class="block text-sm font-medium text-gray-700 mb-2">
                                        3.3. Sale <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="sale" 
                                           id="sale" 
                                           value="{{ old('sale', 0) }}"
                                           min="0"
                                           step="1"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('sale') border-red-300 @enderror"
                                           required>
                                    @error('sale')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Fish Feed -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Fish Feed</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Feed In Stock -->
                                <div>
                                    <label for="feed_in_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                        4.1. In Stock (kg) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="feed_in_stock" 
                                           id="feed_in_stock" 
                                           value="{{ old('feed_in_stock') }}"
                                           min="0"
                                           step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('feed_in_stock') border-red-300 @enderror"
                                           required>
                                    @error('feed_in_stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Feed Consumption -->
                                <div>
                                    <label for="feed_consumption" class="block text-sm font-medium text-gray-700 mb-2">
                                        4.2. Consumption (kg) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="feed_consumption" 
                                           id="feed_consumption" 
                                           value="{{ old('feed_consumption') }}"
                                           min="0"
                                           step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('feed_consumption') border-red-300 @enderror"
                                           required>
                                    @error('feed_consumption')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Medication -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Medication</h3>
                            
                            <div>
                                <label for="medication" class="block text-sm font-medium text-gray-700 mb-2">
                                    Medication Details
                                </label>
                                <textarea name="medication" 
                                          id="medication" 
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('medication') border-red-300 @enderror"
                                          placeholder="Enter medication details, dosage, and any notes...">{{ old('medication') }}</textarea>
                                @error('medication')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Optional: Record any medications administered</p>
                            </div>
                        </div>

                        <!-- Section 5: Water Parameters -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Water Parameters</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- PH -->
                                <div>
                                    <label for="water_ph" class="block text-sm font-medium text-gray-700 mb-2">
                                        6.1. PH
                                    </label>
                                    <input type="number" 
                                           name="water_ph" 
                                           id="water_ph" 
                                           value="{{ old('water_ph') }}"
                                           min="0"
                                           max="14"
                                           step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('water_ph') border-red-300 @enderror"
                                           placeholder="0.00 - 14.00">
                                    @error('water_ph')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Temperature -->
                                <div>
                                    <label for="water_temp" class="block text-sm font-medium text-gray-700 mb-2">
                                        6.2. Temp (°C)
                                    </label>
                                    <input type="number" 
                                           name="water_temp" 
                                           id="water_temp" 
                                           value="{{ old('water_temp') }}"
                                           min="0"
                                           max="50"
                                           step="0.1"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('water_temp') border-red-300 @enderror"
                                           placeholder="Temperature in Celsius">
                                    @error('water_temp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- DO (Dissolved Oxygen) -->
                                <div>
                                    <label for="water_do" class="block text-sm font-medium text-gray-700 mb-2">
                                        6.3. DO (mg/L)
                                    </label>
                                    <input type="number" 
                                           name="water_do" 
                                           id="water_do" 
                                           value="{{ old('water_do') }}"
                                           min="0"
                                           step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('water_do') border-red-300 @enderror"
                                           placeholder="Dissolved Oxygen">
                                    @error('water_do')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 6: Offence Cases -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Offence Cases Registered</h3>
                            
                            <div>
                                <label for="offence_cases" class="block text-sm font-medium text-gray-700 mb-2">
                                    Number of Offence Cases <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="offence_cases" 
                                       id="offence_cases" 
                                       value="{{ old('offence_cases', 0) }}"
                                       min="0"
                                       step="1"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('offence_cases') border-red-300 @enderror"
                                       required>
                                @error('offence_cases')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 7: Staff Attendance -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Staff Attendance</h3>
                            
                            <div class="mb-4">
                                <a href="{{ route('farm.staff.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-pakistan-green-600 text-white text-sm font-medium rounded-md hover:bg-pakistan-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Manage Staff
                                </a>
                                <p class="mt-2 text-xs text-gray-500">Add or manage staff members, then mark their attendance for this entry.</p>
                            </div>

                            <div id="staff-attendance-section" class="space-y-3">
                                @php
                                    $staffMembers = $farm->staff()->where('is_active', true)->get();
                                @endphp
                                
                                @if($staffMembers->count() > 0)
                                    @foreach($staffMembers as $staff)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <input type="checkbox" 
                                                       name="staff_attendance[{{ $staff->id }}][present]" 
                                                       id="staff_{{ $staff->id }}" 
                                                       value="1"
                                                       checked
                                                       class="h-4 w-4 text-pakistan-green-600 focus:ring-pakistan-green-500 border-gray-300 rounded">
                                                <label for="staff_{{ $staff->id }}" class="text-sm font-medium text-gray-700">
                                                    {{ $staff->name }} 
                                                    @if($staff->position)
                                                        <span class="text-gray-500">({{ $staff->position }})</span>
                                                    @endif
                                                </label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="time" 
                                                       name="staff_attendance[{{ $staff->id }}][check_in]" 
                                                       class="text-xs rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500"
                                                       placeholder="Check In">
                                                <input type="time" 
                                                       name="staff_attendance[{{ $staff->id }}][check_out]" 
                                                       class="text-xs rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500"
                                                       placeholder="Check Out">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4 text-sm text-gray-500">
                                        No staff members added yet. <a href="{{ route('farm.staff.index') }}" class="text-pakistan-green-600 hover:text-pakistan-green-700">Add staff members</a> to track attendance.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Section 8: Additional Notes -->
                        <div class="pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Notes</h3>
                            
                            <div>
                                <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Additional Notes
                                </label>
                                <textarea name="additional_notes" 
                                          id="additional_notes" 
                                          rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('additional_notes') border-red-300 @enderror"
                                          placeholder="Enter any additional notes or observations...">{{ old('additional_notes') }}</textarea>
                                @error('additional_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Note:</strong> You can edit or delete this entry within 3 hours of creation. After that, it becomes permanent.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('farm.entries.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-pakistan-green-600 border border-transparent rounded-md hover:bg-pakistan-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Save Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
