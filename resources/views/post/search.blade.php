<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl leading-tight">
                        {{ __('Search Results') }}
                    </h2>
                    @if (request('search'))
                        <p class="mt-2 text-indigo-100">Results for "{{ request('search') }}"</p>
                    @else
                        <p class="mt-2 text-indigo-100">Advanced search and filtering</p>
                    @endif
                </div>
                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition duration-200 backdrop-blur-sm border border-white/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Posts
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Form -->
            <x-search-form :categories="$categories" :authors="$authors" :filters="$filters" />

            <!-- Search Results -->
            <div class="mt-8 text-gray-900">
                @if (request('search') && $posts->count() > 0)
                    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-blue-800 font-medium">
                                Found {{ $posts->count() }} result(s) for "{{ request('search') }}"
                            </p>
                        </div>
                    </div>
                @endif

                @forelse ($posts as $post)
                    <x-post-item :post="$post"></x-post-item>
                @empty
                    <div class="text-center">
                        @if (array_filter($filters ?? []))
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8">
                                <svg class="mx-auto h-16 w-16 text-yellow-400 mb-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <h3 class="text-xl font-semibold text-yellow-800 mb-2">No posts found</h3>
                                <p class="text-yellow-600 mb-4">No posts match your current search criteria. Try
                                    adjusting your filters or search terms.</p>
                                <div class="flex gap-3 justify-center">
                                    <a href="{{ route('posts.search') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Clear all filters
                                    </a>
                                    <a href="{{ route('posts.index') }}"
                                        class="inline-flex items-center px-4 py-2 border border-yellow-300 text-sm font-medium rounded-md text-yellow-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Browse all posts
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Start searching</h3>
                                <p class="text-gray-600 mb-4">Use the search form above to find posts by title, content,
                                    author, or category.</p>
                                <a href="{{ route('posts.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-600 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Browse all posts
                                </a>
                            </div>
                        @endif
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
