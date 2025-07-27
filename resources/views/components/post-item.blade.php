<div x-data="{ expanded: false }">
    <div class="flex bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 mb-8">
        <div class="p-5 flex-1">
            <a
                href="{{ route('post.show', [
                    'username' => $post->user ? $post->user->username : 'unknown',
                    'post' => $post,
                ]) }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $post->title }}
                </h5>
            </a>

            {{-- Content with Read More functionality --}}
            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                <div x-show="!expanded">
                    {{ Str::words($post->content, 20) }}
                    @if (str_word_count(strip_tags($post->content)) > 20)
                        <button @click="expanded = true" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                            Read more...
                        </button>
                    @endif
                </div>

                <div x-show="expanded" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    {{ $post->content }}
                    <button @click="expanded = false" class="text-blue-600 hover:text-blue-800 font-medium ml-2">
                        Show less
                    </button>
                </div>
            </div>

            {{-- Engagement metrics --}}
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                    </svg>
                    <span>{{ $post->claps_count ?? 0 }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                    </svg>
                    <span>{{ $post->comments_count ?? 0 }}</span>
                </div>
                @if ($post->category)
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $post->category->name }}</span>
                @endif
            </div>

            {{-- View Full Post Button --}}
            <a
                href="{{ route('post.show', [
                    'username' => $post->user ? $post->user->username : 'unknown',
                    'post' => $post,
                ]) }}">
                <x-primary-button>
                    View Full Post
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </x-primary-button>
            </a>
        </div>
        <a
            href="{{ route('post.show', [
                'username' => $post->user ? $post->user->username : 'unknown',
                'post' => $post,
            ]) }}">
            <img class="w-48 h-full max-h-64 object-cover rounded-t-lg" src="{{ Storage::url($post->image) }}"
                alt="" />
        </a>
    </div>
</div>
