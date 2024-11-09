<nav class="bg-green-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="/" class="flex-shrink-0">
                    <div class="block h-8 w-auto text-white font-bold text-xl">
                        NGABERS
                    </div>
                </a>
 
                <!-- Desktop Navigation -->
                <div class="hidden md:ml-8 md:flex md:space-x-4">
                    <a href="{{ route('dashboard') }}" 
                       class="{{ request()->routeIs('dashboard') ? 'bg-green-700' : 'hover:bg-green-700' }} text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        Dashboard
                    </a>
                    <a href="{{ route('posts.index') }}" 
                       class="{{ request()->routeIs('posts.*') ? 'bg-green-700' : 'hover:bg-green-700' }} text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        Posts
                    </a>
                    <a href="{{ route('events.index') }}" 
                       class="{{ request()->routeIs('events.*') ? 'bg-green-700' : 'hover:bg-green-700' }} text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        Events
                    </a>
                </div>
            </div>
 
            <!-- Search Bar -->
            <div class="flex-1 max-w-xl px-4 hidden md:flex items-center">
                <div class="w-full">
                    <div class="relative">
                        <input type="text" 
                               id="search-input"
                               class="w-full bg-green-700/50 text-white placeholder-green-200 border border-green-500 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:border-white transition duration-150"
                               placeholder="Cari post atau user...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <!-- Search Results Dropdown -->
                        <div id="search-results" 
                             class="hidden absolute w-full mt-2 bg-white rounded-lg shadow-lg overflow-hidden z-50">
                        </div>
                    </div>
                </div>
            </div>
 
            <!-- Right Navigation -->
            <div class="flex items-center">
                <!-- User Dropdown -->
                <div class="ml-3 relative">
                    <div class="relative">
                        <button type="button" 
                                onclick="toggleUserMenu()"
                                class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:shadow-solid"
                                id="user-menu-button">
                            @if(auth()->user()->avatar)
                                <img class="h-8 w-8 rounded-full object-cover border-2 border-green-300" 
                                     src="{{ auth()->user()->avatar }}" 
                                     alt="{{ auth()->user()->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-green-800 flex items-center justify-center text-white border-2 border-green-300">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </button>
                    </div>
 
                    <!-- Dropdown Menu -->
                    <div id="user-menu" 
                         class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                        <div class="py-1">
                            <a href="{{ route('profile.show', auth()->user()) }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
 
                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" 
                            onclick="toggleMobileMenu()"
                            class="text-white hover:text-green-200 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
 
    <!-- Mobile menu -->
    <div class="hidden md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" 
               class="{{ request()->routeIs('dashboard') ? 'bg-green-700' : 'hover:bg-green-700' }} text-white block px-3 py-2 rounded-md text-base font-medium">
                Dashboard
            </a>
            <a href="{{ route('posts.index') }}" 
               class="{{ request()->routeIs('posts.*') ? 'bg-green-700' : 'hover:bg-green-700' }} text-white block px-3 py-2 rounded-md text-base font-medium">
                Posts
            </a>
            <a href="{{ route('events.index') }}" 
               class="{{ request()->routeIs('events.*') ? 'bg-green-700' : 'hover:bg-green-700' }} text-white block px-3 py-2 rounded-md text-base font-medium">
                Events
            </a>
            <!-- Mobile Search -->
            <div class="px-2 py-2">
                <input type="text" 
                       class="w-full bg-green-700/50 text-white placeholder-green-200 border border-green-500 rounded-lg pl-10 pr-4 py-2"
                       placeholder="Cari...">
            </div>
        </div>
    </div>
 </nav>

<!-- Add JavaScript for search functionality -->
<script>
    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');

        // Close menu when clicking outside
        function closeMenu(e) {
            const button = document.getElementById('user-menu-button');
            const menu = document.getElementById('user-menu');
            
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
                document.removeEventListener('click', closeMenu);
            }
        }

        // Add event listener for clicking outside
        setTimeout(() => {
            document.addEventListener('click', closeMenu);
        }, 0);
    }

    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        let timeoutId;
    
        searchInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            const query = this.value.trim();
    
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }
    
            // Debounce search
            timeoutId = setTimeout(() => {
                fetch(`/search?query=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    
                    // Show results container
                    searchResults.classList.remove('hidden');
    
                    // Render posts
                    if (data.posts.length > 0) {
                        searchResults.innerHTML += '<div class="px-4 py-2 text-sm font-bold text-gray-500">Posts</div>';
                        data.posts.forEach(post => {
                            searchResults.innerHTML += `
                                <a href="/posts/${post.id}" class="block px-4 py-2 hover:bg-gray-100">
                                    <div class="font-medium">${post.title}</div>
                                    <div class="text-sm text-gray-500">oleh ${post.user.name}</div>
                                </a>
                            `;
                        });
                    }
    
                    // Render users
                    if (data.users.length > 0) {
                        searchResults.innerHTML += '<div class="px-4 py-2 text-sm font-bold text-gray-500">Users</div>';
                        data.users.forEach(user => {
                            searchResults.innerHTML += `
                                <a href="/profile/${user.id}" class="block px-4 py-2 hover:bg-gray-100">
                                    <div class="flex items-center">
                                        ${user.avatar 
                                            ? `<img src="${user.avatar}" class="w-8 h-8 rounded-full mr-2">`
                                            : `<div class="w-8 h-8 rounded-full bg-gray-200 mr-2 flex items-center justify-center">
                                                ${user.name.charAt(0)}
                                               </div>`
                                        }
                                        <div>
                                            <div class="font-medium">${user.name}</div>
                                            ${user.bio ? `<div class="text-sm text-gray-500">${user.bio}</div>` : ''}
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                    }
    
                    // No results
                    if (data.posts.length === 0 && data.users.length === 0) {
                        searchResults.innerHTML = `
                            <div class="px-4 py-2 text-sm text-gray-500">
                                Tidak ada hasil untuk "${query}"
                            </div>
                        `;
                    }
                })
                .catch(error => console.error('Error:', error));
            }, 300); // 300ms debounce
        });
    
        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    });
    </script>
