<?php

namespace App\Livewire\Backend\Category;

use App\Models\Category;
use Livewire\Component;

class Index extends Component
{
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        $this->dispatch('showSuccessMessage', message: 'Category deleted successfully');
        return $this->redirectRoute('admin.categories.list', navigate: true);
    }

    public function render()
    {
        return view('livewire.backend.category.index')
                ->extends('layouts.admin')
                ->section('content');;
    }
}
