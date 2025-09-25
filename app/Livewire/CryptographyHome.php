<?php

namespace App\Livewire;

use Livewire\Component;

class CryptographyHome extends Component
{
    public function render()
    {
        return view('livewire.cryptography-home')->layout('layouts.app');
    }
}