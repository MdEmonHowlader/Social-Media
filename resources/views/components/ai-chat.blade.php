<!-- AI Chat Widget -->
<div id="ai-chat-widget" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Toggle Button -->
    <button id="chat-toggle"
        class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
        <svg id="chat-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.955 8.955 0 01-3.95-.89L3 21l1.89-6.05A8.955 8.955 0 013 12a8 8 0 018-8 8 8 0 018 8z">
            </path>
        </svg>
        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Chat Window -->
    <div id="chat-window"
        class="hidden absolute bottom-16 right-0 w-80 bg-white rounded-lg shadow-2xl border border-gray-200 overflow-hidden">
        <!-- Chat Header -->
        <div class="bg-blue-600 text-white p-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">AI Assistant</h3>
                    <p class="text-xs opacity-90">Online</p>
                </div>
            </div>
            <button id="minimize-chat" class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
            </button>
        </div>

        <!-- Chat Messages -->
        <div id="chat-messages" class="h-80 overflow-y-auto p-4 space-y-4 bg-gray-50">
            <!-- Welcome Message -->
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm border max-w-xs">
                    <p class="text-sm text-gray-800">Hello! I'm your AI assistant. How can I help you today?</p>
                    <p class="text-xs text-gray-500 mt-1">Just now</p>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="p-4 border-t border-gray-200 bg-white">
            <form id="chat-form" class="flex space-x-2">
                <input type="text" id="chat-input" placeholder="Type your message..."
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    maxlength="1000">
                <button type="submit" id="send-button"
                    class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
            <div id="typing-indicator" class="hidden mt-2">
                <div class="flex items-center space-x-2 text-xs text-gray-500">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                    </div>
                    <span>AI is typing...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatWidget = document.getElementById('ai-chat-widget');
        const chatToggle = document.getElementById('chat-toggle');
        const chatWindow = document.getElementById('chat-window');
        const minimizeChat = document.getElementById('minimize-chat');
        const chatIcon = document.getElementById('chat-icon');
        const closeIcon = document.getElementById('close-icon');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');
        const sendButton = document.getElementById('send-button');
        const typingIndicator = document.getElementById('typing-indicator');

        let isOpen = false;

        // Toggle chat window
        function toggleChat() {
            isOpen = !isOpen;
            if (isOpen) {
                chatWindow.classList.remove('hidden');
                chatIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                chatInput.focus();
            } else {
                chatWindow.classList.add('hidden');
                chatIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        }

        // Event listeners
        chatToggle.addEventListener('click', toggleChat);
        minimizeChat.addEventListener('click', toggleChat);

        // Add message to chat
        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex items-start space-x-3 chat-message';

            if (isUser) {
                messageDiv.classList.add('justify-end');
                messageDiv.innerHTML = `
                <div class="bg-blue-600 text-white p-3 rounded-lg shadow-sm max-w-xs">
                    <p class="text-sm">${message}</p>
                    <p class="text-xs opacity-75 mt-1">Just now</p>
                </div>
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            `;
            } else {
                messageDiv.innerHTML = `
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm border max-w-xs">
                    <p class="text-sm text-gray-800">${message.replace(/\n/g, '<br>')}</p>
                    <p class="text-xs text-gray-500 mt-1">Just now</p>
                </div>
            `;
            }

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Send message
        async function sendMessage(message) {
            if (!message.trim()) return;

            // Add user message
            addMessage(message, true);
            chatInput.value = '';
            sendButton.disabled = true;

            // Show typing indicator
            typingIndicator.classList.remove('hidden');

            try {
                const response = await fetch('{{ route('ai.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        message: message
                    })
                });

                const data = await response.json();

                // Hide typing indicator
                typingIndicator.classList.add('hidden');

                if (data.success) {
                    // Add AI response
                    addMessage(data.message);
                } else {
                    addMessage('Sorry, I encountered an error. Please try again.');
                }
            } catch (error) {
                typingIndicator.classList.add('hidden');
                addMessage('Sorry, I\'m having trouble connecting. Please try again later.');
                console.error('Chat error:', error);
            } finally {
                sendButton.disabled = false;
            }
        }

        // Form submit handler
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (message) {
                sendMessage(message);
            }
        });

        // Enter key handler
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    });
</script>
