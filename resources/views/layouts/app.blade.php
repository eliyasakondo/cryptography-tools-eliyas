<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cryptography Tools') }} - By Md. Eliyas Akondo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <a href="/" class="text-xl font-bold text-gray-800 dark:text-white">
                                    🔐 Cryptography Tools
                                </a>
                            </div>
                            
                            <!-- Desktop Navigation -->
                            <div class="hidden md:ml-6 md:flex md:space-x-8">
                                <div class="relative group">
                                    <button class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white px-3 py-2 text-sm font-medium flex items-center">
                                        Substitution Ciphers
                                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                        <div class="py-1">
                                            <a href="/caesar-cipher" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Caesar Cipher</a>
                                            <a href="/monoalphabetic-cipher" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Monoalphabetic Substitution</a>
                                            <a href="/playfair-cipher" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Playfair Cipher</a>
                                            <a href="/hill-cipher" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Hill Cipher</a>
                                            <a href="/vigenere-cipher" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Vigenère Cipher (Polyalphabetic)</a>
                                            <a href="/one-time-pad" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">One-Time Pad</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="relative group">
                                    <button class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white px-3 py-2 text-sm font-medium flex items-center">
                                        Transposition Ciphers
                                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                        <div class="py-1">
                                            <a href="/rail-fence-cipher" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Rail Fence Cipher</a>
                                            <a href="/row-column-transposition" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Row Column Transposition</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="/about" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white px-3 py-2 text-sm font-medium">About</a>
                            </div>
                        </div>
                        
                        <!-- Mobile menu button -->
                        <div class="md:hidden flex items-center">
                            <button onclick="toggleMobileMenu()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Navigation Menu -->
                <div id="mobile-menu" class="md:hidden hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                        <div class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Substitution Ciphers</div>
                        <a href="/caesar-cipher" class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Caesar Cipher</a>
                        <a href="/monoalphabetic-cipher" class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Monoalphabetic Substitution</a>
                        <a href="/playfair-cipher" class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Playfair Cipher</a>
                        <a href="/hill-cipher" class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Hill Cipher</a>
                        <a href="/vigenere-cipher" class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Vigenère Cipher</a>
                        <a href="/one-time-pad" class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">One-Time Pad</a>
                        
                        <div class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200">Transposition Ciphers</div>
                        <a href="/rail-fence-cipher" class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Rail Fence Cipher</a>
                        <a href="/row-column-transposition" class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Row Column Transposition</a>
                        
                        <a href="/about" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">About</a>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            
            <!-- Footer -->
            <footer style="background-color: #1f2937; border-top: 1px solid #4b5563; margin-top: 3rem; color: white;">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #ffffff;">🔐 Cryptography Tools</h3>
                            <p style="color: #ffffff; font-size: 0.875rem; line-height: 1.5;">
                                An educational platform for learning classical cryptographic algorithms. 
                                This project demonstrates various substitution and transposition ciphers 
                                with interactive encryption and decryption capabilities.
                            </p>
                        </div>
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; color: #ffffff;">Project Information</h3>
                            <div style="color: #ffffff; font-size: 0.875rem;">
                                <p style="margin-bottom: 0.5rem;"><strong style="color: #fbbf24;">Developer:</strong> <span style="color: #ffffff;">Md. Eliyas Akondo</span></p>
                                <p style="margin-bottom: 0.5rem;"><strong style="color: #fbbf24;">Student ID:</strong> <span style="color: #ffffff;">19-0-52-801-035</span></p>
                                <p style="margin-bottom: 0.5rem;"><strong style="color: #fbbf24;">Academic Level:</strong> <span style="color: #ffffff;">4th Year 1st Semester</span></p>
                                <p style="margin-bottom: 0.5rem;"><strong style="color: #fbbf24;">Session:</strong> <span style="color: #ffffff;">2019-20</span></p>
                                <p style="margin-bottom: 0.5rem;"><strong style="color: #fbbf24;">Batch:</strong> <span style="color: #ffffff;">7th Batch</span></p>
                                <p style="padding-top: 0.5rem;"><strong style="color: #fbbf24;">Technology Stack:</strong> <span style="color: #ffffff;">Laravel 11, Livewire 3, Tailwind CSS</span></p>
                            </div>
                        </div>
                    </div>
                    <div style="border-top: 1px solid #6b7280; margin-top: 2rem; padding-top: 1.5rem; text-align: center;">
                        <p style="color: #ffffff; font-size: 0.875rem;">
                            © {{ date('Y') }} Cryptography Tools. Developed for educational purposes by <span style="color: #fbbf24; font-weight: bold;">Md. Eliyas Akondo</span>.
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }
        </script>

        @livewireScripts
    </body>
</html>