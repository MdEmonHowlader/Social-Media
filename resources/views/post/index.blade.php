<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Form -->
            

            <!-- Category Tabs (keeping for backward compatibility) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <x-category-tabs :selected-category="$selectedCategory ?? null">
                        No Categories available.
                    </x-category-tabs>
                    <x-search-form :categories="$categories" :authors="$authors" :filters="$filters" />
                </div>
            </div>

            <!-- Posts Results -->
            <div class="mt-8 text-gray-900">
                
                @if (request('search') && $posts->count() > 0)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            Found {{ $posts->count() }} result(s) for "{{ request('search') }}"
                        </p>
                    </div>
                @endif

                @forelse ($posts as $post)
                    <x-post-item :post="$post"></x-post-item>
                @empty
                    <div class="text-center">
                        @if (array_filter($filters ?? []))
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                                <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-yellow-800">No posts found</h3>
                                <p class="mt-1 text-sm text-yellow-600">No posts match your current search criteria. Try
                                    adjusting your filters.</p>
                                <div class="mt-3">
                                    <a href="{{ route('posts.index') }}"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Clear all filters
                                    </a>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 py-16">No posts available.</p>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
