<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ url()->previous() }}"
                    class="mr-4 p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Notifications') }}
                </h2>
            </div>
            <div class="flex gap-2">
                @if ($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="inline">
                        @csrf
                        <x-secondary-button type="submit">
                            Mark All Read ({{ $unreadCount }})
                        </x-secondary-button>
                    </form>
                @endif
                <form method="POST" action="{{ route('notifications.destroy-all') }}" class="inline"
                    onsubmit="return confirm('Are you sure you want to delete all notifications?')">
                    @csrf
                    @method('DELETE')
                    <x-danger-button type="submit">
                        Clear All
                    </x-danger-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach ($notifications as $notification)
                                <div
                                    class="border border-gray-200 rounded-lg p-4 {{ $notification->read_at ? 'bg-gray-50' : 'bg-blue-50 border-blue-200' }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3 flex-1">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $icon = $notification->data['icon'] ?? 'bell';
                                                    $iconClass = match ($icon) {
                                                        'megaphone' => 'text-red-500',
                                                        'heart' => 'text-pink-500',
                                                        'chat' => 'text-blue-500',
                                                        'user' => 'text-green-500',
                                                        default => 'text-gray-500',
                                                    };
                                                @endphp
                                                <div
                                                    class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center">
                                                    @if ($icon === 'megaphone')
                                                        <svg class="w-5 h-5 {{ $iconClass }}" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    @elseif($icon === 'heart')
                                                        <svg class="w-5 h-5 {{ $iconClass }}" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    @elseif($icon === 'chat')
                                                        <svg class="w-5 h-5 {{ $iconClass }}" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    @elseif($icon === 'user')
                                                        <svg class="w-5 h-5 {{ $iconClass }}" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 {{ $iconClass }}" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                                            </path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-sm font-medium text-gray-900">
                                                        {{ $notification->data['title'] ?? 'Notification' }}
                                                    </h3>
                                                    <div class="flex items-center space-x-2">
                                                        @if (!$notification->read_at)
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                New
                                                            </span>
                                                        @endif
                                                        <span class="text-xs text-gray-500">
                                                            {{ $notification->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-700">
                                                    {{ $notification->data['message'] ?? '' }}
                                                </p>
                                                @if (isset($notification->data['action_url']))
                                                    <div class="mt-2">
                                                        <a href="{{ $notification->data['action_url'] }}"
                                                            class="text-sm text-blue-600 hover:text-blue-500">
                                                            View Details →
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-4">
                                            @if (!$notification->read_at)
                                                <form method="POST"
                                                    action="{{ route('notifications.mark-read', $notification->id) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-xs text-blue-600 hover:text-blue-500">
                                                        Mark Read
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST"
                                                action="{{ route('notifications.destroy', $notification->id) }}"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this notification?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:text-red-500">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM4 19h10a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                            <p class="mt-1 text-sm text-gray-500">You're all caught up! No new notifications.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
