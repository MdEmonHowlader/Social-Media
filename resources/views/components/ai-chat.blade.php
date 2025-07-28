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
            <div class="flex items-center space-x-2">
                <!-- Language Toggle -->
                <button id="language-toggle" class="text-white hover:text-gray-200 transition-colors"
                    title="Switch Language">
                    <div class="flex items-center space-x-1">
                        <span id="current-language" class="text-xs font-medium">EN</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7 2a1 1 0 011 1v1h3a1 1 0 110 2H9.578a18.87 18.87 0 01-1.724 4.78c.29.354.596.696.914 1.026a1 1 0 11-1.44 1.389c-.188-.196-.373-.396-.554-.6a19.098 19.098 0 01-3.107 3.567 1 1 0 01-1.334-1.49 17.087 17.087 0 003.13-3.733 18.992 18.992 0 01-1.487-2.494 1 1 0 111.79-.89c.234.47.489.928.764 1.372.417-.934.752-1.913.997-2.927H3a1 1 0 110-2h3V3a1 1 0 011-1zm6 6a1 1 0 01.894.553l2.991 5.982a.869.869 0 01.02.037l.99 1.98a1 1 0 11-1.79.895L15.383 16h-4.764l-.724 1.447a1 1 0 11-1.788-.894l.99-1.98.019-.038 2.99-5.982A1 1 0 0113 8zm-1.382 6h2.764L13 11.236 11.618 14z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </button>

                <!-- Voice Controls -->
                <button id="toggle-speech" class="text-white hover:text-gray-200 transition-colors"
                    title="Toggle Text-to-Speech">
                    <svg id="speech-on-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.789L5.5 14H3a1 1 0 01-1-1V7a1 1 0 011-1h2.5l2.883-2.789a1 1 0 011.617.765zM12 6.5a.5.5 0 01.858-.353 3 3 0 010 4.702A.5.5 0 0112 10.5V6.5z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg id="speech-off-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.789L5.5 14H3a1 1 0 01-1-1V7a1 1 0 011-1h2.5l2.883-2.789a1 1 0 011.617.765zM12.293 7.293a1 1 0 011.414 0L15 8.586l1.293-1.293a1 1 0 111.414 1.414L16.414 10l1.293 1.293a1 1 0 01-1.414 1.414L15 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L13.586 10l-1.293-1.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <button id="minimize-chat" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Language Status Indicator -->
        <div id="language-status" class="bg-blue-50 border-b border-blue-200 px-4 py-2">
            <div class="flex items-center justify-between text-sm">
                <span class="text-blue-700">
                    <span id="language-indicator">🇺🇸 English</span>
                </span>
                <span class="text-blue-600 text-xs" id="voice-language-status">Voice: English</span>
            </div>
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
                    <p class="text-sm text-gray-800" id="welcome-message">Hello! I'm your AI assistant. How can I help
                        you today?</p>
                    <p class="text-xs text-gray-500 mt-1">Just now</p>
                    <!-- Voice Controls for AI Messages -->
                    <div class="flex items-center space-x-2 mt-2">
                        <button class="speak-button text-blue-600 hover:text-blue-800 transition-colors"
                            title="Listen to message"
                            data-message="Hello! I'm your AI assistant. How can I help you today?">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.789L5.5 14H3a1 1 0 01-1-1V7a1 1 0 011-1h2.5l2.883-2.789a1 1 0 011.617.765zM12 6.5a.5.5 0 01.858-.353 3 3 0 010 4.702A.5.5 0 0112 10.5V6.5z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <span class="text-xs text-gray-400" id="listen-hint">Click to listen</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Voice Recording Indicator -->
        <div id="voice-recording" class="hidden bg-red-50 border-t border-red-200 p-3">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                <span class="text-sm text-red-700" id="recording-text">Recording... Speak now</span>
                <div class="ml-auto flex items-center space-x-2">
                    <span class="text-xs text-red-600" id="recording-language">EN</span>
                    <button id="stop-recording" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="p-4 border-t border-gray-200 bg-white">
            <form id="chat-form" class="flex space-x-2">
                <input type="text" id="chat-input" placeholder="Type your message..."
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    maxlength="1000">

                <!-- Voice Input Button -->
                <button type="button" id="voice-input"
                    class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    title="Voice Input">
                    <svg id="mic-icon" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg id="mic-recording-icon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <button type="submit" id="send-button"
                    class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>

            <!-- Voice Error Message -->
            <div id="voice-error"
                class="hidden mt-2 p-2 bg-red-50 border border-red-200 rounded text-xs text-red-700">
                <span id="voice-error-message"></span>
            </div>

            <div id="typing-indicator" class="hidden mt-2">
                <div class="flex items-center space-x-2 text-xs text-gray-500">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                    </div>
                    <span id="typing-text">AI is typing...</span>
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

        // Voice-related elements
        const voiceInputButton = document.getElementById('voice-input');
        const micIcon = document.getElementById('mic-icon');
        const micRecordingIcon = document.getElementById('mic-recording-icon');
        const voiceRecording = document.getElementById('voice-recording');
        const stopRecordingButton = document.getElementById('stop-recording');
        const voiceError = document.getElementById('voice-error');
        const voiceErrorMessage = document.getElementById('voice-error-message');
        const toggleSpeechButton = document.getElementById('toggle-speech');
        const speechOnIcon = document.getElementById('speech-on-icon');
        const speechOffIcon = document.getElementById('speech-off-icon');

        // Language-related elements
        const languageToggle = document.getElementById('language-toggle');
        const currentLanguageSpan = document.getElementById('current-language');
        const languageIndicator = document.getElementById('language-indicator');
        const voiceLanguageStatus = document.getElementById('voice-language-status');
        const recordingLanguage = document.getElementById('recording-language');
        const welcomeMessage = document.getElementById('welcome-message');
        const listenHint = document.getElementById('listen-hint');
        const recordingText = document.getElementById('recording-text');
        const typingText = document.getElementById('typing-text');

        let isOpen = false;
        let isRecording = false;
        let recognition = null;
        let speechEnabled = true;
        let currentSpeech = null;
        let currentLanguage = 'en'; // 'en' for English, 'bn' for Bengali

        // Language configurations
        const languages = {
            'en': {
                code: 'en-US',
                name: 'English',
                flag: '🇺🇸',
                shortCode: 'EN',
                voicePrefix: 'en',
                placeholder: 'Type your message...',
                welcomeMessage: "Hello! I'm your AI assistant. How can I help you today?",
                listenHint: 'Click to listen',
                recordingText: 'Recording... Speak now',
                typingText: 'AI is typing...',
                voiceStatus: 'Voice: English'
            },
            'bn': {
                code: 'bn-BD',
                name: 'বাংলা',
                flag: '🇧🇩',
                shortCode: 'বাং',
                voicePrefix: 'bn',
                placeholder: 'আপনার বার্তা টাইপ করুন...',
                welcomeMessage: "হ্যালো! আমি আপনার AI সহায়ক। আজ আমি আপনাকে কীভাবে সাহায্য করতে পারি?",
                listenHint: 'শুনতে ক্লিক করুন',
                recordingText: 'রেকর্ড করছি... এখন কথা বলুন',
                typingText: 'AI টাইপ করছে...',
                voiceStatus: 'ভয়েস: বাংলা'
            }
        };

        // Language detection patterns
        const bengaliPattern = /[\u0980-\u09FF]/;

        // Initialize Speech Recognition
        function initSpeechRecognition() {
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                recognition = new SpeechRecognition();
                recognition.continuous = false;
                recognition.interimResults = false;
                updateRecognitionLanguage();

                recognition.onstart = function() {
                    isRecording = true;
                    voiceRecording.classList.remove('hidden');
                    micIcon.classList.add('hidden');
                    micRecordingIcon.classList.remove('hidden');
                    voiceInputButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                    voiceInputButton.classList.add('bg-red-600', 'hover:bg-red-700');
                    hideVoiceError();
                };

                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    chatInput.value = transcript;
                    chatInput.focus();

                    // Auto-detect language if Bengali characters are found
                    if (bengaliPattern.test(transcript) && currentLanguage === 'en') {
                        switchLanguage('bn');
                    } else if (!bengaliPattern.test(transcript) && currentLanguage === 'bn') {
                        // Only switch to English if it's clearly English text (contains Latin letters)
                        if (/[a-zA-Z]/.test(transcript)) {
                            switchLanguage('en');
                        }
                    }
                };

                recognition.onerror = function(event) {
                    let errorMessage = getLocalizedErrorMessage(event.error);
                    showVoiceError(errorMessage);
                };

                recognition.onend = function() {
                    stopRecording();
                };
            }
        }

        // Get localized error messages
        function getLocalizedErrorMessage(error) {
            const errorMessages = {
                'en': {
                    'no-speech': 'No speech detected. Please try again.',
                    'audio-capture': 'Microphone not accessible. Please check permissions.',
                    'not-allowed': 'Microphone access denied. Please allow microphone access.',
                    'network': 'Network error. Please check your internet connection.',
                    'default': 'Speech recognition error: '
                },
                'bn': {
                    'no-speech': 'কোনো কথা শনাক্ত হয়নি। অনুগ্রহ করে আবার চেষ্টা করুন।',
                    'audio-capture': 'মাইক্রোফোন অ্যাক্সেস করা যাচ্ছে না। অনুমতি পরীক্ষা করুন।',
                    'not-allowed': 'মাইক্রোফোন অ্যাক্সেস প্রত্যাখ্যান করা হয়েছে। অনুগ্রহ করে মাইক্রোফোন অ্যাক্সেসের অনুমতি দিন।',
                    'network': 'নেটওয়ার্ক ত্রুটি। অনুগ্রহ করে আপনার ইন্টারনেট সংযোগ পরীক্ষা করুন।',
                    'default': 'স্পিচ রিকগনিশন ত্রুটি: '
                }
            };

            const messages = errorMessages[currentLanguage];
            return messages[error] || messages['default'] + error;
        }

        // Update speech recognition language
        function updateRecognitionLanguage() {
            if (recognition) {
                recognition.lang = languages[currentLanguage].code;
            }
        }

        // Switch language
        function switchLanguage(langCode) {
            currentLanguage = langCode;
            const lang = languages[langCode];

            // Update UI elements
            currentLanguageSpan.textContent = lang.shortCode;
            languageIndicator.textContent = `${lang.flag} ${lang.name}`;
            voiceLanguageStatus.textContent = lang.voiceStatus;
            recordingLanguage.textContent = lang.shortCode;
            chatInput.placeholder = lang.placeholder;
            welcomeMessage.textContent = lang.welcomeMessage;
            listenHint.textContent = lang.listenHint;
            recordingText.textContent = lang.recordingText;
            typingText.textContent = lang.typingText;

            // Update welcome message data attribute for voice
            const welcomeSpeakButton = document.querySelector('.speak-button');
            if (welcomeSpeakButton) {
                welcomeSpeakButton.setAttribute('data-message', lang.welcomeMessage);
            }

            // Update speech recognition language
            updateRecognitionLanguage();

            // Store language preference
            localStorage.setItem('ai-chat-language', langCode);
        }

        // Initialize Text-to-Speech
        function initTextToSpeech() {
            if ('speechSynthesis' in window) {
                // Speech synthesis is available
                return true;
            } else {
                console.warn('Text-to-speech not supported in this browser');
                toggleSpeechButton.style.display = 'none';
                return false;
            }
        }

        // Voice input functions
        function startRecording() {
            if (recognition) {
                try {
                    recognition.start();
                } catch (error) {
                    showVoiceError(getLocalizedErrorMessage('default') + error.message);
                }
            } else {
                showVoiceError(currentLanguage === 'en' ?
                    'Speech recognition not supported in your browser.' :
                    'আপনার ব্রাউজারে স্পিচ রিকগনিশন সমর্থিত নয়।');
            }
        }

        function stopRecording() {
            if (recognition && isRecording) {
                recognition.stop();
            }
            isRecording = false;
            voiceRecording.classList.add('hidden');
            micIcon.classList.remove('hidden');
            micRecordingIcon.classList.add('hidden');
            voiceInputButton.classList.remove('bg-red-600', 'hover:bg-red-700');
            voiceInputButton.classList.add('bg-green-600', 'hover:bg-green-700');
        }

        function showVoiceError(message) {
            voiceErrorMessage.textContent = message;
            voiceError.classList.remove('hidden');
            setTimeout(() => hideVoiceError(), 5000);
        }

        function hideVoiceError() {
            voiceError.classList.add('hidden');
        }

        // Text-to-speech functions
        function speakText(text) {
            if (!speechEnabled || !('speechSynthesis' in window)) return;

            // Stop any current speech
            if (currentSpeech) {
                speechSynthesis.cancel();
            }

            // Clean text for speech (remove markdown and special characters)
            const cleanText = text.replace(/[*#_`]/g, '').replace(/\n/g, '. ');

            currentSpeech = new SpeechSynthesisUtterance(cleanText);
            currentSpeech.rate = 0.9;
            currentSpeech.pitch = 1;
            currentSpeech.volume = 0.8;

            // Try to use appropriate voice for current language
            const voices = speechSynthesis.getVoices();
            const langPrefix = languages[currentLanguage].voicePrefix;

            let preferredVoice;
            if (currentLanguage === 'bn') {
                // For Bengali, look for Bengali voices
                preferredVoice = voices.find(voice =>
                    voice.lang.startsWith('bn') ||
                    voice.name.toLowerCase().includes('bengali') ||
                    voice.name.toLowerCase().includes('bangla')
                );
            } else {
                // For English, prefer high-quality English voices
                preferredVoice = voices.find(voice =>
                    voice.lang.startsWith('en') &&
                    (voice.name.includes('Google') || voice.name.includes('Microsoft'))
                ) || voices.find(voice => voice.lang.startsWith('en'));
            }

            if (preferredVoice) {
                currentSpeech.voice = preferredVoice;
            }

            speechSynthesis.speak(currentSpeech);
        }

        function toggleSpeech() {
            speechEnabled = !speechEnabled;
            if (speechEnabled) {
                speechOnIcon.classList.remove('hidden');
                speechOffIcon.classList.add('hidden');
                toggleSpeechButton.title = currentLanguage === 'en' ?
                    'Disable Text-to-Speech' : 'টেক্সট-টু-স্পিচ নিষ্ক্রিয় করুন';
            } else {
                speechOnIcon.classList.add('hidden');
                speechOffIcon.classList.remove('hidden');
                toggleSpeechButton.title = currentLanguage === 'en' ?
                    'Enable Text-to-Speech' : 'টেক্সট-টু-স্পিচ সক্রিয় করুন';
                if (currentSpeech) {
                    speechSynthesis.cancel();
                }
            }
        }

        // Auto-detect language from text
        function detectLanguage(text) {
            if (bengaliPattern.test(text)) {
                return 'bn';
            } else if (/[a-zA-Z]/.test(text)) {
                return 'en';
            }
            return currentLanguage; // Keep current if can't detect
        }

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
                // Stop any ongoing speech or recording
                if (currentSpeech) speechSynthesis.cancel();
                if (isRecording) stopRecording();
            }
        }

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
                const messageId = 'msg-' + Date.now();
                messageDiv.innerHTML = `
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm border max-w-xs">
                    <p class="text-sm text-gray-800">${message.replace(/\n/g, '<br>')}</p>
                    <p class="text-xs text-gray-500 mt-1">Just now</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <button class="speak-button text-blue-600 hover:text-blue-800 transition-colors" 
                                data-message="${message.replace(/"/g, '&quot;')}" title="${languages[currentLanguage].listenHint}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.789L5.5 14H3a1 1 0 01-1-1V7a1 1 0 011-1h2.5l2.883-2.789a1 1 0 011.617.765zM12 6.5a.5.5 0 01.858-.353 3 3 0 010 4.702A.5.5 0 0112 10.5V6.5z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <span class="text-xs text-gray-400">${languages[currentLanguage].listenHint}</span>
                    </div>
                </div>
            `;

                // Auto-speak AI responses if speech is enabled
                setTimeout(() => {
                    if (speechEnabled) {
                        speakText(message);
                    }
                }, 500);
            }

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Send message
        async function sendMessage(message) {
            if (!message.trim()) return;

            // Auto-detect and switch language if needed
            const detectedLang = detectLanguage(message);
            if (detectedLang !== currentLanguage) {
                switchLanguage(detectedLang);
            }

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
                        message: message,
                        language: currentLanguage
                    })
                });

                const data = await response.json();

                // Hide typing indicator
                typingIndicator.classList.add('hidden');

                if (data.success) {
                    // Add AI response
                    addMessage(data.message);
                } else {
                    const errorMsg = currentLanguage === 'en' ?
                        'Sorry, I encountered an error. Please try again.' :
                        'দুঃখিত, আমার একটি ত্রুটি হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।';
                    addMessage(errorMsg);
                }
            } catch (error) {
                typingIndicator.classList.add('hidden');
                const errorMsg = currentLanguage === 'en' ?
                    'Sorry, I\'m having trouble connecting. Please try again later.' :
                    'দুঃখিত, আমার সংযোগে সমস্যা হচ্ছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।';
                addMessage(errorMsg);
                console.error('Chat error:', error);
            } finally {
                sendButton.disabled = false;
            }
        }

        // Event listeners
        chatToggle.addEventListener('click', toggleChat);
        minimizeChat.addEventListener('click', toggleChat);

        // Language toggle event listener
        languageToggle.addEventListener('click', function() {
            const newLang = currentLanguage === 'en' ? 'bn' : 'en';
            switchLanguage(newLang);
        });

        // Voice input event listeners
        voiceInputButton.addEventListener('click', function() {
            if (isRecording) {
                stopRecording();
            } else {
                startRecording();
            }
        });

        stopRecordingButton.addEventListener('click', stopRecording);

        // Speech toggle event listener
        toggleSpeechButton.addEventListener('click', toggleSpeech);

        // Speak button event listeners (for individual AI messages)
        chatMessages.addEventListener('click', function(e) {
            if (e.target.closest('.speak-button')) {
                const button = e.target.closest('.speak-button');
                const message = button.getAttribute('data-message');
                if (message) {
                    speakText(message);
                }
            }
        });

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

        // Initialize voice features
        initSpeechRecognition();
        initTextToSpeech();

        // Load saved language preference
        const savedLanguage = localStorage.getItem('ai-chat-language');
        if (savedLanguage && languages[savedLanguage]) {
            switchLanguage(savedLanguage);
        }

        // Load voices when they become available
        if ('speechSynthesis' in window) {
            speechSynthesis.onvoiceschanged = function() {
                // Voices are now loaded
            };
        }
    });
</script>
