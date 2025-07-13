<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex-1">
                        <h1 class="text-5xl"> {{ auth()->user()->name }}</h1>
                        
                        <div class="mt-4 pr-5">
                            @forelse ($posts as $post)
                                <x-post-item :post="$post"></x-post-item>
                            @empty
                                <div class="text-center">
                                    <p class="text-gray-500 py-16">No posts available.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="w-[320px] border-l px-8">
                        <x-user-avatar :user="auth()->user()" size="w-24 h-24" />
                        <div class="user-card mt-2">
                            <h3>{{ auth()->user()->name }}</h3>
                            <p class="text-gray-600">255k followers</p>
                            <p>{{ auth()->user()->bio }}</p>
                        </div>
                        <div class="mt-3">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                                Follow
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
