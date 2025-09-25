<?php

namespace App\Livewire\Substitution;

use Livewire\Component;

class OneTimePad extends Component
{
    public $plaintext = '';
    public $ciphertext = '';
    public $key = '';
    public $operation = 'encrypt';
    public $result = '';

    protected $rules = [
        'key' => 'required|string',
        'plaintext' => 'required_if:operation,encrypt',
        'ciphertext' => 'required_if:operation,decrypt',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function generateRandomKey()
    {
        $text = $this->operation === 'encrypt' ? $this->plaintext : $this->ciphertext;
        $cleanText = preg_replace('/[^A-Za-z]/', '', $text);
        $length = strlen($cleanText);
        
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= chr(rand(0, 25) + ord('A'));
        }
        
        $this->key = $key;
    }

    private function processText($text, $encrypt = true)
    {
        $key = strtoupper(preg_replace('/[^A-Z]/', '', $this->key));
        $text = strtoupper(preg_replace('/[^A-Z]/', '', $text));
        
        if (strlen($key) < strlen($text)) {
            $this->addError('key', 'Key must be at least as long as the text (excluding spaces and punctuation).');
            return '';
        }
        
        $result = '';
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) {
                $textNum = ord($char) - ord('A');
                $keyNum = ord($key[$i]) - ord('A');
                
                if ($encrypt) {
                    $resultNum = ($textNum + $keyNum) % 26;
                } else {
                    $resultNum = ($textNum - $keyNum + 26) % 26;
                }
                
                $result .= chr($resultNum + ord('A'));
            }
        }
        
        return $result;
    }

    public function encrypt()
    {
        $this->validate(['plaintext' => 'required|string', 'key' => 'required|string']);
        $this->result = $this->processText($this->plaintext, true);
    }

    public function decrypt()
    {
        $this->validate(['ciphertext' => 'required|string', 'key' => 'required|string']);
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
        return view('livewire.substitution.one-time-pad')->layout('layouts.app');
    }
}