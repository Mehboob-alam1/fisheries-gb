<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Daily Entry
            </h2>
            <a href="{{ route('farm.entries.index') }}" class="text-sm text-pakistan-green-600 hover:text-pakistan-green-700">
                ← Back to Entries
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
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

                    <!-- Entry Info -->
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Entry Date:</strong> {{ $entry->date->format('F d, Y') }}<br>
                                    <strong>Created At:</strong> {{ $entry->created_at->format('F d, Y h:i A') }}<br>
                                    <strong>Editable Until:</strong> {{ $entry->editable_until->format('F d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('farm.entries.update', $entry) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="date" 
                                   id="date" 
                                   value="{{ old('date', $entry->date->format('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('date') border-red-300 @enderror"
                                   required>
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fish Stock -->
                        <div>
                            <label for="fish_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Fish Stock (Total Number) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="fish_stock" 
                                   id="fish_stock" 
                                   value="{{ old('fish_stock', $entry->fish_stock) }}"
                                   min="0"
                                   step="1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('fish_stock') border-red-300 @enderror"
                                   required>
                            @error('fish_stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Feed Quantity -->
                        <div>
                            <label for="feed_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Feed Quantity (kg) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="feed_quantity" 
                                   id="feed_quantity" 
                                   value="{{ old('feed_quantity', $entry->feed_quantity) }}"
                                   min="0"
                                   step="0.01"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('feed_quantity') border-red-300 @enderror"
                                   required>
                            @error('feed_quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mortality -->
                        <div>
                            <label for="mortality" class="block text-sm font-medium text-gray-700 mb-2">
                                Mortality (Number of Deaths) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="mortality" 
                                   id="mortality" 
                                   value="{{ old('mortality', $entry->mortality) }}"
                                   min="0"
                                   step="1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('mortality') border-red-300 @enderror"
                                   required>
                            @error('mortality')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Water Temperature -->
                        <div>
                            <label for="water_temp" class="block text-sm font-medium text-gray-700 mb-2">
                                Water Temperature (°C)
                            </label>
                            <input type="number" 
                                   name="water_temp" 
                                   id="water_temp" 
                                   value="{{ old('water_temp', $entry->water_temp) }}"
                                   min="0"
                                   max="50"
                                   step="0.1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('water_temp') border-red-300 @enderror">
                            @error('water_temp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">
                                Remarks
                            </label>
                            <textarea name="remarks" 
                                      id="remarks" 
                                      rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('remarks') border-red-300 @enderror">{{ old('remarks', $entry->remarks) }}</textarea>
                            @error('remarks')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('farm.entries.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-pakistan-green-600 border border-transparent rounded-md hover:bg-pakistan-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Update Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

