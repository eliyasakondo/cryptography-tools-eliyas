<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Playfair Cipher
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        A digraph substitution cipher that encrypts pairs of letters using a 5×5 key square
                    </p>
                </div>

                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Input Section -->
                    <div class="space-y-6">
                        <div>
                            <label class="flex items-center space-x-4 mb-4">
                                <input type="radio" wire:model.live="operation" value="encrypt" class="text-blue-600">
                                <span class="text-gray-700 dark:text-gray-300">Encrypt</span>
                                <input type="radio" wire:model.live="operation" value="decrypt" class="text-blue-600">
                                <span class="text-gray-700 dark:text-gray-300">Decrypt</span>
                            </label>
                        </div>

                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Key Phrase
                            </label>
                            <input
                                type="text"
                                wire:model.live="key"
                                id="key"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter key phrase..."
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
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
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Enter text to decrypt..."
                                ></textarea>
                                @error('ciphertext') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <button
                            wire:click="process"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors"
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

                    <!-- Key Matrix Display -->
                    <div class="space-y-6">
                        @if(!empty($keyMatrix))
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">5×5 Key Square</h3>
                                <div class="inline-block border border-gray-300 dark:border-gray-600 rounded">
                                    @foreach($keyMatrix as $row)
                                        <div class="flex">
                                            @foreach($row as $cell)
                                                <div class="w-8 h-8 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-sm font-mono bg-blue-50 dark:bg-gray-700">
                                                    {{ $cell }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Algorithm Rules -->
                        <div class="bg-blue-50 dark:bg-gray-900 p-4 rounded-lg border border-blue-200 dark:border-gray-700">
                            <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">Playfair Rules:</h3>
                            <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                <li><strong>Same row:</strong> Replace with letter to the right</li>
                                <li><strong>Same column:</strong> Replace with letter below</li>
                                <li><strong>Rectangle:</strong> Replace with letter in same row, opposite corner</li>
                                <li><strong>Duplicate letters:</strong> Insert 'X' between them</li>
                                <li><strong>Odd length:</strong> Add 'X' at the end</li>
                                <li><strong>J becomes I:</strong> J is treated as I in the matrix</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Example and Information -->
                    <div class="space-y-6">
                        <div class="bg-green-50 dark:bg-gray-900 p-4 rounded-lg border border-green-200 dark:border-gray-700">
                            <h3 class="font-semibold text-green-900 dark:text-green-300 mb-2">Example:</h3>
                            <div class="text-sm text-green-800 dark:text-green-200 space-y-2">
                                <div><strong>Key:</strong> "MONARCHY"</div>
                                <div><strong>Plaintext:</strong> "HELLO"</div>
                                <div><strong>Prepared:</strong> "HE LX LO" (pairs)</div>
                                <div><strong>Process:</strong></div>
                                <ul class="ml-4 space-y-1">
                                    <li>• HE → Different rows/cols → Use rectangle rule</li>
                                    <li>• LX → Different rows/cols → Use rectangle rule</li>
                                    <li>• LO → Different rows/cols → Use rectangle rule</li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-yellow-50 dark:bg-gray-900 p-4 rounded-lg border border-yellow-200 dark:border-gray-700">
                            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-2">About Playfair:</h3>
                            <ul class="text-sm text-yellow-800 dark:text-yellow-200 space-y-1">
                                <li>• Invented by Charles Wheatstone in 1854</li>
                                <li>• Named after Lord Playfair who promoted its use</li>
                                <li>• Used by British forces during Boer War and WWI</li>
                                <li>• More secure than simple substitution ciphers</li>
                                <li>• Works on pairs of letters (digraphs)</li>
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