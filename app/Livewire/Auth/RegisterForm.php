<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterForm extends Component
{
    #[Validate(['required', 'string', 'max:255'])]
    public $name = '';

    #[Validate(['required', 'string', 'lowercase', 'email', 'indisposable', 'max:255', 'unique:users'])]
    public $email = '';

    #[Validate(['required', 'string', 'min:8'])]
    public $password = '';

    #[Validate(['required', 'same:password'])]
    public $password_confirmation = '';

    public function render()
    {
        return view('livewire.auth.register-form');
    }
}
