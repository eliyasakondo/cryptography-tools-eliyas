<?php

namespace App\Livewire\Substitution;

use Livewire\Component;

class VigenereCipher extends Component
{
    public $plaintext = '';
    public $ciphertext = '';
    public $key = '';
    public $operation = 'encrypt';
    public $result = '';

    protected $rules = [
        'key' => 'required|string|min:1',
        'plaintext' => 'required_if:operation,encrypt',
        'ciphertext' => 'required_if:operation,decrypt',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    private function processText($text, $encrypt = true)
    {
        $key = strtoupper(preg_replace('/[^A-Z]/', '', $this->key));
        $text = strtoupper(preg_replace('/[^A-Z]/', '', $text));
        
        if (empty($key)) {
            return '';
        }
        
        $result = '';
        $keyIndex = 0;
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) {
                $textNum = ord($char) - ord('A');
                $keyNum = ord($key[$keyIndex % strlen($key)]) - ord('A');
                
                if ($encrypt) {
                    $resultNum = ($textNum + $keyNum) % 26;
                } else {
                    $resultNum = ($textNum - $keyNum + 26) % 26;
                }
                
                $result .= chr($resultNum + ord('A'));
                $keyIndex++;
            }
        }
        
        return $result;
    }

    public function encrypt()
    {
        $this->validate(['plaintext' => 'required|string', 'key' => 'required|string|min:1']);
        $this->result = $this->processText($this->plaintext, true);
    }

    public function decrypt()
    {
        $this->validate(['ciphertext' => 'required|string', 'key' => 'required|string|min:1']);
        $this->result = $this->processText($this->ciphertext, false);
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
        return view('livewire.substitution.vigenere-cipher')->layout('layouts.app');
    }
}