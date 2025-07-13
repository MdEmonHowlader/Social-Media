<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-5xl mb-4">
                    {{ $post->title }}
                </h1>
                <div class="flex gap-4">

                    {{-- <div class="flex flex-col">
                        <span class="text-gray-500 text-sm">Written by</span>
                        <span class="text-lg font-semibold">{{ $post->user->name }}</span>
                    </div> --}}

                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                        {{ $post->user->name }}
                    </a>
                    &middot;
                    @auth
                        @php
                            $isFollowing = auth()->user()->following->contains($post->user);
                        @endphp

                        @if ($isFollowing)
                            <form action="{{ route('unfollow', $post->user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:underline">
                                    Unfollow
                                </button>
                            </form>
                        @else
                            <form action="{{ route('follow', $post->user) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:underline">
                                    Follow
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>


                <div class="flex gap-2 text-gray-500 text-sm">
                    {{ $post->readTime() }} min read
                    &middot;
                    {{ $post->created_at->format('M d, Y') }}

                </div>

                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>
                {{-- Clap section --}}
                <x-clap-button :post="$post" />
                <div>
                    <button class="bg-gray-100 px-4 py-2 mt-8 rounded-full ">{{ $post->category->name }}</button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
