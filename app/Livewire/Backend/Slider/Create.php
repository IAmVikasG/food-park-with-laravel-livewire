<?php

namespace App\Livewire\Backend\Slider;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Slider;


class Create extends Component
{
    use WithFileUploads;


    public $sliderId; // For edit mode
    public $slider; // To store slider instance
    public $offer;
    public $title;
    public $subtitle;
    public $description;
    public $btn_link;
    public $order = 0;
    public $is_active = true;
    public $image; // For uploading media
    public $existingImage; // To store existing image info

    protected $rules = [
        'offer' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'subtitle' => 'required|string|max:255',
        'description' => 'required|string',
        'btn_link' => 'required|url',
        'order' => 'integer|min:0',
        'is_active' => 'boolean',
        'image' => 'required|image|max:2048'
    ];

    public function mount($sliderId = null)
    {
        if ($sliderId) {
            $this->sliderId = $sliderId;
            $this->slider = Slider::findOrFail($sliderId);
            $this->fill($this->slider->toArray());

            // Store existing image info
            if ($this->slider->hasMedia('slider_images')) {
                $this->existingImage = $this->slider->getFirstMedia('slider_images');
            }
        }
    }

    public function save()
    {
        if ($this->sliderId) {
            // Modify image validation rule for update
            $this->rules['image'] = 'nullable|image|max:2048';
            $this->validate();
            // Update existing slider
            $this->slider->update([
                'offer' => $this->offer,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'description' => $this->description,
                'btn_link' => $this->btn_link,
                'order' => $this->order,
                'is_active' => $this->is_active,
                'updated_by' => Auth::id(),
            ]);

            if ($this->image) {
                // Delete existing image if any
                $this->slider->clearMediaCollection('slider_images');
                // Upload new image
                $this->slider->addMedia($this->image->getRealPath())
                    ->toMediaCollection('slider_images');
            }

            $message = 'Slider updated successfully';
        } else {
            $this->validate();
            // Create new slider
            $slider = Slider::create([
                'offer' => $this->offer,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'description' => $this->description,
                'btn_link' => $this->btn_link,
                'order' => $this->order,
                'is_active' => $this->is_active,
                'created_by' => Auth::id(),
            ]);

            if ($this->image) {
                $slider->addMedia($this->image->getRealPath())
                    ->toMediaCollection('slider_images');
            }

            $message = 'Slider created successfully';
        }

        $this->dispatch('showSuccessMessage', message: $message);

        if (!$this->sliderId) {
            $this->reset(); // Only reset form on create
        }
    }

    public function deleteImage()
    {
        if ($this->sliderId && $this->slider->hasMedia('slider_images')) {
            $this->slider->clearMediaCollection('slider_images');
            $this->existingImage = null;
            $this->dispatch('showSuccessMessage', message: 'Image deleted successfully');
        }
    }


    public function render()
    {
        return view('livewire.backend.slider.create', [
                    'isEditMode' => (bool) $this->sliderId
                ])
                ->extends('layouts.admin')
                ->section('content');
    }
}
