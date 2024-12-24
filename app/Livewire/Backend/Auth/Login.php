<?php

namespace App\Livewire\Backend\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.guest')]
#[Title('Admin | Login')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $rememberMe = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function postLogin()
    {
        $validatedData = $this->validate();

        if (Auth::attempt($validatedData, $this->rememberMe)) {
            return $this->redirectRoute('admin.dashboard');
        }

        $this->addError('email', 'Invalid email or password.');
    }

    public function render()
    {
        return view('livewire.backend.auth.login');
    }
}
