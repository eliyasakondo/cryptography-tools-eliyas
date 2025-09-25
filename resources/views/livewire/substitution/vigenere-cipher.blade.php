<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Vigenère Cipher (Polyalphabetic)
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        A polyalphabetic substitution cipher that uses a keyword to vary the shift for each letter
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Input Section -->
                    <div class="space-y-6">
                        <div>
                            <label class="flex items-center space-x-4 mb-4">
                                <input type="radio" wire:model.live="operation" value="encrypt" class="text-purple-600">
                                <span class="text-gray-700 dark:text-gray-300">Encrypt</span>
                                <input type="radio" wire:model.live="operation" value="decrypt" class="text-purple-600">
                                <span class="text-gray-700 dark:text-gray-300">Decrypt</span>
                            </label>
                        </div>

                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Keyword
                            </label>
                            <input
                                type="text"
                                wire:model="key"
                                id="key"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter keyword (letters only)..."
                            >
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter text to decrypt..."
                                ></textarea>
                                @error('ciphertext') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <button
                            wire:click="process"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md transition-colors"
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

                    <!-- Information and Example -->
                    <div class="space-y-6">
                        <!-- Algorithm Explanation -->
                        <div class="bg-purple-50 dark:bg-gray-900 p-4 rounded-lg border border-purple-200 dark:border-gray-700">
                            <h3 class="font-semibold text-purple-900 dark:text-purple-300 mb-2">How Vigenère Works:</h3>
                            <ul class="text-sm text-purple-800 dark:text-purple-200 space-y-1">
                                <li>• Each letter is shifted by a different amount based on the keyword</li>
                                <li>• The keyword is repeated to match the plaintext length</li>
                                <li>• Each letter of the key determines the shift for that position</li>
                                <li>• A=0, B=1, C=2... Z=25 shift values</li>
                                <li>• More secure than simple Caesar cipher</li>
                            </ul>
                        </div>

                        <!-- Example -->
                        <div class="bg-blue-50 dark:bg-gray-900 p-4 rounded-lg border border-blue-200 dark:border-gray-700">
                            <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">Example:</h3>
                            <div class="text-sm font-mono text-blue-800 dark:text-blue-200 space-y-1">
                                <div><strong>Plaintext:</strong> HELLO</div>
                                <div><strong>Keyword:</strong> KEY</div>
                                <div><strong>Repeated key:</strong> KEYKE</div>
                                <div class="mt-2">
                                    <div><strong>Shifts:</strong></div>
                                    <div>H + K (shift 10) = R</div>
                                    <div>E + E (shift 4) = I</div>
                                    <div>L + Y (shift 24) = J</div>
                                    <div>L + K (shift 10) = V</div>
                                    <div>O + E (shift 4) = S</div>
                                </div>
                                <div><strong>Ciphertext:</strong> RIJVS</div>
                            </div>
                        </div>

                        <!-- Historical Information -->
                        <div class="bg-green-50 dark:bg-gray-900 p-4 rounded-lg border border-green-200 dark:border-gray-700">
                            <h3 class="font-semibold text-green-900 dark:text-green-300 mb-2">About Vigenère:</h3>
                            <ul class="text-sm text-green-800 dark:text-green-200 space-y-1">
                                <li>• Invented by Giovan Battista Bellaso in 1553</li>
                                <li>• Wrongly attributed to Blaise de Vigenère</li>
                                <li>• Called "Le Chiffre Indéchiffrable" (The Indecipherable Cipher)</li>
                                <li>• Remained unbroken for 300+ years</li>
                                <li>• Broken by Friedrich Kasiski in 1863</li>
                                <li>• Still used in some simple applications today</li>
                            </ul>
                        </div>

                        @if($key)
                        <div class="bg-yellow-50 dark:bg-gray-900 p-4 rounded-lg border border-yellow-200 dark:border-gray-700">
                            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-2">Key Analysis:</h3>
                            <div class="text-sm text-yellow-800 dark:text-yellow-200 space-y-1">
                                <div><strong>Keyword:</strong> {{ strtoupper($key) }}</div>
                                <div><strong>Length:</strong> {{ strlen(preg_replace('/[^A-Za-z]/', '', $key)) }} characters</div>
                                <div><strong>Shifts:</strong> 
                                    @php
                                        $cleanKey = strtoupper(preg_replace('/[^A-Za-z]/', '', $key));
                                        $shifts = [];
                                        for ($i = 0; $i < strlen($cleanKey); $i++) {
                                            $shifts[] = ord($cleanKey[$i]) - ord('A');
                                        }
                                        echo implode(', ', $shifts);
                                    @endphp
                                </div>
                            </div>
                        </div>
                        @endif
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