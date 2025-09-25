<?php

use App\Livewire\CryptographyHome;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Substitution\CaesarCipher;
use App\Livewire\Substitution\MonoalphabeticCipher;
use App\Livewire\Substitution\PlayfairCipher;
use App\Livewire\Substitution\HillCipher;
use App\Livewire\Substitution\VigenereCipher;
use App\Livewire\Substitution\OneTimePad;
use App\Livewire\Transposition\RailFenceCipher;
use App\Livewire\Transposition\RowColumnTransposition;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

// Main cryptography home page
Route::get('/', CryptographyHome::class)->name('home');

// Substitution Ciphers
Route::get('/caesar-cipher', CaesarCipher::class)->name('caesar.cipher');
Route::get('/monoalphabetic-cipher', MonoalphabeticCipher::class)->name('monoalphabetic.cipher');
Route::get('/playfair-cipher', PlayfairCipher::class)->name('playfair.cipher');
Route::get('/hill-cipher', HillCipher::class)->name('hill.cipher');
Route::get('/vigenere-cipher', VigenereCipher::class)->name('vigenere.cipher');
Route::get('/one-time-pad', OneTimePad::class)->name('one.time.pad');

// Transposition Ciphers
Route::get('/rail-fence-cipher', RailFenceCipher::class)->name('rail.fence.cipher');
Route::get('/row-column-transposition', \App\Livewire\Transposition\RowColumnTransposition::class)->name('row-column');

// About page
Route::get('/about', \App\Livewire\About::class)->name('about');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
