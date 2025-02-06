<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Validate;
use Livewire\Component;

class ResetPasswordForm extends Component
{
    #[Validate(['required', 'string', 'min:8'])]
    public $password = '';

    #[Validate(['required', 'same:password'])]
    public $password_confirmation = '';

    public function render()
    {
        return view('livewire.auth.reset-password-form');
    }
}
