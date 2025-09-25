<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Row Column Transposition Cipher
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        Arrange plaintext in a grid and read columns in a specific order determined by a keyword
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Input Section -->
                    <div class="space-y-6">
                        <div>
                            <label class="flex items-center space-x-4 mb-4">
                                <input type="radio" wire:model.live="operation" value="encrypt" class="text-teal-600">
                                <span class="text-gray-700 dark:text-gray-300">Encrypt</span>
                                <input type="radio" wire:model.live="operation" value="decrypt" class="text-teal-600">
                                <span class="text-gray-700 dark:text-gray-300">Decrypt</span>
                            </label>
                        </div>

                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Keyword (for column ordering)
                            </label>
                            <input
                                type="text"
                                wire:model.live="key"
                                id="key"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter keyword..."
                            >
                            @error('key') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        @if($key && !empty($keyOrder))
                            <div class="bg-teal-50 dark:bg-gray-900 p-3 rounded border border-teal-200 dark:border-gray-700">
                                <div class="text-sm">
                                    <div><strong>Keyword:</strong> {{ strtoupper($key) }}</div>
                                    <div><strong>Column Order:</strong> {{ implode(', ', $keyOrder) }}</div>
                                </div>
                            </div>
                        @endif

                        @if($operation === 'encrypt')
                            <div>
                                <label for="plaintext" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Plaintext
                                </label>
                                <textarea
                                    wire:model="plaintext"
                                    id="plaintext"
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white"
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter text to decrypt..."
                                ></textarea>
                                @error('ciphertext') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <button
                            wire:click="process"
                            class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md transition-colors"
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

                    <!-- Information and Examples -->
                    <div class="space-y-6">
                        <!-- Algorithm Explanation -->
                        <div class="bg-teal-50 dark:bg-gray-900 p-4 rounded-lg border border-teal-200 dark:border-gray-700">
                            <h3 class="font-semibold text-teal-900 dark:text-teal-300 mb-2">How Row Column Transposition Works:</h3>
                            <ol class="text-sm text-teal-800 dark:text-teal-200 space-y-1">
                                <li>1. Write plaintext in rows using keyword length as width</li>
                                <li>2. Sort keyword letters alphabetically to get column order</li>
                                <li>3. Read columns in the sorted order</li>
                                <li>4. Concatenate column contents for ciphertext</li>
                                <li>5. Pad incomplete rows with 'X' if necessary</li>
                            </ol>
                        </div>

                        <!-- Visual Example -->
                        <div class="bg-blue-50 dark:bg-gray-900 p-4 rounded-lg border border-blue-200 dark:border-gray-700">
                            <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">Example with keyword "CIPHER":</h3>
                            <div class="text-sm font-mono text-blue-800 dark:text-blue-200 space-y-2">
                                <div><strong>Plaintext:</strong> "HELLO WORLD EXAMPLE"</div>
                                <div><strong>Keyword:</strong> CIPHER</div>
                                <div class="mt-2">
                                    <div><strong>Step 1 - Arrange in grid:</strong></div>
                                    <div class="mt-1 space-y-1">
                                        <div>C I P H E R</div>
                                        <div>H E L L O W</div>
                                        <div>O R L D E X</div>
                                        <div>A M P L E X</div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div><strong>Step 2 - Sort keyword (C=1, E=2, H=3, I=4, P=5, R=6):</strong></div>
                                </div>
                                <div class="mt-2">
                                    <div><strong>Step 3 - Read columns in order 1,2,3,4,5,6:</strong></div>
                                    <div>Col 1(C): HOOA</div>
                                    <div>Col 2(E): ERMA</div>
                                    <div>Col 3(H): LLDP</div>
                                    <div>Col 4(I): LEDL</div>
                                    <div>Col 5(P): OEEE</div>
                                    <div>Col 6(R): WXXX</div>
                                </div>
                                <div><strong>Ciphertext:</strong> HOOAERMALLDPLEDLOEEEXXXX</div>
                            </div>
                        </div>

                        <!-- Historical Information -->
                        <div class="bg-green-50 dark:bg-gray-900 p-4 rounded-lg border border-green-200 dark:border-gray-700">
                            <h3 class="font-semibold text-green-900 dark:text-green-300 mb-2">About Row Column Transposition:</h3>
                            <ul class="text-sm text-green-800 dark:text-green-200 space-y-1">
                                <li>• Also known as "Columnar Transposition"</li>
                                <li>• Used during both World Wars</li>
                                <li>• More secure than simple Rail Fence</li>
                                <li>• Can be done with pen and paper</li>
                                <li>• Often combined with substitution ciphers</li>
                            </ul>
                        </div>

                        <!-- Security Analysis -->
                        <div class="bg-yellow-50 dark:bg-gray-900 p-4 rounded-lg border border-yellow-200 dark:border-gray-700">
                            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-2">Security Features:</h3>
                            <ul class="text-sm text-yellow-800 dark:text-yellow-200 space-y-1">
                                <li>• Preserves letter frequencies (still vulnerable to analysis)</li>
                                <li>• Key length affects security level</li>
                                <li>• Longer keywords provide better scrambling</li>
                                <li>• Can be attacked with anagramming techniques</li>
                                <li>• Multiple rounds increase security</li>
                            </ul>
                        </div>

                        <!-- Variations -->
                        <div class="bg-purple-50 dark:bg-gray-900 p-4 rounded-lg border border-purple-200 dark:border-gray-700">
                            <h3 class="font-semibold text-purple-900 dark:text-purple-300 mb-2">Common Variations:</h3>
                            <ul class="text-sm text-purple-800 dark:text-purple-200 space-y-1">
                                <li>• <strong>Irregular:</strong> Variable column heights</li>
                                <li>• <strong>Double Transposition:</strong> Apply twice with different keys</li>
                                <li>• <strong>Disrupted:</strong> Irregular filling of the grid</li>
                                <li>• <strong>Grille:</strong> Use a template to guide placement</li>
                            </ul>
                        </div>

                        <!-- Key Requirements -->
                        <div class="bg-red-50 dark:bg-gray-900 p-4 rounded-lg border border-red-200 dark:border-gray-700">
                            <h3 class="font-semibold text-red-900 dark:text-red-300 mb-2">Key Guidelines:</h3>
                            <ul class="text-sm text-red-800 dark:text-red-200 space-y-1">
                                <li>• Longer keywords provide better security</li>
                                <li>• Avoid repeating letters in keyword</li>
                                <li>• Random letter arrangement is stronger</li>
                                <li>• Key should be memorable but not obvious</li>
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