<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class SuccessMessage extends Component
{
    public $message = null;

    #[On('showSuccessMessage')]
    public function showSessionSuccessMessage($message)
    {
        $this->message = $message;

        $this->dispatch('success-message-disappear', timeout: 3000);
    }

    public function render()
    {
        return view('livewire.success-message');
    }
}
