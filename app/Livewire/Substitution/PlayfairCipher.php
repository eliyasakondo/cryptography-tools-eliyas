<?php

namespace App\Livewire\Substitution;

use Livewire\Component;

class PlayfairCipher extends Component
{
    public $plaintext = '';
    public $ciphertext = '';
    public $key = '';
    public $operation = 'encrypt';
    public $result = '';
    public $keyMatrix = [];

    protected $rules = [
        'key' => 'required|string|min:1',
        'plaintext' => 'required_if:operation,encrypt',
        'ciphertext' => 'required_if:operation,decrypt',
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'key') {
            $this->generateKeyMatrix();
        }
        $this->validateOnly($propertyName);
    }

    public function generateKeyMatrix()
    {
        $key = strtoupper(preg_replace('/[^A-Z]/', '', $this->key));
        $key = str_replace('J', 'I', $key); // Replace J with I
        
        // Remove duplicate letters from key
        $keyUnique = '';
        $used = [];
        for ($i = 0; $i < strlen($key); $i++) {
            if (!isset($used[$key[$i]])) {
                $keyUnique .= $key[$i];
                $used[$key[$i]] = true;
            }
        }
        
        // Add remaining letters
        $alphabet = 'ABCDEFGHIKLMNOPQRSTUVWXYZ'; // No J
        for ($i = 0; $i < strlen($alphabet); $i++) {
            if (!isset($used[$alphabet[$i]])) {
                $keyUnique .= $alphabet[$i];
            }
        }
        
        // Create 5x5 matrix
        $this->keyMatrix = [];
        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $this->keyMatrix[$i][$j] = $keyUnique[$i * 5 + $j];
            }
        }
    }

    private function findPosition($char)
    {
        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($this->keyMatrix[$i][$j] === $char) {
                    return [$i, $j];
                }
            }
        }
        return null;
    }

    private function preparePlaintext($text)
    {
        $text = strtoupper(preg_replace('/[^A-Z]/', '', $text));
        $text = str_replace('J', 'I', $text);
        
        $prepared = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $prepared .= $text[$i];
            if ($i < strlen($text) - 1 && $text[$i] === $text[$i + 1]) {
                $prepared .= 'X';
            }
        }
        
        if (strlen($prepared) % 2 !== 0) {
            $prepared .= 'X';
        }
        
        return $prepared;
    }

    public function encrypt()
    {
        $this->validate(['plaintext' => 'required|string', 'key' => 'required|string|min:1']);
        $this->generateKeyMatrix();
        
        $text = $this->preparePlaintext($this->plaintext);
        $result = '';
        
        for ($i = 0; $i < strlen($text); $i += 2) {
            $char1 = $text[$i];
            $char2 = $text[$i + 1];
            
            $pos1 = $this->findPosition($char1);
            $pos2 = $this->findPosition($char2);
            
            if ($pos1[0] === $pos2[0]) { // Same row
                $result .= $this->keyMatrix[$pos1[0]][($pos1[1] + 1) % 5];
                $result .= $this->keyMatrix[$pos2[0]][($pos2[1] + 1) % 5];
            } elseif ($pos1[1] === $pos2[1]) { // Same column
                $result .= $this->keyMatrix[($pos1[0] + 1) % 5][$pos1[1]];
                $result .= $this->keyMatrix[($pos2[0] + 1) % 5][$pos2[1]];
            } else { // Rectangle
                $result .= $this->keyMatrix[$pos1[0]][$pos2[1]];
                $result .= $this->keyMatrix[$pos2[0]][$pos1[1]];
            }
        }
        
        $this->result = $result;
    }

    public function decrypt()
    {
        $this->validate(['ciphertext' => 'required|string', 'key' => 'required|string|min:1']);
        $this->generateKeyMatrix();
        
        $text = strtoupper(preg_replace('/[^A-Z]/', '', $this->ciphertext));
        $text = str_replace('J', 'I', $text);
        $result = '';
        
        for ($i = 0; $i < strlen($text); $i += 2) {
            $char1 = $text[$i];
            $char2 = $text[$i + 1];
            
            $pos1 = $this->findPosition($char1);
            $pos2 = $this->findPosition($char2);
            
            if ($pos1[0] === $pos2[0]) { // Same row
                $result .= $this->keyMatrix[$pos1[0]][($pos1[1] - 1 + 5) % 5];
                $result .= $this->keyMatrix[$pos2[0]][($pos2[1] - 1 + 5) % 5];
            } elseif ($pos1[1] === $pos2[1]) { // Same column
                $result .= $this->keyMatrix[($pos1[0] - 1 + 5) % 5][$pos1[1]];
                $result .= $this->keyMatrix[($pos2[0] - 1 + 5) % 5][$pos2[1]];
            } else { // Rectangle
                $result .= $this->keyMatrix[$pos1[0]][$pos2[1]];
                $result .= $this->keyMatrix[$pos2[0]][$pos1[1]];
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
        return view('livewire.substitution.playfair-cipher')->layout('layouts.app');
    }
}