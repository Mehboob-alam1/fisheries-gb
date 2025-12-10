<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Staff Member
            </h2>
            <a href="{{ route('farm.staff.index') }}" class="text-sm text-pakistan-green-600 hover:text-pakistan-green-700">
                ← Back to Staff
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('farm.staff.store') }}" class="space-y-6">
                        @csrf

                        <!-- Farm Name (Display Only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Farm
                            </label>
                            <input type="text" 
                                   value="{{ $farm->name }}" 
                                   disabled
                                   class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('name') border-red-300 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                                Position
                            </label>
                            <input type="text" 
                                   name="position" 
                                   id="position" 
                                   value="{{ old('position') }}"
                                   placeholder="e.g., Farm Worker, Technician"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('position') border-red-300 @enderror">
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Number
                            </label>
                            <input type="text" 
                                   name="contact_number" 
                                   id="contact_number" 
                                   value="{{ old('contact_number') }}"
                                   placeholder="e.g., 03001234567"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('contact_number') border-red-300 @enderror">
                            @error('contact_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CNIC -->
                        <div>
                            <label for="cnic" class="block text-sm font-medium text-gray-700 mb-2">
                                CNIC (National ID)
                            </label>
                            <input type="text" 
                                   name="cnic" 
                                   id="cnic" 
                                   value="{{ old('cnic') }}"
                                   placeholder="e.g., 12345-1234567-1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('cnic') border-red-300 @enderror">
                            @error('cnic')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Joining Date -->
                        <div>
                            <label for="joining_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Joining Date
                            </label>
                            <input type="date" 
                                   name="joining_date" 
                                   id="joining_date" 
                                   value="{{ old('joining_date') }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pakistan-green-500 focus:ring-pakistan-green-500 @error('joining_date') border-red-300 @enderror">
                            @error('joining_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('farm.staff.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-pakistan-green-600 border border-transparent rounded-md hover:bg-pakistan-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pakistan-green-500">
                                Add Staff Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

