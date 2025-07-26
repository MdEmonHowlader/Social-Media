<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex-1">
                        <h1 class="text-5xl"> {{ $user->name }}</h1>

                        <div class="mt-4 pr-5">
                            @forelse ($posts as $post)
                                <x-post-item :post="$post"></x-post-item>
                            @empty
                                <div class="text-center">
                                    <p class="text-gray-500 py-16">All available.</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                    <div class="w-[320px] border-l px-8">
                        <x-user-avatar :user="$user" size="w-24 h-24" />
                        <div class="user-card mt-2">
                            <h3>{{ $user->name }}</h3>
                            <a href="{{ route('followers', $user->username) }}"
                                class="text-gray-600 hover:text-blue-600 transition-colors">{{ $user->followers->count() }}
                                Followers</a>
                            <a href="{{ route('following', $user->username) }}"
                                class="text-gray-600 hover:text-blue-600 transition-colors"
                                data-following-count="{{ $user->following->count() }}">{{ $user->following->count() }}
                                Following</a>

                        </div>

                        @if (auth()->id() !== $user->id)
                            @if (auth()->user()->following->contains($user))
                                <form action="{{ route('unfollow', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-gray-500 text-white px-4 py-2 rounded">Unfollow</button>
                                </form>
                            @else
                                <form action="{{ route('follow', $user) }}" method="POST">
                                    @csrf
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Follow</button>
                                </form>
                            @endif
                        @endif

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
    </div>
</x-app-layout>
