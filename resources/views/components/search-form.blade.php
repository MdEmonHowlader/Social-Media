@props(['categories', 'authors', 'filters'])

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
    <form method="GET" action="{{ request()->routeIs('posts.search') ? route('posts.search') : route('posts.index') }}"
        class="space-y-4">
        <!-- Search Input -->
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Posts</label>
                <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}"
                    placeholder="Search by title or content..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex items-end">
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Search
                </button>
            </div>
        </div>

        {{-- <!-- Filters Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" id="category"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ ($filters['category'] ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Author Filter -->
            <div>
                <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                <select name="author" id="author"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Authors</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}"
                            {{ ($filters['author'] ?? '') == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort Filter -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                <select name="sort" id="sort"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="latest" {{ ($filters['sort'] ?? 'latest') == 'latest' ? 'selected' : '' }}>Latest
                    </option>
                    <option value="oldest" {{ ($filters['sort'] ?? '') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="popular" {{ ($filters['sort'] ?? '') == 'popular' ? 'selected' : '' }}>Most Popular
                    </option>
                    <option value="title" {{ ($filters['sort'] ?? '') == 'title' ? 'selected' : '' }}>Title (A-Z)
                    </option>
                </select>
            </div>

            <!-- Clear Filters -->
            <div class="flex items-end">
                <a href="{{ route('posts.index') }}"
                    class="w-full text-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Clear Filters
                </a>
            </div>
        </div>

        <!-- Date Range Filters -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ $filters['start_date'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ $filters['end_date'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>
    </form>

    <!-- Active Filters Display -->
    @if (array_filter($filters ?? []))
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap gap-2 items-center">
                <span class="text-sm font-medium text-gray-700">Active filters:</span>
                @if ($filters['search'] ?? false)
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        Search: "{{ $filters['search'] }}"
                    </span>
                @endif
                @if ($filters['category'] ?? false)
                    @php
                        $categoryName = $categories->firstWhere('id', $filters['category'])->name ?? 'Unknown';
                    @endphp
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Category: {{ $categoryName }}
                    </span>
                @endif
                @if ($filters['author'] ?? false)
                    @php
                        $authorName = $authors->firstWhere('id', $filters['author'])->name ?? 'Unknown';
                    @endphp
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Author: {{ $authorName }}
                    </span>
                @endif
                @if ($filters['start_date'] ?? false)
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        From: {{ $filters['start_date'] }}
                    </span>
                @endif
                @if ($filters['end_date'] ?? false)
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        To: {{ $filters['end_date'] }}
                    </span>
                @endif
                @if (($filters['sort'] ?? 'latest') !== 'latest')
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        Sort: {{ ucfirst($filters['sort']) }}
                    </span>
                @endif
            </div>
        </div>
    @endif --}}
</div>

<script>
    // Auto-submit form when filters change (optional)
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll(
            'select[name="category"], select[name="author"], select[name="sort"]');
        const dateInputs = document.querySelectorAll('input[name="start_date"], input[name="end_date"]');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });

        dateInputs.forEach(input => {
            input.addEventListener('change', function() {
                this.form.submit();
            });
        });
    });
</script>
