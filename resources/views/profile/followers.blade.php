<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Followers</h1>
                        <p class="text-gray-600 mt-1">People following {{ $user->name }}</p>
                    </div>
                    <a href="{{ route('profile.show', $user->username) }}"
                        class="text-blue-600 hover:text-blue-800 transition-colors">
                        ← Back to Profile
                    </a>
                </div>

                <div class="grid gap-4">
                    @forelse ($followers as $follower)
                        <div
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <x-user-avatar :user="$follower" size="w-12 h-12" />
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        <a href="{{ route('profile.show', $follower->username) }}"
                                            class="hover:text-blue-600 transition-colors">
                                            {{ $follower->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600">{{ $follower->followers->count() }} followers</p>
                                    @if ($follower->bio)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                            {{ Str::limit($follower->bio, 100) }}</p>
                                    @endif
                                </div>
                            </div>

                            @auth
                                @if (auth()->id() !== $follower->id)
                                    @if (auth()->user()->following->contains($follower))
                                        <form action="{{ route('unfollow', $follower) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition-colors">
                                                Unfollow
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow', $follower) }}" method="POST" class="inline">
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
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No followers yet</h3>
                            <p class="text-gray-600">{{ $user->name }} doesn't have any followers yet.</p>
                        </div>
                    @endforelse
                </div>

                @if ($followers->hasPages())
                    <div class="mt-8">
                        {{ $followers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
