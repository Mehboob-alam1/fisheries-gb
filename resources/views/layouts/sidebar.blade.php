<nav class="fixed inset-y-0 left-0 z-50 w-64 bg-pakistan-green-700 text-white transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-0" x-bind:class="{ '-translate-x-full': !$store.sidebar.open, 'translate-x-0': $store.sidebar.open }">
    <div class="flex flex-col h-full">
        <!-- Logo/Header -->
        <div class="flex items-center justify-between h-16 px-6 bg-pakistan-green-800 border-b border-pakistan-green-600">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <span class="text-pakistan-green-700 font-bold text-lg">GB</span>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-white">Fisheries</h1>
                    <p class="text-xs text-pakistan-green-200">Gilgit-Baltistan</p>
                </div>
            </div>
            <button @click="$store.sidebar.open = false" class="lg:hidden text-white hover:text-pakistan-green-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- User Info -->
        <div class="px-6 py-4 bg-pakistan-green-800 border-b border-pakistan-green-600">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <span class="text-pakistan-green-700 font-semibold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-pakistan-green-200 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 overflow-y-auto py-4">
            <nav class="space-y-1 px-3">
                @if(Auth::user()->isAdmin())
                    <!-- Admin Menu -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-pakistan-green-600 text-white' : 'text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.districts.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.districts.*') ? 'bg-pakistan-green-600 text-white' : 'text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 002 2h2.945M15 11a3 3 0 11-6 0M15 11a3 3 0 00-6 0m6 0a3 3 0 01-3 3m-3-3a3 3 0 013-3m0 0a3 3 0 013 3m-3 3a3 3 0 01-3-3"></path>
                        </svg>
                        Districts
                    </a>

                    <a href="{{ route('admin.farms.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.farms.*') ? 'bg-pakistan-green-600 text-white' : 'text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Farms
                    </a>

                    <a href="{{ route('admin.managers.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.managers.*') ? 'bg-pakistan-green-600 text-white' : 'text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Farm Managers
                    </a>

                    <a href="{{ route('admin.entries.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.entries.*') ? 'bg-pakistan-green-600 text-white' : 'text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        View Entries
                    </a>

                    <div class="pt-4 mt-4 border-t border-pakistan-green-600">
                        <p class="px-4 text-xs font-semibold text-pakistan-green-300 uppercase tracking-wider">Reports</p>
                        <a href="#" class="flex items-center px-4 py-3 mt-2 text-sm font-medium rounded-lg text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            View Reports
                        </a>
                    </div>
                @else
                    <!-- Farm Manager Menu -->
                    <a href="{{ route('farm.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('farm.dashboard') ? 'bg-pakistan-green-600 text-white' : 'text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('farm.entries.create') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('farm.entries.create') ? 'bg-pakistan-green-600 text-white' : 'text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Daily Entry
                    </a>

                    <a href="{{ route('farm.entries.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('farm.entries.*') && !request()->routeIs('farm.entries.create') ? 'bg-pakistan-green-600 text-white' : 'text-pakistan-green-100 hover:bg-pakistan-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View Entries
                    </a>
                @endif
            </nav>
        </div>

        <!-- Logout -->
        <div class="px-3 py-4 border-t border-pakistan-green-600">
            <form method="POST" action="{{ Auth::user()->isAdmin() ? route('admin.logout') : route('farm.logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-medium text-pakistan-green-100 rounded-lg hover:bg-pakistan-green-600 hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

