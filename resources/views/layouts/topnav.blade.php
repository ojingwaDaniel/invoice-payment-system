<!-- Header with Tailwind CSS -->
<div class="header bg-white shadow-sm border-b border-gray-200">
    <div class="main-header max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Left Section: Mobile Toggle & Quick Add -->
            <div class="flex items-center space-x-4">

                <!-- Mobile Sidebar Toggle -->
                <button id="mobile_btn" class="lg:hidden flex flex-col justify-center items-center w-10 h-10 rounded-md hover:bg-gray-100 transition-colors">
                    <span class="w-5 h-0.5 bg-gray-600 mb-1"></span>
                    <span class="w-5 h-0.5 bg-gray-600 mb-1"></span>
                    <span class="w-5 h-0.5 bg-gray-600"></span>
                </button>

                <!-- Quick Add Dropdown -->
               

                <!-- Breadcrumb placeholder -->
                <div class="hidden md:block">
                    <!-- Breadcrumb content can go here -->
                </div>
            </div>

            <!-- Right Section: Search & User Menu -->
            <div class="flex items-center space-x-3">

                <!-- Search -->
                <div class="relative hidden sm:block">
                    <input type="text"
                           class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Search...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="relative" id="notification-container">
                    <button id="notification-btn" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.115 5.5A5.5 5.5 0 1117 11.5M10.115 5.5a5.5 5.5 0 1010 0 5.5 5.5 0 00-10 0z"></path>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-green-500 rounded-full border border-white"></span>
                    </button>

                    <div id="notification-menu" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                        <div class="p-4 border-b border-gray-200">
                            <h6 class="text-lg font-semibold text-gray-900">Notifications</h6>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            <div class="p-4 border-b border-gray-100 text-center text-gray-500">
                                No new notifications.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Light/Dark Mode Toggle -->
                <div class="flex items-center">
                    <button id="dark-mode-toggle" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                    <button id="light-mode-toggle" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors hidden">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>
                </div>

                <!-- User Dropdown -->
                @auth
                    <div class="relative" id="user-dropdown-container">
                        <button id="user-dropdown-btn" class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                {{ substr(Auth::user()->company_name ?? 'U', 0, 1) }}
                            </div>
                        </button>

                        <div id="user-dropdown-menu" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                            <div class="p-4 bg-gray-50 rounded-t-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-lg font-medium">
                                        {{ substr(Auth::user()->company_name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="text-sm font-semibold text-gray-900">{{ Auth::user()->company_name ?? 'User' }}</h6>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile Settings
                                </a>

                                <hr class="my-2 border-gray-200">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm">
                        Login
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Mobile Search (Hidden on larger screens) -->
<div class="sm:hidden bg-white border-b border-gray-200 px-4 py-3">
    <div class="relative">
        <input type="text"
               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
               placeholder="Search...">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- JavaScript for dropdown functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick Add Dropdown
    const quickAddBtn = document.getElementById('quick-add-btn');
    const quickAddMenu = document.getElementById('quick-add-menu');

    if (quickAddBtn && quickAddMenu) {
        quickAddBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            quickAddMenu.classList.toggle('hidden');

            // Close other open dropdowns
            closeOtherDropdowns('quick-add-menu');
        });
    }

    // Notifications Dropdown
    const notificationBtn = document.getElementById('notification-btn');
    const notificationMenu = document.getElementById('notification-menu');

    if (notificationBtn && notificationMenu) {
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationMenu.classList.toggle('hidden');

            // Close other open dropdowns
            closeOtherDropdowns('notification-menu');
        });
    }

    // User Dropdown
    const userBtn = document.getElementById('user-dropdown-btn');
    const userMenu = document.getElementById('user-dropdown-menu');

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');

            // Close other open dropdowns
            closeOtherDropdowns('user-dropdown-menu');
        });
    }

    // Dark/Light mode toggle
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const lightModeToggle = document.getElementById('light-mode-toggle');

    if (darkModeToggle && lightModeToggle) {
        // Set initial state based on current theme
        if (document.documentElement.classList.contains('dark')) {
            darkModeToggle.classList.add('hidden');
            lightModeToggle.classList.remove('hidden');
        } else {
            darkModeToggle.classList.remove('hidden');
            lightModeToggle.classList.add('hidden');
        }

        darkModeToggle.addEventListener('click', function() {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            darkModeToggle.classList.add('hidden');
            lightModeToggle.classList.remove('hidden');
        });

        lightModeToggle.addEventListener('click', function() {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            lightModeToggle.classList.add('hidden');
            darkModeToggle.classList.remove('hidden');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        closeAllDropdowns();
    });

    // Function to close all dropdowns
    function closeAllDropdowns() {
        const dropdowns = [
            'quick-add-menu',
            'notification-menu',
            'user-dropdown-menu'
        ];

        dropdowns.forEach(id => {
            const menu = document.getElementById(id);
            if (menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    }

    // Function to close other dropdowns except the current one
    function closeOtherDropdowns(currentMenuId) {
        const dropdowns = [
            'quick-add-menu',
            'notification-menu',
            'user-dropdown-menu'
        ];

        dropdowns.forEach(id => {
            if (id !== currentMenuId) {
                const menu = document.getElementById(id);
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            }
        });
    }

    // Load saved theme from localStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
        if (darkModeToggle && lightModeToggle) {
            darkModeToggle.classList.add('hidden');
            lightModeToggle.classList.remove('hidden');
        }
    }
});
</script>

<!-- Add this to your head tag for dark mode support -->
<style>
.dark {
    color-scheme: dark;
}
</style>
