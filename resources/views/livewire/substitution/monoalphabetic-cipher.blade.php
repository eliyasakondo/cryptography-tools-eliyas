<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Monoalphabetic Substitution Cipher
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        Replace each letter of the alphabet with another letter using a fixed substitution key
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Input Section -->
                    <div class="space-y-6">
                        <div>
                            <label class="flex items-center space-x-4 mb-4">
                                <input type="radio" wire:model.live="operation" value="encrypt" class="text-indigo-600">
                                <span class="text-gray-700 dark:text-gray-300">Encrypt</span>
                                <input type="radio" wire:model.live="operation" value="decrypt" class="text-indigo-600">
                                <span class="text-gray-700 dark:text-gray-300">Decrypt</span>
                            </label>
                        </div>

                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Substitution Key (26 unique letters)
                            </label>
                            <input
                                type="text"
                                wire:model="key"
                                id="key"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white font-mono"
                                placeholder="ZYXWVUTSRQPONMLKJIHGFEDCBA (example)"
                                maxlength="26"
                            >
                            <button
                                wire:click="generateRandomKey"
                                class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-1 px-3 rounded transition-colors"
                            >
                                Generate Random Key
                            </button>
                            @error('key') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter text to decrypt..."
                                ></textarea>
                                @error('ciphertext') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <button
                            wire:click="process"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition-colors"
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

                    <!-- Information and Mapping -->
                    <div class="space-y-6">
                        @if($key && strlen($key) === 26)
                            <div class="bg-indigo-50 dark:bg-gray-900 p-4 rounded-lg border border-indigo-200 dark:border-gray-700">
                                <h3 class="font-semibold text-indigo-900 dark:text-indigo-300 mb-2">Substitution Mapping:</h3>
                                <div class="text-sm font-mono text-indigo-800 dark:text-indigo-200 space-y-1">
                                    <div>Normal: ABCDEFGHIJKLMNOPQRSTUVWXYZ</div>
                                    <div>Cipher: {{ strtoupper($key) }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Algorithm Explanation -->
                        <div class="bg-blue-50 dark:bg-gray-900 p-4 rounded-lg border border-blue-200 dark:border-gray-700">
                            <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">How Monoalphabetic Works:</h3>
                            <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                <li>• Each letter is consistently replaced with another letter</li>
                                <li>• The key is a permutation of the 26 letters</li>
                                <li>• A maps to the 1st key letter, B to the 2nd, etc.</li>
                                <li>• Same input letter always produces same output letter</li>
                                <li>• More secure than Caesar cipher but vulnerable to frequency analysis</li>
                            </ul>
                        </div>

                        <!-- Example -->
                        <div class="bg-green-50 dark:bg-gray-900 p-4 rounded-lg border border-green-200 dark:border-gray-700">
                            <h3 class="font-semibold text-green-900 dark:text-green-300 mb-2">Example:</h3>
                            <div class="text-sm font-mono text-green-800 dark:text-green-200 space-y-2">
                                <div><strong>Key:</strong> ZYXWVUTSRQPONMLKJIHGFEDCBA</div>
                                <div><strong>Plaintext:</strong> HELLO</div>
                                <div class="mt-2">
                                    <div><strong>Mapping:</strong></div>
                                    <div>H → S (8th letter → 8th in key)</div>
                                    <div>E → V (5th letter → 5th in key)</div>
                                    <div>L → O (12th letter → 12th in key)</div>
                                    <div>L → O</div>
                                    <div>O → L (15th letter → 15th in key)</div>
                                </div>
                                <div><strong>Ciphertext:</strong> SVOOL</div>
                            </div>
                        </div>

                        <!-- Security Information -->
                        <div class="bg-yellow-50 dark:bg-gray-900 p-4 rounded-lg border border-yellow-200 dark:border-gray-700">
                            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-2">Security Notes:</h3>
                            <ul class="text-sm text-yellow-800 dark:text-yellow-200 space-y-1">
                                <li>• Key space: 26! ≈ 4 × 10²⁶ possible keys</li>
                                <li>• Vulnerable to frequency analysis</li>
                                <li>• Letter patterns remain visible</li>
                                <li>• Can be broken with enough ciphertext</li>
                                <li>• Historically used in simple secret codes</li>
                            </ul>
                        </div>

                        <!-- Key Requirements -->
                        <div class="bg-red-50 dark:bg-gray-900 p-4 rounded-lg border border-red-200 dark:border-gray-700">
                            <h3 class="font-semibold text-red-900 dark:text-red-300 mb-2">Key Requirements:</h3>
                            <ul class="text-sm text-red-800 dark:text-red-200 space-y-1">
                                <li>• Must contain exactly 26 letters</li>
                                <li>• Each letter A-Z must appear exactly once</li>
                                <li>• No duplicate letters allowed</li>
                                <li>• Case insensitive (converted to uppercase)</li>
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