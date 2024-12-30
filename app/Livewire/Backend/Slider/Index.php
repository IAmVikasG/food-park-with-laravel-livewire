<?php

namespace App\Livewire\Backend\Slider;

use App\Models\Slider;
use Livewire\Component;

class Index extends Component
{
    public function delete($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        $this->dispatch('showSuccessMessage', message: 'Slider deleted successfully');
        return $this->redirectRoute('admin.sliders.list', navigate: true);
    }

    public function render()
    {
        return view('livewire.backend.slider.index')
                ->extends('layouts.admin')
                ->section('content');
    }
}
