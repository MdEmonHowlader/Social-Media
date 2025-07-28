<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl leading-tight">
                        {{ __('Image Management') }}
                    </h2>
                    <p class="mt-2 text-purple-100">Upload, organize, and manage images</p>
                </div>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition duration-200 backdrop-blur-sm border border-white/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-purple-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Upload Form -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">Upload New Image</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.images.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image
                                    File</label>
                                <input type="file" name="image" id="image" accept="image/*" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category" id="category" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    @foreach ($categories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                <input type="text" name="title" id="title" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-2">Alt
                                    Text</label>
                                <input type="text" name="alt_text" id="alt_text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <div class="lg:col-span-2">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                                Upload Image
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.images') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-64">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Search by title, description, or filename..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="filter_category"
                                class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category" id="filter_category"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">All Categories</option>
                                @foreach ($categories as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ request('category') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                            Filter
                        </button>

                        @if (request()->hasAny(['search', 'category']))
                            <a href="{{ route('admin.images') }}"
                                class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Images Grid -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-900">
                            Images ({{ $images->total() }} total)
                        </h3>
                    </div>
                </div>

                @if ($images->count() > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($images as $image)
                                <div
                                    class="bg-gray-50 rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition duration-200">
                                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                                        <img src="{{ $image->url() }}" alt="{{ $image->alt_text }}"
                                            class="w-full h-48 object-cover">
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-900 truncate">{{ $image->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <span
                                                class="inline-block bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">
                                                {{ $categories[$image->category] }}
                                            </span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-2">
                                            {{ $image->humanFileSize() }} • {{ $image->created_at->format('M d, Y') }}
                                        </p>
                                        <div class="flex gap-2 mt-4">
                                            <button onclick="viewImage({{ $image->id }})"
                                                class="flex-1 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                                View
                                            </button>
                                            <button onclick="editImage({{ $image->id }})"
                                                class="flex-1 px-3 py-1 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700 transition">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.images.delete', $image) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this image?')"
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $images->links() }}
                        </div>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No images found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by uploading your first image.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- View Image Modal -->
    <div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900">Image Details</h3>
                    <button onclick="closeModal('viewModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div id="viewModalContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Edit Image Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full mx-4">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900">Edit Image</h3>
                    <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div id="editModalContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function viewImage(imageId) {
            fetch(`/admin/images/${imageId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('viewModalContent').innerHTML = `
                        <div class="text-center">
                            <img src="${data.url}" alt="${data.alt_text}" class="max-w-full h-auto rounded-lg mx-auto mb-6">
                            <div class="text-left space-y-3">
                                <div><strong>Title:</strong> ${data.title}</div>
                                <div><strong>Description:</strong> ${data.description || 'N/A'}</div>
                                <div><strong>Alt Text:</strong> ${data.alt_text || 'N/A'}</div>
                                <div><strong>Category:</strong> ${data.category}</div>
                                <div><strong>Size:</strong> ${data.size}</div>
                                <div><strong>Uploaded by:</strong> ${data.uploader}</div>
                                <div><strong>Upload Date:</strong> ${data.created_at}</div>
                            </div>
                        </div>
                    `;
                    showModal('viewModal');
                });
        }

        function editImage(imageId) {
            fetch(`/admin/images/${imageId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editModalContent').innerHTML = `
                        <form action="/admin/images/${data.id}" method="POST" class="space-y-6">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                <input type="text" name="title" value="${data.title}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">${data.description || ''}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                                <input type="text" name="alt_text" value="${data.alt_text || ''}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    @foreach ($categories as $key => $label)
                                        <option value="{{ $key }}" ${data.category === '{{ $key }}' ? 'selected' : ''}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex justify-end gap-4">
                                <button type="button" onclick="closeModal('editModal')"
                                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                    Update Image
                                </button>
                            </div>
                        </form>
                    `;
                    showModal('editModal');
                });
        }

        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.getElementById(modalId).classList.add('flex');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.getElementById(modalId).classList.remove('flex');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modals = ['viewModal', 'editModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    closeModal(modalId);
                }
            });
        });
    </script>
</x-app-layout>
