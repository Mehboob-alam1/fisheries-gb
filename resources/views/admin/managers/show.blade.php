<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Farm Manager Details
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.managers.edit', $manager) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Manager
                </a>
                <a href="{{ route('admin.managers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('credentials'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">
                                <strong>IMPORTANT: Save these credentials!</strong>
                            </p>
                            <div class="mt-2 text-sm">
                                <p><strong>Email:</strong> {{ session('credentials')['email'] }}</p>
                                <p><strong>Password:</strong> {{ session('credentials')['password'] }}</p>
                                <p class="mt-2 text-xs">These credentials will not be shown again. Please provide them to the farm manager.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Manager Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Manager Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $manager->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $manager->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">District</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $manager->district ? $manager->district->name : 'N/A' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $manager->created_at->format('M d, Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Farm Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Farm Information</h3>
                            @if($manager->farm)
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Farm Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $manager->farm->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $manager->farm->location ?? 'N/A' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">District</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $manager->farm->district->name }}
                                        </dd>
                                    </div>
                                </dl>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">No farm assigned yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Login Credentials Box -->
                    <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border-2 border-blue-200 dark:border-blue-700">
                        <h3 class="text-lg font-semibold mb-3">Login Credentials</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Login URL:</span>
                                <span class="ml-2 text-sm text-gray-900 dark:text-gray-100 font-mono">
                                    {{ url('/farm/login') }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Email:</span>
                                <span class="ml-2 text-sm text-gray-900 dark:text-gray-100 font-mono">
                                    {{ $manager->email }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Password:</span>
                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 italic">
                                    (Hidden for security - use reset password to set a new one)
                                </span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button onclick="copyCredentials()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Copy Login URL
                            </button>
                        </div>
                    </div>

                    <!-- Reset Password Form -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-3">Reset Password</h3>
                        <form method="POST" action="{{ route('admin.managers.reset-password', $manager) }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                                    <input type="password" name="password" id="password" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyCredentials() {
            const url = '{{ url("/farm/login") }}';
            navigator.clipboard.writeText(url).then(() => {
                alert('Login URL copied to clipboard!');
            });
        }
    </script>
</x-app-layout>

