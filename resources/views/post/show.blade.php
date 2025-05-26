<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-5xl mb-4">
                    {{ $post->title }}
                </h1>
                <div class="flex gap-4">
                    @if($post->user->image)
                    <img class="w-12 h-12 rounded-full "
                        src="{{$post->user->imageUrl()}}" alt="{{ $post->user->name }}">
                    @else
                    <img class="w-12 h-12 rounded-full"
                        src="{{ asset('images/default-avatar.png') }}" alt="{{ $post->user->name }}">
                    @endif

                </div>
                <h3>{{ $post->user->name }}</h3>
                <div class="flex gap-2">
                    <span class="text-gray-500 text-sm">
                       
                        {{ $post->readTime() }} min read
                    </span>
                </div>
             
                
            </div>
        </div>
    </div>
</x-app-layout>