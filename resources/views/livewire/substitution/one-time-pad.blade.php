<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        One-Time Pad (Perfect Encryption)
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        The only theoretically unbreakable encryption method when used correctly
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Input Section -->
                    <div class="space-y-6">
                        <div>
                            <label class="flex items-center space-x-4 mb-4">
                                <input type="radio" wire:model.live="operation" value="encrypt" class="text-red-600">
                                <span class="text-gray-700 dark:text-gray-300">Encrypt</span>
                                <input type="radio" wire:model.live="operation" value="decrypt" class="text-red-600">
                                <span class="text-gray-700 dark:text-gray-300">Decrypt</span>
                            </label>
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter text to decrypt..."
                                ></textarea>
                                @error('ciphertext') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label for="key" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Key (must be at least as long as text)
                                </label>
                                <button
                                    wire:click="generateRandomKey"
                                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-3 rounded transition-colors"
                                >
                                    Generate Random Key
                                </button>
                            </div>
                            <textarea
                                wire:model="key"
                                id="key"
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white font-mono"
                                placeholder="Enter random key or generate one..."
                            ></textarea>
                            @error('key') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button
                            wire:click="process"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition-colors"
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

                    <!-- Information Section -->
                    <div class="space-y-6">
                        <!-- Perfect Security Notice -->
                        <div class="bg-red-50 dark:bg-gray-900 p-4 rounded-lg border border-red-200 dark:border-gray-700">
                            <h3 class="font-semibold text-red-900 dark:text-red-300 mb-2">⚠️ Perfect Security Requirements:</h3>
                            <ul class="text-sm text-red-800 dark:text-red-200 space-y-1">
                                <li>• Key must be truly random</li>
                                <li>• Key must be at least as long as the message</li>
                                <li>• Key must never be reused</li>
                                <li>• Key must be kept completely secret</li>
                                <li>• If all conditions are met, encryption is unbreakable</li>
                            </ul>
                        </div>

                        <!-- Algorithm Explanation -->
                        <div class="bg-blue-50 dark:bg-gray-900 p-4 rounded-lg border border-blue-200 dark:border-gray-700">
                            <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">How One-Time Pad Works:</h3>
                            <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                <li>• Similar to Vigenère but with a random, non-repeating key</li>
                                <li>• Each letter is shifted by the corresponding key letter</li>
                                <li>• Encryption: (Plaintext + Key) mod 26</li>
                                <li>• Decryption: (Ciphertext - Key + 26) mod 26</li>
                                <li>• No patterns or repetitions in the key</li>
                            </ul>
                        </div>

                        <!-- Example -->
                        <div class="bg-green-50 dark:bg-gray-900 p-4 rounded-lg border border-green-200 dark:border-gray-700">
                            <h3 class="font-semibold text-green-900 dark:text-green-300 mb-2">Example:</h3>
                            <div class="text-sm font-mono text-green-800 dark:text-green-200 space-y-1">
                                <div><strong>Plaintext:</strong> HELLO</div>
                                <div><strong>Random Key:</strong> XMCKL</div>
                                <div class="mt-2">
                                    <div><strong>Encryption:</strong></div>
                                    <div>H(7) + X(23) = 30 mod 26 = E(4)</div>
                                    <div>E(4) + M(12) = 16 mod 26 = Q(16)</div>
                                    <div>L(11) + C(2) = 13 mod 26 = N(13)</div>
                                    <div>L(11) + K(10) = 21 mod 26 = V(21)</div>
                                    <div>O(14) + L(11) = 25 mod 26 = Z(25)</div>
                                </div>
                                <div><strong>Ciphertext:</strong> EQNVZ</div>
                            </div>
                        </div>

                        <!-- Historical Information -->
                        <div class="bg-purple-50 dark:bg-gray-900 p-4 rounded-lg border border-purple-200 dark:border-gray-700">
                            <h3 class="font-semibold text-purple-900 dark:text-purple-300 mb-2">Historical Usage:</h3>
                            <ul class="text-sm text-purple-800 dark:text-purple-200 space-y-1">
                                <li>• Used by diplomats and spies during both World Wars</li>
                                <li>• Soviet agents used it extensively during Cold War</li>
                                <li>• Moscow-Washington hotline used OTP</li>
                                <li>• Still used today for highest security communications</li>
                                <li>• Proven mathematically unbreakable by Claude Shannon</li>
                            </ul>
                        </div>

                        <!-- Practical Limitations -->
                        <div class="bg-yellow-50 dark:bg-gray-900 p-4 rounded-lg border border-yellow-200 dark:border-gray-700">
                            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-2">Practical Limitations:</h3>
                            <ul class="text-sm text-yellow-800 dark:text-yellow-200 space-y-1">
                                <li>• Key distribution problem - how to securely share keys</li>
                                <li>• Key storage - large amounts of random data needed</li>
                                <li>• Key generation - truly random keys are difficult to create</li>
                                <li>• One-time use only - keys cannot be reused</li>
                                <li>• Not practical for most modern communications</li>
                            </ul>
                        </div>

                        <!-- Security Warning -->
                        <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg border border-gray-300 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-300 mb-2">⚠️ Educational Purpose Only:</h3>
                            <p class="text-sm text-gray-700 dark:text-gray-400">
                                This implementation is for educational demonstration. The key generation here is NOT cryptographically secure. 
                                For real OTP usage, use proper random number generators and secure key management.
                            </p>
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