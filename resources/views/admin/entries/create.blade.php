<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create New Entry
            </h2>
            <a href="{{ route('admin.entries.index') }}" class="text-sm text-pakistan-green-600 hover:text-pakistan-green-700">
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

                    <form method="POST" action="{{ route('admin.entries.store') }}" class="space-y-8">
                        @csrf

                        <!-- Section 1: Basic Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                            
                            <!-- Farm Selection -->
                            <div class="mb-4">
                                <label for="farm_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Farm <span class="text-red-500">*</span>
                                </label>
                                <select name="farm_id" id="farm_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('farm_id') border-red-300 @enderror">
                                    <option value="">Select Farm</option>
                                    @foreach($farms as $farm)
                                        <option value="{{ $farm->id }}" {{ old('farm_id') == $farm->id ? 'selected' : '' }}>
                                            {{ $farm->name }} ({{ $farm->district->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('farm_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
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
                                        Mortality <span class="text-red-500">*</span>
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
                                        Shifting → In <span class="text-red-500">*</span>
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
                                        Shifting → Out <span class="text-red-500">*</span>
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
                                        Sale <span class="text-red-500">*</span>
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
                                        In Stock (kg) <span class="text-red-500">*</span>
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
                                        Consumption (kg) <span class="text-red-500">*</span>
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
                            </div>
                        </div>

                        <!-- Section 5: Water Parameters -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Water Parameters</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- PH -->
                                <div>
                                    <label for="water_ph" class="block text-sm font-medium text-gray-700 mb-2">
                                        PH
                                    </label>
                                    <input type="number" 
                                           name="water_ph" 
                                           id="water_ph" 
                                           value="{{ old('water_ph') }}"
                                           min="0"
                                           max="14"
                                           step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('water_ph') border-red-300 @enderror">
                                    @error('water_ph')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Temperature -->
                                <div>
                                    <label for="water_temp" class="block text-sm font-medium text-gray-700 mb-2">
                                        Temp (°C)
                                    </label>
                                    <input type="number" 
                                           name="water_temp" 
                                           id="water_temp" 
                                           value="{{ old('water_temp') }}"
                                           min="0"
                                           max="50"
                                           step="0.1"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('water_temp') border-red-300 @enderror">
                                    @error('water_temp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- DO (Dissolved Oxygen) -->
                                <div>
                                    <label for="water_do" class="block text-sm font-medium text-gray-700 mb-2">
                                        DO (mg/L)
                                    </label>
                                    <input type="number" 
                                           name="water_do" 
                                           id="water_do" 
                                           value="{{ old('water_do') }}"
                                           min="0"
                                           step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('water_do') border-red-300 @enderror">
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

                        <!-- Section 7: Additional Notes -->
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

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.entries.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-pakistan-green-600 border border-transparent rounded-md hover:bg-pakistan-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Create Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

