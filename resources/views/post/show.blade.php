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
                    <x-user-avatar :user="$post->user" size="w-10 h-10" />
                    <a href="{{ route('profile.show', $post->user->username) }}" class="hover:underline">
                        {{ $post->user->name }}
                    </a>
                    &middot;
                    @auth
                        @if (auth()->id() !== $post->user->id)
                            @php
                                $isFollowing = auth()->user()->following->contains($post->user);
                            @endphp

                            <div x-data="followSystem('{{ $post->user->username }}', {{ $isFollowing ? 'true' : 'false' }}, {{ $post->user->followers->count() }})" class="inline-block">
                                <button @click="toggleFollow()" :disabled="isLoading"
                                    :class="isFollowing ? 'text-gray-500 hover:text-gray-700' :
                                        'text-blue-500 hover:text-blue-700'"
                                    class="underline transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span x-show="!isLoading">
                                        <span x-show="isFollowing">Unfollow</span>
                                        <span x-show="!isFollowing">Follow</span>
                                    </span>
                                    <span x-show="isLoading" class="text-gray-400">
                                        <span x-show="isFollowing">Unfollowing...</span>
                                        <span x-show="!isFollowing">Following...</span>
                                    </span>
                                </button>
                            </div>
                        @endif




                    @endauth
                </div>

                <div class="flex gap-2 text-gray-500 text-sm">
                    {{ $post->readTime() }} min read
                    &middot;
                    {{ $post->created_at->format('M d, Y') }}
                </div>
                <x-clap-button :post="$post" />

                <div class="mt-8">
                    @if ($post->image)
                        <div class="mb-6">
                            <figure class="relative">
                                <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                                    class="w-full h-auto rounded-lg shadow-lg cursor-pointer hover:shadow-xl transition-all duration-300 hover:scale-[1.02]"
                                    onclick="openImageModal('{{ $post->imageUrl() }}', '{{ addslashes($post->title) }}')"
                                    onerror="this.style.display='none'" loading="lazy">
                                <div
                                    class="absolute top-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm opacity-0 hover:opacity-100 transition-opacity">
                                    Click to enlarge
                                </div>
                            </figure>
                        </div>
                    @endif
                    <div class="mt-4 prose prose-lg max-w-none">
                        {{ $post->content }}
                    </div>
                </div>
                @if ($post->category)
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full mb-4">

                        {{ $post->category->name }}
                    </span>
                @endif
                {{-- Clap section --}}

                {{-- <div>
                    <button class="bg-gray-100 px-4 py-2 mt-8 rounded-full ">{{ $post ->category->name }}</button>
                </div> --}}

            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 items-center justify-center p-4"
        style="display: none;" onclick="closeImageModal()">
        <div class="max-w-full max-h-full flex flex-col">
            <div class="flex justify-end mb-2">
                <button onclick="closeImageModal()" class="text-white hover:text-gray-300 text-2xl font-bold">
                    ×
                </button>
            </div>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        </div>
    </div>

    <script>
        function openImageModal(imageUrl, imageTitle) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modalImage.src = imageUrl;
            modalImage.alt = imageTitle;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>
