<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex-1">
                        <h1 class="text-5xl"> {{ $user->name }}</h1>

                        <!-- Posts Section -->
                        <div class="mt-4 pr-5">
                            @forelse ($posts as $post)
                                <x-post-item :post="$post"></x-post-item>
                            @empty
                                <div class="text-center py-12">
                                    <div class="text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-800 mb-2">No posts yet</p>
                                        <p class="text-gray-600">{{ $user->name }} hasn't published any posts yet.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        @if ($posts->hasPages())
                            <div class="mt-6 pr-5">
                                {{ $posts->links() }}
                            </div>
                        @endif

                    </div>
                    <div class="w-[320px] border-l px-8">
                        <x-user-avatar :user="$user" size="w-24 h-24" />
                        <div class="user-card mt-2">
                            <h3>{{ $user->name }}</h3>
                            <a href="{{ route('followers', $user->username) }}"
                                class="text-gray-600 hover:text-blue-600 transition-colors">
                                <span
                                    data-followers-count="{{ $user->followers->count() }}">{{ $user->followers->count() }}</span>
                                Followers</a>
                            <a href="{{ route('following', $user->username) }}"
                                class="text-gray-600 hover:text-blue-600 transition-colors"
                                data-following-count="{{ $user->following->count() }}">{{ $user->following->count() }}
                                Following</a>

                        </div>

                        @auth
                            @if (auth()->id() !== $user->id)
                                <div x-data="followSystem('{{ $user->username }}', {{ auth()->user()->following->contains($user) ? 'true' : 'false' }}, {{ $user->followers->count() }})" class="mt-4">
                                    <!-- JavaScript-enhanced button -->
                                    <button @click="toggleFollow()" :disabled="isLoading"
                                        :class="isFollowing ? 'bg-gray-500 hover:bg-gray-600' : 'bg-blue-500 hover:bg-blue-600'"
                                        class="text-white px-4 py-2 rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                        x-show="true">
                                        <span x-show="!isLoading">
                                            <span x-show="isFollowing">Unfollow</span>
                                            <span x-show="!isFollowing">Follow</span>
                                        </span>
                                        <span x-show="isLoading">
                                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            <span x-show="isFollowing">Unfollowing...</span>
                                            <span x-show="!isFollowing">Following...</span>
                                        </span>
                                    </button>

                                    <!-- Fallback forms for no-JS -->
                                    @if (auth()->user()->following->contains($user))
                                        <form action="{{ route('unfollow', $user->username) }}" method="POST"
                                            class="noscript-only">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition-colors">
                                                Unfollow
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow', $user->username) }}" method="POST"
                                            class="noscript-only">
                                            @csrf
                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors">
                                                Follow
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endauth

                        <!-- Bio Section -->
                        @if ($user->bio)
                            <div class="bio-section mt-4 pt-4 border-t border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">About</h4>
                                <p class="text-gray-600 leading-relaxed">{{ $user->bio }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
