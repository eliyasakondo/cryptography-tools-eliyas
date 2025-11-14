<?php

namespace App\Livewire\Substitution;

use Livewire\Component;

class MonoalphabeticCipher extends Component
{
    public $plaintext = '';
    public $ciphertext = '';
    public $key = '';
    public $operation = 'encrypt';
    public $result = '';

    protected $rules = [
        'key' => 'required|string|size:26',
        'plaintext' => 'required_if:operation,encrypt',
        'ciphertext' => 'required_if:operation,decrypt',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function generateRandomKey()
    {
        $alphabet = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        shuffle($alphabet);
        $this->key = implode('', $alphabet);
    }

    public function encrypt()
    {
        $this->validate(['plaintext' => 'required|string', 'key' => 'required|string|size:26']);
        
        $plainAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cipherAlphabet = strtoupper($this->key);
        
        // Check if key has all 26 unique letters
        if (count(array_unique(str_split($cipherAlphabet))) !== 26) {
            $this->addError('key', 'Key must contain all 26 unique letters.');
            return;
        }
        
        $text = strtoupper($this->plaintext);
        $result = '';
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) {
                $index = strpos($plainAlphabet, $char);
                $result .= $cipherAlphabet[$index];
            } else {
                $result .= $char;
            }
        }
        
        $this->result = $result;
    }

    public function decrypt()
    {
        $this->validate(['ciphertext' => 'required|string', 'key' => 'required|string|size:26']);
        
        $plainAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cipherAlphabet = strtoupper($this->key);
        
        // Check if key has all 26 unique letters
        if (count(array_unique(str_split($cipherAlphabet))) !== 26) {
            $this->addError('key', 'Key must contain all 26 unique letters.');
            return;
        }
        
        $text = strtoupper($this->ciphertext);
        $result = '';
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) {
                $index = strpos($cipherAlphabet, $char);
                $result .= $plainAlphabet[$index];
            } else {
                $result .= $char;
            }
        }
        
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
        return view('livewire.substitution.monoalphabetic-cipher')->layout('layouts.app');
    }
}