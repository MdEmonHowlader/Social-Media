<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Following</h1>
                        <p class="text-gray-600 mt-1">People that {{ $user->name }} is following</p>
                    </div>
                    <a href="{{ route('profile.show', $user->username) }}"
                        class="text-blue-600 hover:text-blue-800 transition-colors">
                        ← Back to Profile
                    </a>
                </div>

                <div class="grid gap-4">
                    @forelse ($following as $followedUser)
                        <div
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <x-user-avatar :user="$followedUser" size="w-12 h-12" />
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        <a href="{{ route('profile.show', $followedUser->username) }}"
                                            class="hover:text-blue-600 transition-colors">
                                            {{ $followedUser->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600">{{ $followedUser->followers->count() }} followers
                                    </p>
                                    @if ($followedUser->bio)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                            {{ Str::limit($followedUser->bio, 100) }}</p>
                                    @endif
                                </div>
                            </div>

                            @auth
                                @if (auth()->id() !== $followedUser->id)
                                    @if (auth()->user()->following->contains($followedUser))
                                        <form action="{{ route('unfollow', $followedUser) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition-colors">
                                                Unfollow
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow', $followedUser) }}" method="POST" class="inline">
                                            @csrf
                                            <button
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors">
                                                Follow
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">👥</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No following yet</h3>
                            <p class="text-gray-600">{{ $user->name }} isn't following anyone yet.</p>
                        </div>
                    @endforelse
                </div>

                @if ($following->hasPages())
                    <div class="mt-8">
                        {{ $following->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
