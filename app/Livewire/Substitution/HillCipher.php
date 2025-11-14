<?php

namespace App\Livewire\Substitution;

use Livewire\Component;

class HillCipher extends Component
{
    public $plaintext = '';
    public $ciphertext = '';
    public $key = '3,2,5,7'; // Default 2x2 matrix
    public $keySize = 2;
    public $operation = 'encrypt';
    public $result = '';
    public $keyMatrix = [];

    protected $rules = [
        'key' => 'required|string',
        'keySize' => 'required|integer|min:2|max:5',
        'plaintext' => 'required_if:operation,encrypt',
        'ciphertext' => 'required_if:operation,decrypt',
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'key' || $propertyName === 'keySize') {
            $this->parseKeyMatrix();
        }
        $this->validateOnly($propertyName);
    }

    public function parseKeyMatrix()
    {
        $keyValues = array_map('trim', explode(',', $this->key));
        $expectedSize = $this->keySize * $this->keySize;
        
        if (count($keyValues) !== $expectedSize) {
            $this->addError('key', "Key must have exactly {$expectedSize} values for a {$this->keySize}x{$this->keySize} matrix.");
            return;
        }
        
        $this->keyMatrix = [];
        for ($i = 0; $i < $this->keySize; $i++) {
            for ($j = 0; $j < $this->keySize; $j++) {
                $this->keyMatrix[$i][$j] = intval($keyValues[$i * $this->keySize + $j]) % 26;
            }
        }
    }

    private function charToNum($char)
    {
        return ord(strtoupper($char)) - ord('A');
    }

    private function numToChar($num)
    {
        return chr(($num % 26) + ord('A'));
    }

    private function multiplyMatrix($text)
    {
        $result = [];
        $textNums = [];
        
        // Convert text to numbers
        for ($i = 0; $i < strlen($text); $i++) {
            if (ctype_alpha($text[$i])) {
                $textNums[] = $this->charToNum($text[$i]);
            }
        }
        
        // Pad with X if needed
        while (count($textNums) % $this->keySize !== 0) {
            $textNums[] = $this->charToNum('X');
        }
        
        // Process in blocks
        for ($block = 0; $block < count($textNums); $block += $this->keySize) {
            for ($i = 0; $i < $this->keySize; $i++) {
                $sum = 0;
                for ($j = 0; $j < $this->keySize; $j++) {
                    $sum += $this->keyMatrix[$i][$j] * $textNums[$block + $j];
                }
                $result[] = $sum % 26;
            }
        }
        
        return $result;
    }

    private function determinant()
    {
        if ($this->keySize === 2) {
            $det = ($this->keyMatrix[0][0] * $this->keyMatrix[1][1] - $this->keyMatrix[0][1] * $this->keyMatrix[1][0]);
            return ($det % 26 + 26) % 26; // Ensure positive result
        }
        // For simplicity, only 2x2 matrices are fully supported for decryption
        return 1;
    }

    private function modInverse($a, $m = 26)
    {
        $a = ($a % $m + $m) % $m; // Ensure positive
        for ($i = 1; $i < $m; $i++) {
            if (($a * $i) % $m === 1) {
                return $i;
            }
        }
        return null;
    }

    private function getInverseMatrix()
    {
        if ($this->keySize !== 2) {
            return null; // Only 2x2 inverse implemented
        }
        
        $det = $this->determinant();
        if ($det === 0) {
            return null;
        }
        
        $detInv = $this->modInverse($det);
        if ($detInv === null) {
            return null;
        }
        
        $inverse = [];
        $inverse[0][0] = (($this->keyMatrix[1][1] * $detInv) % 26 + 26) % 26;
        $inverse[0][1] = ((-$this->keyMatrix[0][1] * $detInv) % 26 + 26) % 26;
        $inverse[1][0] = ((-$this->keyMatrix[1][0] * $detInv) % 26 + 26) % 26;
        $inverse[1][1] = (($this->keyMatrix[0][0] * $detInv) % 26 + 26) % 26;
        
        return $inverse;
    }

    public function encrypt()
    {
        $this->validate(['plaintext' => 'required|string', 'key' => 'required|string']);
        $this->parseKeyMatrix();
        
        if (empty($this->keyMatrix)) {
            return;
        }
        
        $text = strtoupper(preg_replace('/[^A-Z]/', '', $this->plaintext));
        $encrypted = $this->multiplyMatrix($text);
        
        $result = '';
        foreach ($encrypted as $num) {
            $result .= $this->numToChar($num);
        }
        
        $this->result = $result;
    }

    public function decrypt()
    {
        $this->validate(['ciphertext' => 'required|string', 'key' => 'required|string']);
        $this->parseKeyMatrix();
        
        if ($this->keySize !== 2) {
            $this->addError('keySize', 'Decryption only supports 2x2 matrices.');
            return;
        }
        
        $inverseMatrix = $this->getInverseMatrix();
        if ($inverseMatrix === null) {
            $this->addError('key', 'Key matrix is not invertible.');
            return;
        }
        
        // Temporarily replace key matrix with inverse
        $originalMatrix = $this->keyMatrix;
        $this->keyMatrix = $inverseMatrix;
        
        $text = strtoupper(preg_replace('/[^A-Z]/', '', $this->ciphertext));
        $decrypted = $this->multiplyMatrix($text);
        
        $result = '';
        foreach ($decrypted as $num) {
            $result .= $this->numToChar($num);
        }
        
        $this->keyMatrix = $originalMatrix; // Restore original matrix
        $this->result = $result;
    }

    public function process()
    {
        if ($this->operation === 'encrypt') {
            $this->encrypt();
        } else {
            $this->decrypt();
        }
    }

    public function render()
    {
        return view('livewire.substitution.hill-cipher')->layout('layouts.app');
    }
}