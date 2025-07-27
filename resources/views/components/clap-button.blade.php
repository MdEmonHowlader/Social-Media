@props(['count' => 0, 'post'])

<div class="mt-8 p-2 border-t border-b">
    {{-- Clap and Comment buttons --}}
    <div class="flex justify-between gap-4">
        <div x-data="{
            hasClapped: {{ auth()->user()->hasClapped($post) ? 'true' : 'false' }},
            count: {{ $post->claps()->count() }},
            clap() {
                axios.post('/posts/{{ $post->id }}/clap').then(response => {
                        this.hasClapped = response.data.hasClapped;
                        this.count = response.data.count;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }" class="flex gap-2 items-center">
            <button class="flex gap-2 text-gray-500 hover:text-gray-900" @click="clap()">
                <template x-if="!hasClapped">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                    </svg>
                </template>
                <template x-if="hasClapped">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path
                            d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                    </svg>
                </template>
                <span x-text="count"></span>
            </button>

            <div x-data="commentSystem({{ $post->id }}, {{ $post->comments()->count() }})" class="flex flex-col">
                <button class="flex gap-2 text-gray-500 hover:text-gray-900" @click="toggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                    </svg>
                    <span x-text="commentsCount"></span>
                </button>

                {{-- Comments Section --}}
                <div x-show="showComments" x-transition class="mt-4 space-y-4">
                    {{-- Comment Form --}}
                    <div class="border-b pb-4">
                        <div class="flex gap-3">
                            <div
                                class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-sm font-medium">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <textarea x-model="newComment" placeholder="Write a comment..."
                                    class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3" @keydown.ctrl.enter="submitComment()"></textarea>
                                <div class="flex justify-between items-center mt-2">
                                    {{-- <span class="text-sm text-gray-500">Press Ctrl + Enter to post</span> --}}
                                    <button @click="submitComment()" :disabled="!newComment.trim() || isLoading"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span x-show="!isLoading">Post Comment</span>
                                        <span x-show="isLoading">Posting...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Comments List --}}
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <template x-for="comment in comments" :key="comment.id">
                            <div class="flex gap-3">
                                <div
                                    class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-sm font-medium">
                                    <span x-text="comment.user.name.charAt(0)"></span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-medium text-sm" x-text="comment.user.name"></span>
                                        <span class="text-gray-500 text-xs" x-text="'@' + comment.user.username"></span>
                                        <span class="text-gray-500 text-xs" x-text="comment.created_at"></span>
                                        <button x-show="comment.can_delete" @click="deleteComment(comment.id)"
                                            class="text-red-500 hover:text-red-700 text-xs ml-auto">
                                            Delete
                                        </button>
                                    </div>
                                    <p class="text-gray-700 text-sm" x-text="comment.content"></p>
                                </div>
                            </div>
                        </template>

                        <div x-show="comments.length === 0 && commentsCount === 0"
                            class="text-center text-gray-500 py-4">
                            No comments yet. Be the first to comment!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
