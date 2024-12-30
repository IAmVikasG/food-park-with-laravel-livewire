<?php

namespace App\Livewire\Backend\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
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
        'password' => 'required',
    ];

    public function postLogin()
    {
        $validatedData = $this->validate();

        if (Auth::attempt($validatedData, $this->rememberMe)) {
            return $this->redirectRoute('admin.dashboard', navigate: true);
        }

        $this->addError('email', 'Invalid email or password.');
    }

    public function mount()
    {
        if (Auth::check()) {
            return $this->redirectRoute('admin.dashboard', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.backend.auth.login');
    }
}
