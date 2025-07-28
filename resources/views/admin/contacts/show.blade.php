<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl leading-tight">
                        {{ __('Contact Message') }}
                    </h2>
                    <p class="mt-2 text-blue-100">View and respond to contact message</p>
                </div>
                <a href="{{ route('admin.contacts') }}"
                    class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition duration-200 backdrop-blur-sm border border-white/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Contacts
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Contact Message -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Message Details -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $contact->subject }}</h3>
                                    <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                        <span>{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</span>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $contact->getStatusBadgeColor() }}">
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="flex space-x-2">
                                    <form action="{{ route('admin.contacts.status', $contact) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status"
                                            value="{{ $contact->status === 'closed' ? 'read' : 'closed' }}">
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 {{ $contact->status === 'closed' ? 'bg-green-100 hover:bg-green-200 text-green-700' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }} rounded-lg transition duration-200">
                                            {{ $contact->status === 'closed' ? 'Reopen' : 'Close' }}
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">From:</span>
                                        <div class="text-sm text-gray-900">{{ $contact->name }}</div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Email:</span>
                                        <div class="text-sm text-gray-900">
                                            <a href="mailto:{{ $contact->email }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                {{ $contact->email }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Content -->
                            <div class="prose max-w-none">
                                <div class="whitespace-pre-line text-gray-900">{{ $contact->message }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Reply (if exists) -->
                    @if ($contact->isReplied())
                        <div class="bg-green-50 rounded-2xl shadow-lg border border-green-200">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h4 class="text-lg font-semibold text-green-800">Previous Reply</h4>
                                </div>

                                <div class="mb-3">
                                    <div class="text-sm font-medium text-green-700">Subject:
                                        {{ $contact->admin_reply_subject }}</div>
                                    <div class="text-sm text-green-600">
                                        Replied by {{ $contact->repliedBy->name }} on
                                        {{ $contact->replied_at->format('F j, Y \a\t g:i A') }}
                                    </div>
                                </div>

                                <div class="prose max-w-none">
                                    <div class="whitespace-pre-line text-green-900">{{ $contact->admin_reply }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Reply Form -->
                <div class="space-y-6">
                    <!-- Reply Form -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Send Reply</h4>

                            <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST"
                                class="space-y-4">
                                @csrf

                                <!-- Reply Subject -->
                                <div>
                                    <label for="reply_subject"
                                        class="block text-sm font-medium text-gray-700 mb-1">Reply Subject</label>
                                    <input type="text" name="reply_subject" id="reply_subject"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                        value="Re: {{ $contact->subject }}" required>
                                    @error('reply_subject')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Reply Message -->
                                <div>
                                    <label for="reply_message"
                                        class="block text-sm font-medium text-gray-700 mb-1">Reply Message</label>
                                    <textarea name="reply_message" id="reply_message" rows="8"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Type your reply here..." required>{{ old('reply_message') }}</textarea>
                                    @error('reply_message')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Send Reply
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Actions -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Actions</h4>

                            <div class="space-y-3">
                                <!-- Change Status -->
                                <form action="{{ route('admin.contacts.status', $contact) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Change
                                        Status</label>
                                    <div class="flex space-x-2">
                                        <select name="status" id="status"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                            <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>
                                                New</option>
                                            <option value="read"
                                                {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                                            <option value="replied"
                                                {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                            <option value="closed"
                                                {{ $contact->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                        <button type="submit"
                                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200">
                                            Update
                                        </button>
                                    </div>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.contacts.delete', $contact) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this contact message? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
