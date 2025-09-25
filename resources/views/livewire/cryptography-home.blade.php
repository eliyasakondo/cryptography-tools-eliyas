<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        🔐 Cryptography Tools
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                        Explore classical encryption and decryption algorithms
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mt-8">
                    <!-- Substitution Ciphers -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 p-6 rounded-lg border border-blue-200 dark:border-gray-700">
                        <h2 class="text-2xl font-semibold text-blue-900 dark:text-blue-300 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Substitution Ciphers
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">
                            Replace characters with other characters according to a fixed system
                        </p>
                        <div class="space-y-2">
                            <a href="/caesar-cipher" class="block bg-white dark:bg-gray-800 p-3 rounded border border-blue-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                <strong class="text-blue-800 dark:text-blue-300">Caesar Cipher</strong>
                                <span class="text-gray-600 dark:text-gray-400 text-sm block">Shift each letter by a fixed number</span>
                            </a>
                            <a href="/monoalphabetic-cipher" class="block bg-white dark:bg-gray-800 p-3 rounded border border-blue-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                <strong class="text-blue-800 dark:text-blue-300">Monoalphabetic Substitution</strong>
                                <span class="text-gray-600 dark:text-gray-400 text-sm block">Replace each letter with another letter</span>
                            </a>
                            <a href="/playfair-cipher" class="block bg-white dark:bg-gray-800 p-3 rounded border border-blue-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                <strong class="text-blue-800 dark:text-blue-300">Playfair Cipher</strong>
                                <span class="text-gray-600 dark:text-gray-400 text-sm block">Encrypt pairs of letters using a 5×5 grid</span>
                            </a>
                            <a href="/hill-cipher" class="block bg-white dark:bg-gray-800 p-3 rounded border border-blue-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                <strong class="text-blue-800 dark:text-blue-300">Hill Cipher</strong>
                                <span class="text-gray-600 dark:text-gray-400 text-sm block">Matrix-based polygraphic substitution</span>
                            </a>
                            <a href="/vigenere-cipher" class="block bg-white dark:bg-gray-800 p-3 rounded border border-blue-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                <strong class="text-blue-800 dark:text-blue-300">Vigenère Cipher (Polyalphabetic)</strong>
                                <span class="text-gray-600 dark:text-gray-400 text-sm block">Use a keyword to vary the shift</span>
                            </a>
                            <a href="/one-time-pad" class="block bg-white dark:bg-gray-800 p-3 rounded border border-blue-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                <strong class="text-blue-800 dark:text-blue-300">One-Time Pad</strong>
                                <span class="text-gray-600 dark:text-gray-400 text-sm block">Perfect encryption with a random key</span>
                            </a>
                        </div>
                    </div>

                    <!-- Transposition Ciphers -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-900 dark:to-gray-800 p-6 rounded-lg border border-green-200 dark:border-gray-700">
                        <h2 class="text-2xl font-semibold text-green-900 dark:text-green-300 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Transposition Ciphers
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">
                            Rearrange characters according to a systematic method
                        </p>
                        <div class="space-y-2">
                            <a href="/rail-fence-cipher" class="block bg-white dark:bg-gray-800 p-3 rounded border border-green-200 dark:border-gray-600 hover:bg-green-50 dark:hover:bg-gray-700 transition-colors">
                                <strong class="text-green-800 dark:text-green-300">Rail Fence Cipher</strong>
                                <span class="text-gray-600 dark:text-gray-400 text-sm block">Write text in zigzag pattern across multiple rails</span>
                            </a>
                            <a href="/row-column-transposition" class="block bg-white dark:bg-gray-800 p-3 rounded border border-green-200 dark:border-gray-600 hover:bg-green-50 dark:hover:bg-gray-700 transition-colors">
                                <strong class="text-green-800 dark:text-green-300">Row Column Transposition</strong>
                                <span class="text-gray-600 dark:text-gray-400 text-sm block">Arrange text in grid and read by column order</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">About This Project</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            This educational tool demonstrates various classical cryptographic algorithms. 
                            Each cipher includes both encryption and decryption capabilities with detailed explanations.
                            Perfect for learning about the fundamentals of cryptography and information security.
                        </p>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                            <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-300 mb-2">Project Developer</h4>
                            <div class="text-blue-800 dark:text-blue-200 space-y-1">
                                <p><strong>Name:</strong> Md. Eliyas Akondo</p>
                                <p><strong>Student ID:</strong> 19-0-52-801-035</p>
                                <p><strong>Academic Level:</strong> 4th Year 1st Semester</p>
                                <p><strong>Session:</strong> 2019-20</p>
                                <p><strong>Batch:</strong> 7th Batch</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>