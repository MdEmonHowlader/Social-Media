@props(['notifications' => collect(), 'unreadCount' => 0])

<div class="relative" x-data="{ open: false }">
    <!-- Notification Button -->
    <button @click="open = !open"
        class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition-colors duration-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-5 5v-5zM4 19h10a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>

        @if ($unreadCount > 0)
            <span
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">

        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                @if ($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-500">
                            Mark all read
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @if ($notifications->count() > 0)
                @foreach ($notifications->take(5) as $notification)
                    <div class="px-4 py-3 hover:bg-gray-50 {{ !$notification->read_at ? 'bg-blue-50' : '' }}">
                        <div class="flex items-start space-x-3">
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
                                    class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center">
                                    @if ($icon === 'megaphone')
                                        <svg class="w-4 h-4 {{ $iconClass }}" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 {{ $iconClass }}" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </p>
                                <p class="text-sm text-gray-700 line-clamp-2">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @if (!$notification->read_at)
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                </div>
                            @endif
                        </div>
                        @if (isset($notification->data['action_url']))
                            <div class="mt-2">
                                <a href="{{ route('notifications.mark-read', $notification->id) }}?redirect={{ urlencode($notification->data['action_url']) }}"
                                    class="text-xs text-blue-600 hover:text-blue-500">
                                    View →
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach

                @if ($notifications->count() > 5)
                    <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                        <a href="{{ route('notifications.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                            View all {{ $notifications->count() }} notifications →
                        </a>
                    </div>
                @endif
            @else
                <div class="px-4 py-8 text-center">
                    <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-5 5v-5zM4 19h10a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm text-gray-500 mt-2">No notifications</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if ($notifications->count() > 0)
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('notifications.index') }}"
                    class="block text-center text-sm text-blue-600 hover:text-blue-500 font-medium">
                    View All Notifications
                </a>
            </div>
        @endif
    </div>
</div>
