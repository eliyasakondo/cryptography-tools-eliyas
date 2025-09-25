<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Rail Fence Cipher
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        A transposition cipher that writes plaintext in a zigzag pattern across multiple rails
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Input Section -->
                    <div class="space-y-6">
                        <div>
                            <label class="flex items-center space-x-4 mb-4">
                                <input type="radio" wire:model.live="operation" value="encrypt" class="text-green-600">
                                <span class="text-gray-700 dark:text-gray-300">Encrypt</span>
                                <input type="radio" wire:model.live="operation" value="decrypt" class="text-green-600">
                                <span class="text-gray-700 dark:text-gray-300">Decrypt</span>
                            </label>
                        </div>

                        <div>
                            <label for="rails" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Number of Rails (2-10)
                            </label>
                            <input
                                type="number"
                                wire:model="rails"
                                id="rails"
                                min="2"
                                max="10"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                            >
                            @error('rails') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        @if($operation === 'encrypt')
                            <div>
                                <label for="plaintext" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Plaintext
                                </label>
                                <textarea
                                    wire:model="plaintext"
                                    id="plaintext"
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter text to encrypt..."
                                ></textarea>
                                @error('plaintext') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @else
                            <div>
                                <label for="ciphertext" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ciphertext
                                </label>
                                <textarea
                                    wire:model="ciphertext"
                                    id="ciphertext"
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter text to decrypt..."
                                ></textarea>
                                @error('ciphertext') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <button
                            wire:click="process"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md transition-colors"
                        >
                            {{ $operation === 'encrypt' ? 'Encrypt' : 'Decrypt' }}
                        </button>

                        @if($result)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ $operation === 'encrypt' ? 'Encrypted' : 'Decrypted' }} Text
                                </label>
                                <div class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md min-h-[100px] font-mono">
                                    {{ $result }}
                                </div>
                                <button
                                    onclick="copyToClipboard('{{ $result }}')"
                                    class="mt-2 bg-gray-600 hover:bg-gray-700 text-white text-sm py-1 px-3 rounded transition-colors"
                                >
                                    Copy Result
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Visualization and Information -->
                    <div class="space-y-6">
                        <!-- Algorithm Explanation -->
                        <div class="bg-green-50 dark:bg-gray-900 p-4 rounded-lg border border-green-200 dark:border-gray-700">
                            <h3 class="font-semibold text-green-900 dark:text-green-300 mb-2">How Rail Fence Works:</h3>
                            <ul class="text-sm text-green-800 dark:text-green-200 space-y-1">
                                <li>• Write the plaintext in a zigzag pattern across multiple rails</li>
                                <li>• Start at the top rail and move down, then up when reaching the bottom</li>
                                <li>• Read off the ciphertext by reading each rail left to right</li>
                                <li>• The number of rails determines the pattern depth</li>
                            </ul>
                        </div>

                        <!-- Visual Example -->
                        <div class="bg-blue-50 dark:bg-gray-900 p-4 rounded-lg border border-blue-200 dark:border-gray-700">
                            <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">Example with 3 Rails:</h3>
                            <div class="text-sm font-mono text-blue-800 dark:text-blue-200 space-y-2">
                                <div><strong>Plaintext:</strong> "HELLO WORLD"</div>
                                <div class="mt-2 space-y-1">
                                    <div><strong>Pattern:</strong></div>
                                    <div>H . . . O . . . R . .</div>
                                    <div>. E . L . W . L . D .</div>
                                    <div>. . L . . . O . . . .</div>
                                </div>
                                <div class="mt-2">
                                    <div><strong>Read by rails:</strong></div>
                                    <div>Rail 1: HOR</div>
                                    <div>Rail 2: ELWLD</div>
                                    <div>Rail 3: LO</div>
                                    <div><strong>Ciphertext:</strong> HORELWLDLO</div>
                                </div>
                            </div>
                        </div>

                        <!-- Historical Information -->
                        <div class="bg-yellow-50 dark:bg-gray-900 p-4 rounded-lg border border-yellow-200 dark:border-gray-700">
                            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-2">About Rail Fence:</h3>
                            <ul class="text-sm text-yellow-800 dark:text-yellow-200 space-y-1">
                                <li>• Also known as "Zigzag Cipher"</li>
                                <li>• One of the simplest transposition ciphers</li>
                                <li>• Security increases with more rails</li>
                                <li>• Easy to implement and understand</li>
                                <li>• Vulnerable to frequency analysis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Copied to clipboard!');
        });
    }
</script>