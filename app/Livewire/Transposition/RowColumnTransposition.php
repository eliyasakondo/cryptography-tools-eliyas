<?php

namespace App\Livewire\Transposition;

use Livewire\Component;

class RowColumnTransposition extends Component
{
    public $plaintext = '';
    public $ciphertext = '';
    public $key = '';
    public $operation = 'encrypt';
    public $result = '';
    public $keyOrder = [];

    protected $rules = [
        'key' => 'required|string|min:1',
        'plaintext' => 'required_if:operation,encrypt',
        'ciphertext' => 'required_if:operation,decrypt',
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'key') {
            $this->calculateKeyOrder();
        }
        $this->validateOnly($propertyName);
    }

    public function calculateKeyOrder()
    {
        $key = strtoupper($this->key);
        $keyChars = str_split($key);
        
        // Create array with positions and characters
        $keyWithPositions = [];
        for ($i = 0; $i < count($keyChars); $i++) {
            $keyWithPositions[] = ['char' => $keyChars[$i], 'original_pos' => $i];
        }
        
        // Sort by character, then by original position for duplicates
        usort($keyWithPositions, function($a, $b) {
            if ($a['char'] === $b['char']) {
                return $a['original_pos'] - $b['original_pos'];
            }
            return strcmp($a['char'], $b['char']);
        });
        
        // Create order array
        $this->keyOrder = array_fill(0, count($keyChars), 0);
        for ($i = 0; $i < count($keyWithPositions); $i++) {
            $originalPos = $keyWithPositions[$i]['original_pos'];
            $this->keyOrder[$originalPos] = $i + 1;
        }
    }

    public function encrypt()
    {
        $this->validate(['plaintext' => 'required|string', 'key' => 'required|string|min:1']);
        $this->calculateKeyOrder();
        
        $text = str_replace(' ', '', strtoupper($this->plaintext));
        $keyLength = strlen($this->key);
        
        // Pad text to fit in complete rows
        while (strlen($text) % $keyLength !== 0) {
            $text .= 'X';
        }
        
        $rows = strlen($text) / $keyLength;
        $matrix = [];
        
        // Fill matrix row by row
        for ($i = 0; $i < $rows; $i++) {
            $matrix[$i] = [];
            for ($j = 0; $j < $keyLength; $j++) {
                $matrix[$i][$j] = $text[$i * $keyLength + $j];
            }
        }
        
        // Read columns in key order
        $result = '';
        for ($order = 1; $order <= $keyLength; $order++) {
            $colIndex = array_search($order, $this->keyOrder);
            for ($row = 0; $row < $rows; $row++) {
                $result .= $matrix[$row][$colIndex];
            }
        }
        
        $this->result = $result;
    }

    public function decrypt()
    {
        $this->validate(['ciphertext' => 'required|string', 'key' => 'required|string|min:1']);
        $this->calculateKeyOrder();
        
        $text = str_replace(' ', '', strtoupper($this->ciphertext));
        $keyLength = strlen($this->key);
        $rows = strlen($text) / $keyLength;
        
        if (strlen($text) % $keyLength !== 0) {
            $this->addError('ciphertext', 'Ciphertext length must be divisible by key length.');
            return;
        }
        
        $matrix = array_fill(0, $rows, array_fill(0, $keyLength, ''));
        
        // Fill matrix column by column in key order
        $index = 0;
        for ($order = 1; $order <= $keyLength; $order++) {
            $colIndex = array_search($order, $this->keyOrder);
            for ($row = 0; $row < $rows; $row++) {
                $matrix[$row][$colIndex] = $text[$index++];
            }
        }
        
        // Read matrix row by row
        $result = '';
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $keyLength; $j++) {
                $result .= $matrix[$i][$j];
            }
        }
        
        $this->result = rtrim($result, 'X'); // Remove padding X's
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
        return view('livewire.transposition.row-column-transposition')->layout('layouts.app');
    }
}