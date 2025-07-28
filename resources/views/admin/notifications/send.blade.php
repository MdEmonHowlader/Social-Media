<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send Notification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('notifications.send-to-all') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="title" :value="__('Notification Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                    :value="old('title')" required autofocus placeholder="Enter notification title" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div>
                                <x-input-label for="message" :value="__('Message')" />
                                <x-textarea-input id="message" name="message" class="mt-1 block w-full"
                                    placeholder="Enter your notification message" rows="4"
                                    required>{{ old('message') }}</x-textarea-input>
                                <x-input-error class="mt-2" :messages="$errors->get('message')" />
                            </div>

                            <div>
                                <x-input-label for="action_url" :value="__('Action URL (Optional)')" />
                                <x-text-input id="action_url" name="action_url" type="url" class="mt-1 block w-full"
                                    :value="old('action_url')" placeholder="https://example.com" />
                                <x-input-error class="mt-2" :messages="$errors->get('action_url')" />
                                <p class="text-sm text-gray-500 mt-1">Where users will go when they click the
                                    notification</p>
                            </div>

                            <div>
                                <x-input-label for="icon" :value="__('Icon')" />
                                <select id="icon" name="icon"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="megaphone" {{ old('icon') == 'megaphone' ? 'selected' : '' }}>📣
                                        Megaphone (Announcements)</option>
                                    <option value="bell" {{ old('icon') == 'bell' ? 'selected' : '' }}>🔔 Bell
                                        (General)</option>
                                    <option value="heart" {{ old('icon') == 'heart' ? 'selected' : '' }}>❤️ Heart
                                        (Appreciation)</option>
                                    <option value="chat" {{ old('icon') == 'chat' ? 'selected' : '' }}>💬 Chat
                                        (Communication)</option>
                                    <option value="user" {{ old('icon') == 'user' ? 'selected' : '' }}>👤 User
                                        (User-related)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('icon')" />
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-yellow-500 mr-3 mt-0.5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-medium text-yellow-800">
                                            Broadcast Notification
                                        </h3>
                                        <p class="text-sm text-yellow-700 mt-1">
                                            This notification will be sent to all registered users. Make sure your
                                            message is important and relevant.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                                    Cancel
                                </a>
                                <x-primary-button>
                                    {{ __('Send to All Users') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
