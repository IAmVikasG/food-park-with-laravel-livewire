<?php

use App\Livewire\Backend\Category\Create;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use App\Enums\CategoryType;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

pest()->group('category');

beforeEach(function () {
    Storage::fake('public');
    $this->admin = User::factory()->admin()->create();
    $this->parentCategory = Category::factory()->create();
    actingAs($this->admin);
});

describe('category_form_component', function () {
    beforeEach(function () {
        $this->component = Livewire::test(Create::class);
    });

    it('component_can_be_rendered', function () {
        $this->component
            ->assertStatus(200)
            ->assertViewIs('livewire.backend.category.create');
    });

    it('all_form_fields_are_present', function () {
        $this->component
            ->assertSee('Create Category')
            ->assertSeeInOrder([
                'Name',
                'Slug',
                'Type',
                'Parent Category',
                'Description',
                'Sort Order',
                'Active',
                'Category Image',
                'Meta Title',
                'Meta Description',
            ]);
    });

    it('can_create_category_with_valid_data', function () {
        $image = UploadedFile::fake()->image('category.jpg');
        $categoryType = CategoryType::cases()[0];

        $this->component
            ->set('name', 'Test Category')
            ->set('slug', 'test-category')
            ->set('type', $categoryType->value)
            ->set('parentId', $this->parentCategory->id)
            ->set('description', 'Test Description')
            ->set('metaTitle', 'Test Meta Title')
            ->set('metaDescription', 'Test Meta Description')
            ->set('order', 1)
            ->set('is_active', true)
            ->set('image', $image)
            ->call('save');

        $this->component
            ->assertHasNoErrors()
            ->assertDispatched('showSuccessMessage');

        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'type' => $categoryType->value,
            'parent_id' => $this->parentCategory->id,
            'description' => 'Test Description',
            'meta_title' => 'Test Meta Title',
            'meta_description' => 'Test Meta Description',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $category = Category::latest()->first();
        $mediaItems = $category->getMedia('category_images');

        expect($category->getMedia('category_images'))
        ->toHaveCount(1)
        ->first()
        ->toHaveKey('file_name', $mediaItems[0]->file_name);

        expect($category)
        ->getFirstMedia('category_images')
        ->toBeInstanceOf(\Spatie\MediaLibrary\MediaCollections\Models\Media::class);
    });

    it('can_update_existing_category', function () {
        $category = Category::factory()->create();
        $newImage = UploadedFile::fake()->image('new-category.jpg');
        $newType = CategoryType::cases()[1];

        $component = Livewire::test(Create::class, ['categoryId' => $category->id])
            ->set('name', 'Updated Category')
            ->set('slug', 'updated-category')
            ->set('type', $newType->value)
            ->set('description', 'Updated Description')
            ->set('image', $newImage)
            ->call('save');

        $component
            ->assertHasNoErrors()
            ->assertDispatched('showSuccessMessage');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'slug' => 'updated-category',
            'type' => $newType->value,
            'description' => 'Updated Description',
        ]);
    });
});

describe('category_form_validation', function () {
    it('validates_required_fields', function () {
        Livewire::test(Create::class)
            ->set('name', '')
            ->set('slug', '')
            ->set('type', '')
            ->call('save')
            ->assertHasErrors([
                'name' => 'required',
                'slug' => 'required',
                'type' => 'required',
            ]);
    });

    it('validates_unique_slug', function () {
        $existingCategory = Category::factory()->create();

        Livewire::test(Create::class)
            ->set('slug', $existingCategory->slug)
            ->call('save')
            ->assertHasErrors(['slug' => 'unique']);
    });

    it('validates_parent_category_exists', function () {
        Livewire::test(Create::class)
            ->set('parentId', 999)
            ->call('save')
            ->assertHasErrors(['parentId' => 'exists']);
    });

});

describe('category_form_interactions', function () {
    it('can_delete_existing_image', function () {
        $category = Category::factory()->create();
        $category->addMedia(UploadedFile::fake()->image('test.jpg'))
            ->toMediaCollection('category_images');

        $component = Livewire::test(Create::class, ['categoryId' => $category->id])
            ->call('deleteImage');

        $component
            ->assertDispatched('showSuccessMessage')
            ->assertSet('existingImage', null);

        expect($category->fresh()->getMedia('category_images'))->toBeEmpty();
    });
});

describe('category_form_security', function () {
    beforeEach(function () {
        // Create a gate for category management
        Gate::define('manage-categories', function (User $user) {
            return $user->is_admin;
        });
    });

    it('unauthorized_users_cannot_access_form', function () {
        $regularUser = User::factory()->create(['is_admin' => false]);
        actingAs($regularUser);

        get(route('admin.categories.create'))
            ->assertForbidden();
    });

    it('unauthorized_users_cannot_submit_form', function () {
        $regularUser = User::factory()->create(['is_admin' => false]);
        actingAs($regularUser);

        Livewire::test(Create::class)
            ->call('save')
            ->assertForbidden();
    });
})->skip("need to be implement for gate and policy");
