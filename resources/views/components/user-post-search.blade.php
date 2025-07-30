@props(['user', 'searchTerm' => ''])

<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
    <form method="GET" action="{{ route('profile.show', $user->username) }}" class="flex gap-3">
        <div class="flex-1 relative">
            <input type="text" name="search" value="{{ $searchTerm }}"
                placeholder="Search {{ $user->name }}'s posts..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        <button type="submit"
            class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
            Search
        </button>
        @if ($searchTerm)
            <a href="{{ route('profile.show', $user->username) }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                Clear
            </a>
        @endif
    </form>

    @if ($searchTerm)
        <div class="mt-3 pt-3 border-t border-gray-200">
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Searching in <strong>{{ $user->name }}'s</strong> posts for
                    "<strong>{{ $searchTerm }}</strong>"</span>
            </div>
        </div>
    @endif
</div>
