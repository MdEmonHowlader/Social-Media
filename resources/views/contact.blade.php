<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-6 shadow-lg">
            <h2 class="font-bold text-2xl leading-tight">
                {{ __('Contact Me') }}
            </h2>
            <p class="mt-2 text-blue-100">Get in touch and let's start a conversation</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8 lg:p-12">
                    <!-- Header Section -->
                    <div class="text-center mb-12">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">Let's Connect</h1>
                        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                            I'd love to hear from you! Whether you have a question, feedback, or just want to say hello.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Contact Information -->
                        <div class="space-y-8">
                            <div
                                class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 border border-blue-100">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h3>
                                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                                    Feel free to reach out using the form or contact me directly through the information
                                    below.
                                </p>

                                <div class="space-y-6">
                                    <div
                                        class="group flex items-center space-x-4 p-4 rounded-xl hover:bg-white transition-all duration-300 cursor-pointer">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-gray-900 font-semibold text-lg">Email</p>
                                            <p class="text-blue-600 font-medium">emonhowlader676@gmail.com</p>
                                        </div>
                                    </div>

                                    <div
                                        class="group flex items-center space-x-4 p-4 rounded-xl hover:bg-white transition-all duration-300 cursor-pointer">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-gray-900 font-semibold text-lg">Location</p>
                                            <p class="text-gray-600">Available Worldwide</p>
                                        </div>
                                    </div>

                                    <div
                                        class="group flex items-center space-x-4 p-4 rounded-xl hover:bg-white transition-all duration-300 cursor-pointer">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-gray-900 font-semibold text-lg">Response Time</p>
                                            <p class="text-gray-600">Usually within 24 hours</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info Card -->
                            <div
                                class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                                <h4 class="font-semibold text-gray-900 mb-2">Why reach out?</h4>
                                <ul class="text-gray-600 space-y-1 text-sm">
                                    <li>• Project collaborations</li>
                                    <li>• Technical discussions</li>
                                    <li>• Feedback and suggestions</li>
                                    <li>• Just to say hello!</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div>
                            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Send a Message</h3>

                                <!-- Success Message -->
                                @if (session('success'))
                                    <div
                                        class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center">
                                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                                    @csrf

                                    <!-- Name -->
                                    <div class="space-y-2">
                                        <x-input-label for="name" :value="__('Name')"
                                            class="text-gray-700 font-medium" />
                                        <x-text-input id="name"
                                            class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200"
                                            type="text" name="name" :value="old('name')" required autofocus />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <x-input-label for="email" :value="__('Email')"
                                            class="text-gray-700 font-medium" />
                                        <x-text-input id="email"
                                            class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200"
                                            type="email" name="email" :value="old('email')" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Subject -->
                                    <div class="space-y-2">
                                        <x-input-label for="subject" :value="__('Subject')"
                                            class="text-gray-700 font-medium" />
                                        <x-text-input id="subject"
                                            class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200"
                                            type="text" name="subject" :value="old('subject')" required />
                                        <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                                    </div>

                                    <!-- Message -->
                                    <div class="space-y-2">
                                        <x-input-label for="message" :value="__('Message')"
                                            class="text-gray-700 font-medium" />
                                        <x-textarea-input id="message"
                                            class="block w-full h-32 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200 resize-none"
                                            name="message" :value="old('message')" required
                                            placeholder="Tell me what's on your mind..." />
                                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                                    </div>

                                    <div class="pt-4">
                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                            <span class="flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                </svg>
                                                {{ __('Send Message') }}
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
