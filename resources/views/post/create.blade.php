<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl mb-4">Create new post</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('post.store') }}" enctype="multipart/form-data" method="post">

                    @csrf
                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title')" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-textarea-input id="content" class="block mt-1 w-full" name="content" :value="old('content')" />
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />
                        <select id="category" name="category_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach

                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Image (optional)')" />
                        <input id="image"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            type="file" name="image" accept="image/*" onchange="previewImage(event)" />
                        <p class="text-sm text-gray-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF, WEBP (Max: 5MB)
                        </p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />

                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="preview" src="" alt="Image preview"
                                class="max-w-xs max-h-48 object-cover rounded-lg border">
                            <button type="button" onclick="removeImage()"
                                class="mt-2 text-red-600 hover:text-red-800 text-sm">Remove image</button>
                        </div>
                    </div>
                    {{-- <div class="mt-4">
                        <x-input-label for="published_at" :value="__('Published At')" />
                        <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local"
                            name="published_at" :value="old('published_at')" autofocus />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div> --}}

                    <x-primary-button class="mt-4">
                        Submit
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('imagePreview');

            if (file) {
                // Check file size (5MB = 5 * 1024 * 1024 bytes)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    event.target.value = '';
                    return;
                }

                // Check file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('preview').src = '';
        }
    </script>
</x-app-layout>
