<?php

use App\Livewire\CryptographyHome;
use App\Livewire\About;
use App\Livewire\Substitution\CaesarCipher;
use App\Livewire\Substitution\MonoalphabeticCipher;
use App\Livewire\Substitution\PlayfairCipher;
use App\Livewire\Substitution\HillCipher;
use App\Livewire\Substitution\VigenereCipher;
use App\Livewire\Substitution\OneTimePad;
use App\Livewire\Transposition\RailFenceCipher;
use App\Livewire\Transposition\RowColumnTransposition;
use Illuminate\Support\Facades\Route;

// Main cryptography home page
Route::get('/', CryptographyHome::class)->name('home');

// Substitution Ciphers
Route::get('/caesar-cipher', CaesarCipher::class)->name('caesar');
Route::get('/monoalphabetic-cipher', MonoalphabeticCipher::class)->name('monoalphabetic');
Route::get('/playfair-cipher', PlayfairCipher::class)->name('playfair');
Route::get('/hill-cipher', HillCipher::class)->name('hill');
Route::get('/vigenere-cipher', VigenereCipher::class)->name('vigenere');
Route::get('/one-time-pad', OneTimePad::class)->name('one-time-pad');

// Transposition Ciphers
Route::get('/rail-fence-cipher', RailFenceCipher::class)->name('rail-fence');
Route::get('/row-column-transposition', RowColumnTransposition::class)->name('row-column');

// About page
Route::get('/about', About::class)->name('about');