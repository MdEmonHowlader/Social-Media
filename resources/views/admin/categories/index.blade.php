<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg p-6 shadow-lg">
            <h2 class="font-bold text-2xl leading-tight">
                {{ __('Categories Management') }}
            </h2>
            <p class="mt-2 text-purple-100">Add, edit, and manage content categories</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-purple-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages -->
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
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Add New Category Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Add New Category</h3>
                            <form method="POST" action="{{ route('admin.categories.store') }}">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="name" :value="__('Category Name')"
                                            class="text-gray-700 font-medium" />
                                        <x-text-input id="name"
                                            class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200"
                                            type="text" name="name" :value="old('name')" required autofocus
                                            placeholder="Enter category name" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-purple-300">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            {{ __('Add Category') }}
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Back to Admin Dashboard -->
                    <div class="mt-6">
                        <a href="{{ route('admin.dashboard') }}"
                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-100 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Admin Dashboard
                        </a>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-gray-900">Existing Categories</h3>
                                <span class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full">
                                    {{ $categories->count() }} {{ Str::plural('category', $categories->count()) }}
                                </span>
                            </div>

                            @if ($categories->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($categories as $category)
                                        <div
                                            class="border border-gray-200 rounded-xl p-4 hover:border-purple-200 transition-colors duration-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900">{{ $category->name }}
                                                        </h4>
                                                        <p class="text-sm text-gray-600">{{ $category->posts_count }}
                                                            {{ Str::plural('post', $category->posts_count) }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <!-- Edit Button -->
                                                    <button
                                                        onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')"
                                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <form method="POST"
                                                        action="{{ route('admin.categories.delete', $category) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No categories</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new category.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Category</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <x-input-label for="edit_name" :value="__('Category Name')" class="text-gray-700 font-medium" />
                        <x-text-input id="edit_name"
                            class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors duration-200"
                            type="text" name="name" required />
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="submit"
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-xl transition-colors duration-200">
                            Update
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-xl transition-colors duration-200">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, name) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('edit_name').value = name;
            document.getElementById('editForm').action = `/admin/categories/${id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
</x-app-layout>
