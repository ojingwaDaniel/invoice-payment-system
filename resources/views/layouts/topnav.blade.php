<!-- Premium Simplified Header -->
<header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <!-- Left: Mobile Toggle -->
            <div class="flex items-center gap-4">
                <button id="mobile_btn"
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors group">
                    <div class="w-5 space-y-1.5">
                        <span class="block h-0.5 w-full bg-gray-600 transition-transform group-hover:bg-gray-900"></span>
                        <span class="block h-0.5 w-full bg-gray-600 transition-transform group-hover:bg-gray-900"></span>
                        <span class="block h-0.5 w-full bg-gray-600 transition-transform group-hover:bg-gray-900"></span>
                    </div>
                </button>
            </div>

            <!-- Right: Actions -->
            <div class="flex items-center gap-2">

                <!-- Notifications -->
                <div class="relative">
                    <button id="notification-btn"
                            class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-green-500 rounded-full border-2 border-white"></span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div id="notification-menu"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 hidden z-50 overflow-hidden">
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                            <h6 class="font-semibold text-gray-900">Notifications</h6>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            <div class="p-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-sm">No new notifications</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme Toggle -->
                <button id="theme-toggle"
                        class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all">
                    <svg id="theme-icon-dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg id="theme-icon-light" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>

                <!-- User Menu -->
                @auth
                <div class="relative">
                    <button id="user-menu-btn"
                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 transition-all">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                            {{ substr(Auth::user()->company_name ?? 'U', 0, 1) }}
                        </div>
                        <svg class="w-4 h-4 text-gray-500 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- User Dropdown -->
                    <div id="user-menu"
                         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-200 hidden z-50 overflow-hidden">
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-semibold shadow-sm">
                                    {{ substr(Auth::user()->company_name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h6 class="text-sm font-semibold text-gray-900 truncate">
                                        {{ Auth::user()->company_name ?? 'User' }}
                                    </h6>
                                    <p class="text-xs text-gray-600 truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2">
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile Settings
                            </a>

                            <div class="my-2 border-t border-gray-200"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth

                @guest
                <a href="{{ route('login') }}"
                   class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                    Login
                </a>
                @endguest
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Notification Toggle
    const notificationBtn = document.getElementById('notification-btn');
    const notificationMenu = document.getElementById('notification-menu');

    notificationBtn?.addEventListener('click', function(e) {
        e.stopPropagation();
        notificationMenu.classList.toggle('hidden');
        document.getElementById('user-menu')?.classList.add('hidden');
    });

    // User Menu Toggle
    const userMenuBtn = document.getElementById('user-menu-btn');
    const userMenu = document.getElementById('user-menu');

    userMenuBtn?.addEventListener('click', function(e) {
        e.stopPropagation();
        userMenu.classList.toggle('hidden');
        notificationMenu?.classList.add('hidden');
    });

    // Theme Toggle
    const themeToggle = document.getElementById('theme-toggle');
    const iconDark = document.getElementById('theme-icon-dark');
    const iconLight = document.getElementById('theme-icon-light');

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
        iconDark.classList.add('hidden');
        iconLight.classList.remove('hidden');
    }

    themeToggle?.addEventListener('click', function() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        iconDark.classList.toggle('hidden');
        iconLight.classList.toggle('hidden');
    });

    // Close dropdowns on outside click
    document.addEventListener('click', function() {
        notificationMenu?.classList.add('hidden');
        userMenu?.classList.add('hidden');
    });

    // Prevent dropdown close when clicking inside
    [notificationMenu, userMenu].forEach(menu => {
        menu?.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
});
</script>
