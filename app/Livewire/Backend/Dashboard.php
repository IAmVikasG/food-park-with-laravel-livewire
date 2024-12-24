<?php

namespace App\Livewire\Backend;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.backend.dashboard')
            ->extends('layouts.admin')
            ->section('content');
    }
}
