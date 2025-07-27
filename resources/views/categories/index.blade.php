<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-6 shadow-lg">
            <h2 class="font-bold text-2xl leading-tight">
                {{ __('Browse Categories') }}
            </h2>
            <p class="mt-2 text-blue-100">Discover content organized by topics</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Categories Grid -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">All Categories</h3>

                @if ($categories->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                        <!-- All Posts Card -->
                        <a href="{{ route('categories.page') }}"
                            class="group block bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 {{ !$selectedCategory ? 'ring-2 ring-blue-500 bg-gradient-to-r from-blue-50 to-purple-50' : '' }}">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    @if (!$selectedCategory)
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-blue-500 text-white rounded-full">Active</span>
                                    @endif
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">All Posts</h4>
                                <p class="text-gray-600 text-sm mb-3">View all published content</p>
                                <div class="flex items-center text-blue-600">
                                    <span class="text-2xl font-bold">{{ $totalPosts }}</span>
                                    <span class="ml-2 text-sm">posts</span>
                                </div>
                            </div>
                        </a>

                        <!-- Category Cards -->
                        @foreach ($categories as $category)
                            <a href="{{ route('categories.page', ['category' => $category->id]) }}"
                                class="group block bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 {{ $selectedCategory == $category->id ? 'ring-2 ring-purple-500 bg-gradient-to-r from-purple-50 to-blue-50' : '' }}">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                        </div>
                                        @if ($selectedCategory == $category->id)
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-purple-500 text-white rounded-full">Active</span>
                                        @endif
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $category->name }}</h4>
                                    <p class="text-gray-600 text-sm mb-3">Explore {{ strtolower($category->name) }}
                                        content</p>
                                    <div class="flex items-center text-purple-600">
                                        <span class="text-2xl font-bold">{{ $category->posts_count }}</span>
                                        <span
                                            class="ml-2 text-sm">{{ Str::plural('post', $category->posts_count) }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Categories Available</h3>
                        <p class="text-gray-600 mb-6">Categories help organize content and make it easier to discover.
                        </p>
                        @auth
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin.categories') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create Categories
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Filter Results -->
            @if ($selectedCategory)
                @php
                    $selectedCategoryName = $categories->find($selectedCategory)->name ?? 'Unknown';
                @endphp
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900">
                            Posts in "{{ $selectedCategoryName }}"
                        </h3>
                        <a href="{{ route('categories.page') }}"
                            class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear Filter
                        </a>
                    </div>
                </div>
            @else
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Recent Posts</h3>
                </div>
            @endif

            <!-- Posts List -->
            <div class="space-y-6">
                @forelse ($posts as $post)
                    <x-post-item :post="$post"></x-post-item>
                @empty
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">No Posts Found</h4>
                        <p class="text-gray-600 mb-4">
                            @if ($selectedCategory)
                                There are no posts in this category yet.
                            @else
                                No posts have been published yet.
                            @endif
                        </p>
                        <a href="{{ route('post.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create First Post
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($posts->hasPages())
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
