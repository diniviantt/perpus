<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterForm extends Component
{
    use WithFileUploads;


    #[Validate(['required', 'string', 'max:255'])]
    public $name = '';

    #[Validate(['required', 'digits:16', 'unique:users,nik'])]
    public $nik = '';

    #[Validate(['required', 'string', 'lowercase', 'email', 'indisposable', 'max:255', 'unique:users,email'])]
    public $email = '';

    #[Validate(['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'])]
    public $ktp;

    #[Validate(['required', 'string', 'max:255'])]
    public $alamat = '';

    #[Validate(['required', 'digits_between:10,15', 'unique:users,data'])]
    public $no_telp = '';

    #[Validate(['required', 'string', 'min:8'])]
    public $password = '';

    #[Validate(['required', 'same:password'])]
    public $password_confirmation = '';

    public function render()
    {
        return view('livewire.auth.register-form');
    }
}
