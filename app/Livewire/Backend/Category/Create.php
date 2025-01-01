<?php

namespace App\Livewire\Backend\Category;

use Livewire\Component;
use App\Models\Category;
use App\Enums\CategoryType;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\Enum;

class Create extends Component
{
    use WithFileUploads;

    public ?Category $category = null;
    public ?string $name = null;
    public ?string $slug = null;
    public ?string $description = null;
    public $type = null;
    public ?int $parentId = null;
    public ?string $metaTitle = null;
    public ?string $metaDescription = null;
    public int $order = 0;
    public bool $is_active = true;
    public $image;
    public $existingImage;
    public ?string $olderType = null;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug' . ($this->category ? ',' . $this->category->id : ''),
            'description' => 'nullable|string',
            'type' => ['required', new Enum(CategoryType::class)],
            'parentId' => 'nullable|exists:categories,id',
            'metaTitle' => 'nullable|string|max:200',
            'metaDescription' => 'nullable|string',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ];

        return $rules;
    }

    public function mount(?int $categoryId = null)
    {
        if ($categoryId) {
            $this->category = Category::findOrFail($categoryId);
            $this->fillCategoryData();
        }
    }

    private function fillCategoryData(): void
    {
        $this->fill($this->category->only([
            'name',
            'slug',
            'type',
            'description',
            'meta_title',
            'meta_description',
            'is_active',
        ]));
        $this->parentId = $this->category->parent_id;
        $this->order = $this->category->sort_order;

        if ($this->category->hasMedia('category_images')) {
            $this->existingImage = $this->category->getFirstMedia('category_images');
        }
    }

    public function save()
    {
        $this->validate();

        $categoryData = [
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'description' => $this->description,
            'type' => $this->type,
            'parent_id' => $this->parentId,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'sort_order' => $this->order,
            'is_active' => $this->is_active,
        ];

        if ($this->category) {
            $this->updateCategory($categoryData);
        } else {
            $this->createCategory($categoryData);
        }
    }

    private function updateCategory(array $categoryData): void
    {
        $this->category->update($categoryData);
        $this->handleImageUpdate();
        $this->dispatch('showSuccessMessage', message: 'Category updated successfully');
    }

    private function createCategory(array $categoryData): void
    {
        $category = Category::create($categoryData);

        if ($this->image) {
            $category->addMedia($this->image->getRealPath())
                ->toMediaCollection('category_images');
        }

        $this->dispatch('showSuccessMessage', message: 'Category created successfully');
        $this->reset();
    }

    private function handleImageUpdate(): void
    {
        if ($this->image) {
            $this->category->clearMediaCollection('category_images');
            $this->category->addMedia($this->image->getRealPath())
                ->toMediaCollection('category_images');
        }
    }

    public function deleteImage()
    {
        if ($this->category?->hasMedia('category_images')) {
            $this->category->clearMediaCollection('category_images');
            $this->existingImage = null;
            $this->dispatch('showSuccessMessage', message: 'Image deleted successfully');
        }
    }

    public function render()
    {
        return view('livewire.backend.category.create', [
            'categories' => Category::whereNotNull('parent_id')->get(),
            'categoryTypes' => CategoryType::cases(),
            'isEditMode' => (bool) $this->category
        ])
            ->extends('layouts.admin')
            ->section('content');
    }

}
