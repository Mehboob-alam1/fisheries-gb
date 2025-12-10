<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Farm Manager
            </h2>
            <a href="{{ route('admin.managers.show', $manager) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Details
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.managers.update', $manager) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Manager Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold mb-4">Manager Information</h3>
                                
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $manager->name) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address *</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $manager->email) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password (Leave blank to keep current)</label>
                                    <input type="password" name="password" id="password"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </div>

                            <!-- Farm Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold mb-4">Farm Information</h3>
                                
                                <div>
                                    <label for="district_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">District *</label>
                                    <select name="district_id" id="district_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id', $manager->district_id) == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="farm_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Farm *</label>
                                    <select name="farm_id" id="farm_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <option value="">Select District First</option>
                                        @if(isset($farms) && $farms->count() > 0)
                                            @foreach($farms as $farm)
                                                <option value="{{ $farm->id }}" {{ old('farm_id', $manager->farm->id ?? '') == $farm->id ? 'selected' : '' }}>
                                                    {{ $farm->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('farm_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Select a district to see available farms</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.managers.show', $manager) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Manager
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const districtSelect = document.getElementById('district_id');
            const farmSelect = document.getElementById('farm_id');
            const currentFarmId = {{ $manager->farm->id ?? 'null' }};
            const currentDistrictId = {{ $manager->district_id ?? 'null' }};

            districtSelect.addEventListener('change', function() {
                const districtId = this.value;
                const selectedFarmId = farmSelect.value;
                farmSelect.innerHTML = '<option value="">Loading farms...</option>';
                farmSelect.disabled = true;

                if (!districtId) {
                    farmSelect.innerHTML = '<option value="">Select District First</option>';
                    farmSelect.disabled = false;
                    return;
                }

                const includeFarmId = currentFarmId ? `?include_farm_id=${currentFarmId}` : '';
                fetch(`/admin/api/districts/${districtId}/farms${includeFarmId}`)
                    .then(response => response.json())
                    .then(farms => {
                        farmSelect.innerHTML = '<option value="">Select Farm</option>';
                        
                        if (farms.length === 0) {
                            farmSelect.innerHTML += '<option value="" disabled>No available farms in this district</option>';
                        } else {
                            farms.forEach(farm => {
                                const option = document.createElement('option');
                                option.value = farm.id;
                                option.textContent = farm.name;
                                farmSelect.appendChild(option);
                            });
                        }
                        
                        // If district hasn't changed, restore the selected farm
                        if (districtId == currentDistrictId && currentFarmId) {
                            farmSelect.value = currentFarmId;
                        } else if (selectedFarmId) {
                            // Try to keep the previously selected farm if it's in the new list
                            if (Array.from(farmSelect.options).some(opt => opt.value == selectedFarmId)) {
                                farmSelect.value = selectedFarmId;
                            }
                        }
                        
                        farmSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error loading farms:', error);
                        farmSelect.innerHTML = '<option value="">Error loading farms</option>';
                        farmSelect.disabled = false;
                    });
            });

            // Load farms on page load if district is selected
            if (currentDistrictId) {
                districtSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>

