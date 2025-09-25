<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Hill Cipher
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        A polygraphic substitution cipher using matrix multiplication in modular arithmetic
                    </p>
                </div>

                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Input Section -->
                    <div class="space-y-6">
                        <div>
                            <label class="flex items-center space-x-4 mb-4">
                                <input type="radio" wire:model.live="operation" value="encrypt" class="text-orange-600">
                                <span class="text-gray-700 dark:text-gray-300">Encrypt</span>
                                <input type="radio" wire:model.live="operation" value="decrypt" class="text-orange-600">
                                <span class="text-gray-700 dark:text-gray-300">Decrypt</span>
                            </label>
                        </div>

                        <div>
                            <label for="keySize" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Matrix Size
                            </label>
                            <select
                                wire:model.live="keySize"
                                id="keySize"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="2">2×2 Matrix</option>
                                <option value="3">3×3 Matrix</option>
                            </select>
                        </div>

                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Key Matrix (comma-separated values)
                            </label>
                            <input
                                type="text"
                                wire:model.live="key"
                                id="key"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white font-mono"
                                placeholder="{{ $keySize === 2 ? '3,2,5,7' : '1,2,3,4,5,6,7,8,9' }}"
                            >
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Enter {{ $keySize * $keySize }} numbers for {{ $keySize }}×{{ $keySize }} matrix
                            </div>
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter text to decrypt..."
                                ></textarea>
                                @error('ciphertext') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <button
                            wire:click="process"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-md transition-colors"
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

                    <!-- Matrix Display -->
                    <div class="space-y-6">
                        @if(!empty($keyMatrix))
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Key Matrix</h3>
                                <div class="inline-block border border-gray-300 dark:border-gray-600 rounded p-2">
                                    @foreach($keyMatrix as $row)
                                        <div class="flex">
                                            @foreach($row as $cell)
                                                <div class="w-12 h-12 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-sm font-mono bg-orange-50 dark:bg-gray-700 m-1">
                                                    {{ $cell }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Algorithm Explanation -->
                        <div class="bg-orange-50 dark:bg-gray-900 p-4 rounded-lg border border-orange-200 dark:border-gray-700">
                            <h3 class="font-semibold text-orange-900 dark:text-orange-300 mb-2">How Hill Cipher Works:</h3>
                            <ul class="text-sm text-orange-800 dark:text-orange-200 space-y-1">
                                <li>• Groups plaintext into blocks (size = matrix dimension)</li>
                                <li>• Converts letters to numbers (A=0, B=1, ..., Z=25)</li>
                                <li>• Multiplies each block by the key matrix</li>
                                <li>• Takes result modulo 26</li>
                                <li>• Converts numbers back to letters</li>
                            </ul>
                        </div>

                        <!-- Matrix Requirements -->
                        <div class="bg-red-50 dark:bg-gray-900 p-4 rounded-lg border border-red-200 dark:border-gray-700">
                            <h3 class="font-semibold text-red-900 dark:text-red-300 mb-2">Matrix Requirements:</h3>
                            <ul class="text-sm text-red-800 dark:text-red-200 space-y-1">
                                <li>• Matrix must be invertible modulo 26</li>
                                <li>• Determinant must be coprime to 26</li>
                                <li>• Det ≠ 0, 2, 13 (mod 26) for 2×2 matrices</li>
                                <li>• Decryption only works for 2×2 matrices in this demo</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Information Section -->
                    <div class="space-y-6">
                        <!-- Example -->
                        <div class="bg-blue-50 dark:bg-gray-900 p-4 rounded-lg border border-blue-200 dark:border-gray-700">
                            <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">2×2 Example:</h3>
                            <div class="text-sm font-mono text-blue-800 dark:text-blue-200 space-y-2">
                                <div><strong>Key Matrix:</strong></div>
                                <div class="ml-2">
                                    [3 2]<br>
                                    [5 7]
                                </div>
                                <div><strong>Plaintext:</strong> HE</div>
                                <div><strong>Numbers:</strong> [7, 4]</div>
                                <div><strong>Calculation:</strong></div>
                                <div class="ml-2">
                                    [3 2] × [7] = [29] ≡ [3] (mod 26)<br>
                                    [5 7] × [4] = [63] ≡ [11]
                                </div>
                                <div><strong>Result:</strong> DL</div>
                            </div>
                        </div>

                        <!-- Historical Information -->
                        <div class="bg-green-50 dark:bg-gray-900 p-4 rounded-lg border border-green-200 dark:border-gray-700">
                            <h3 class="font-semibold text-green-900 dark:text-green-300 mb-2">About Hill Cipher:</h3>
                            <ul class="text-sm text-green-800 dark:text-green-200 space-y-1">
                                <li>• Invented by Lester S. Hill in 1929</li>
                                <li>• First polygraphic cipher using linear algebra</li>
                                <li>• Resistant to frequency analysis</li>
                                <li>• Vulnerable to known plaintext attacks</li>
                                <li>• Foundation for modern block ciphers</li>
                            </ul>
                        </div>

                        <!-- Security Notes -->
                        <div class="bg-purple-50 dark:bg-gray-900 p-4 rounded-lg border border-purple-200 dark:border-gray-700">
                            <h3 class="font-semibold text-purple-900 dark:text-purple-300 mb-2">Security Analysis:</h3>
                            <ul class="text-sm text-purple-800 dark:text-purple-200 space-y-1">
                                <li>• Larger matrices provide better security</li>
                                <li>• Still preserves some structural patterns</li>
                                <li>• Can be broken with sufficient known plaintext</li>
                                <li>• More secure than simple substitution ciphers</li>
                                <li>• Academic interest rather than practical use</li>
                            </ul>
                        </div>

                        <!-- Mathematical Note -->
                        <div class="bg-yellow-50 dark:bg-gray-900 p-4 rounded-lg border border-yellow-200 dark:border-gray-700">
                            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-2">Mathematical Foundation:</h3>
                            <ul class="text-sm text-yellow-800 dark:text-yellow-200 space-y-1">
                                <li>• Based on linear algebra over finite fields</li>
                                <li>• Uses modular arithmetic (mod 26)</li>
                                <li>• Encryption: C = KP (mod 26)</li>
                                <li>• Decryption: P = K⁻¹C (mod 26)</li>
                                <li>• Requires matrix inversion in Z₂₆</li>
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