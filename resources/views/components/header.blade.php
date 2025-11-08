<header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 shadow-sm z-50">
    <div class="h-full px-6 flex items-center justify-between">
        <!-- Logo/Brand -->
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-800">BookStore</h1>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center space-x-4">
            <!-- Notifications or other actions can go here -->
            <div class="text-gray-600 text-sm">
                Welcome, {{ Auth::user()->name }}
            </div>
        </div>
    </div>
</header>
