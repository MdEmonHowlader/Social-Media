<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Md.Emon</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind styles will be here in production */
        </style>
    @endif
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation -->
        <header class="flex justify-between items-center mb-12 bg-gray-50 dark:bg-gray-900 p-4 rounded-lg shadow-sm">
            <div
                class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent hover:from-purple-600 hover:to-blue-600 transition duration-300">
                Md.Emon</div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-2 bg-black text-white dark:bg-white dark:text-black rounded-md hover:opacity-90 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2 border border-gray-300 dark:border-gray-700 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-5 py-2 bg-black text-white dark:bg-white dark:text-black rounded-md hover:opacity-90 transition">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Main Content -->
        <main class="flex flex-col lg:flex-row gap-10 items-center justify-center min-h-[60vh] my-12">
            <div class="max-w-md">
                <h1 class="text-4xl font-bold mb-4">Welcome to My Medium Page</h1>
                <p class="text-lg mb-6 text-gray-700 dark:text-gray-300">
                    I'm a passionate developer focused on creating elegant solutions using modern technologies.
                </p>
                <div class="flex gap-4">
                    {{-- <a href="{{ route('contact-public') }}"
                        class="px-6 py-3 bg-black text-white dark:bg-white dark:text-black rounded-md hover:opacity-90 transition">
                        Contact Me
                    </a> --}}
                    {{-- <a href="#projects" class="px-6 py-3 border border-black dark:border-white rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            View Projects
                        </a> --}}
                </div>
            </div>

            <div class="w-full max-w-md bg-gray-100 dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4">My Skills</h2>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-black dark:bg-white rounded-full"></span>
                        <span>Web Development</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-black dark:bg-white rounded-full"></span>
                        <span>Laravel</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-black dark:bg-white rounded-full"></span>
                        <span>Frontend Design</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-black dark:bg-white rounded-full"></span>
                        <span>Database Management</span>
                    </li>
                </ul>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-20 py-6 border-t border-gray-200 dark:border-gray-800 text-center">
            <p class="text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} Md.Emon. All rights reserved.
            </p>
        </footer>
    </div>
</body>

</html>
