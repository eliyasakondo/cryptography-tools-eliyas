<?php

namespace App\Livewire\Substitution;

use Livewire\Component;

class CaesarCipher extends Component
{
    public $plaintext = '';
    public $ciphertext = '';
    public $shift = 3;
    public $operation = 'encrypt';
    public $result = '';

    protected $rules = [
        'plaintext' => 'required_if:operation,encrypt',
        'ciphertext' => 'required_if:operation,decrypt',
        'shift' => 'required|integer|min:1|max:25',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function encrypt()
    {
        $this->validate(['plaintext' => 'required|string', 'shift' => 'required|integer|min:1|max:25']);
        
        $text = strtoupper($this->plaintext);
        $result = '';
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) {
                $ascii = ord($char) - ord('A');
                $shifted = ($ascii + $this->shift) % 26;
                $result .= chr($shifted + ord('A'));
            } else {
                $result .= $char;
            }
        }
        
        $this->result = $result;
    }

    public function decrypt()
    {
        $this->validate(['ciphertext' => 'required|string', 'shift' => 'required|integer|min:1|max:25']);
        
        $text = strtoupper($this->ciphertext);
        $result = '';
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) {
                $ascii = ord($char) - ord('A');
                $shifted = ($ascii - $this->shift + 26) % 26;
                $result .= chr($shifted + ord('A'));
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
        return view('livewire.substitution.caesar-cipher')->layout('layouts.app');
    }
}