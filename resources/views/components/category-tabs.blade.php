<div class="w-full">
    <!-- Category Filter Tabs -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-4 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Filter by Category</h3>
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.categories') }}"
                        class="text-sm text-purple-600 hover:text-purple-800 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Manage Categories
                    </a>
                @endif
            @endauth
        </div>

        <div class="flex flex-wrap gap-2">
            <!-- All Posts Tab -->
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ !$selectedCategory ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg transform scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 hover:text-blue-600 border border-gray-200 hover:border-blue-300' }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                All Posts
                @if (!$selectedCategory)
                    <span class="ml-2 px-2 py-1 text-xs bg-white bg-opacity-20 rounded-full">Active</span>
                @endif
            </a>

            <!-- Category Tabs -->
            @forelse ($categories as $category)
                <a href="{{ route('post.category', $category) }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $selectedCategory == $category->id ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg transform scale-105' : 'bg-white text-gray-700 hover:bg-gray-50 hover:text-blue-600 border border-gray-200 hover:border-blue-300' }}">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ $category->name }}
                    @if ($selectedCategory == $category->id)
                        <span class="ml-2 px-2 py-1 text-xs bg-white bg-opacity-20 rounded-full">Active</span>
                    @endif
                </a>
            @empty
                <div class="text-center py-4 w-full">
                    <div class="text-gray-500 mb-2">{{ $slot }}</div>
                    @auth
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('admin.categories') }}"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create First Category
                            </a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </div>
    </div>
</div>
