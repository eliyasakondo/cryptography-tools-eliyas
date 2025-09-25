<?php

namespace App\Livewire\Transposition;

use Livewire\Component;

class RailFenceCipher extends Component
{
    public $plaintext = '';
    public $ciphertext = '';
    public $rails = 3;
    public $operation = 'encrypt';
    public $result = '';

    protected $rules = [
        'rails' => 'required|integer|min:2|max:10',
        'plaintext' => 'required_if:operation,encrypt',
        'ciphertext' => 'required_if:operation,decrypt',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function encrypt()
    {
        $this->validate(['plaintext' => 'required|string', 'rails' => 'required|integer|min:2']);
        
        $text = str_replace(' ', '', strtoupper($this->plaintext));
        $fence = array_fill(0, $this->rails, []);
        
        $rail = 0;
        $direction = 1;
        
        for ($i = 0; $i < strlen($text); $i++) {
            $fence[$rail][] = $text[$i];
            
            // Move to next rail
            $rail += $direction;
            
            // Change direction at boundaries
            if ($rail === $this->rails || $rail < 0) {
                $direction *= -1;
                $rail += 2 * $direction;
            }
        }
        
        $result = '';
        foreach ($fence as $row) {
            $result .= implode('', $row);
        }
        
        $this->result = $result;
    }

    public function decrypt()
    {
        $this->validate(['ciphertext' => 'required|string', 'rails' => 'required|integer|min:2']);
        
        $text = str_replace(' ', '', strtoupper($this->ciphertext));
        $length = strlen($text);
        
        // Create fence pattern to know positions
        $fence = array_fill(0, $this->rails, array_fill(0, $length, false));
        
        $rail = 0;
        $direction = 1;
        
        // Mark positions in the fence
        for ($i = 0; $i < $length; $i++) {
            $fence[$rail][$i] = true;
            
            // Move to next rail
            $rail += $direction;
            
            // Change direction at boundaries
            if ($rail === $this->rails || $rail < 0) {
                $direction *= -1;
                $rail += 2 * $direction;
            }
        }
        
        // Fill the fence with characters
        $index = 0;
        for ($r = 0; $r < $this->rails; $r++) {
            for ($c = 0; $c < $length; $c++) {
                if ($fence[$r][$c] && $index < $length) {
                    $fence[$r][$c] = $text[$index++];
                }
            }
        }
        
        // Read the fence in zigzag manner
        $result = '';
        $rail = 0;
        $direction = 1;
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $fence[$rail][$i];
            
            // Move to next rail
            $rail += $direction;
            
            // Change direction at boundaries
            if ($rail === $this->rails || $rail < 0) {
                $direction *= -1;
                $rail += 2 * $direction;
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
        return view('livewire.transposition.rail-fence-cipher')->layout('layouts.app');
    }
}