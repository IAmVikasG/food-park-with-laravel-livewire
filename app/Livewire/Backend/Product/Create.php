<?php

namespace App\Livewire\Backend\Product;

use Livewire\Component;

class Create extends Component
{
    public function render()
    {
        return view('livewire.backend.product.create')
        ->extends('layouts.admin')
        ->section('content');;
    }
}
