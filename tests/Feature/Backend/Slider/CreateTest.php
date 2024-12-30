<?php

use App\Livewire\Backend\Slider\Create;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

pest()->group('slider');

beforeEach(function () {
    Storage::fake('public');

    $this->admin = User::factory()->admin()->create();
    actingAs($this->admin);
});

describe('slider_form_component', function () {
    beforeEach(function () {
        $this->component = Livewire::test(Create::class);
    });

    it('component_can_be_rendered', function () {
        $this->component
            ->assertStatus(200)
            ->assertViewIs('livewire.backend.slider.create');
    });

    it('all_form_fields_are_present', function () {
        $this->component
            ->assertSee('Create Slider')
            ->assertSeeInOrder([
                'Offer',
                'Title',
                'Subtitle',
                'Description',
                'Button Link',
                'Order',
                'Active',
                'Slider Image'
            ]);
    });

    it('can_create_slider_with_valid_data', function () {
        $image = UploadedFile::fake()->image('slider.jpg');

        $this->component
            ->set('offer', 'Special Offer')
            ->set('title', 'Test Slider')
            ->set('subtitle', 'Test Subtitle')
            ->set('description', 'Test Description')
            ->set('btn_link', 'https://example.com')
            ->set('order', 1)
            ->set('is_active', true)
            ->set('image', $image)
            ->call('save');

        $this->component
            ->assertHasNoErrors()
            ->assertDispatched('showSuccessMessage');

        $this->assertDatabaseHas('sliders', [
            'offer' => 'Special Offer',
            'title' => 'Test Slider',
            'subtitle' => 'Test Subtitle',
            'description' => 'Test Description',
            'btn_link' => 'https://example.com',
            'order' => 1,
            'is_active' => true,
        ]);
        $slider = Slider::latest()->first();
        $mediaItems = $slider->getMedia('slider_images');

        expect($slider->getMedia('slider_images'))
        ->toHaveCount(1)
        ->first()
        ->toHaveKey('file_name', $mediaItems[0]->file_name);

        expect($slider)
        ->getFirstMedia('slider_images')
        ->toBeInstanceOf(\Spatie\MediaLibrary\MediaCollections\Models\Media::class);
    });
});

describe('slider_form_validation', function () {
    it('all_fields_are_validated', function () {
        Livewire::test(Create::class)
            ->set('offer', '')
            ->set('title', '')
            ->set('subtitle', '')
            ->set('description', '')
            ->set('btn_link', 'invalid-url')
            ->set('order', 'not-a-number')
            ->call('save')
            ->assertHasErrors([
                'offer' => 'required',
                'title' => 'required',
                'subtitle' => 'required',
                'description' => 'required',
                'btn_link' => 'url',
                'order' => 'integer',
                'image' => 'required'
            ]);
    });

    it('button_link_must_be_valid_url', function () {
        Livewire::test(Create::class)
            ->set('btn_link', 'invalid-url')
            ->call('save')
            ->assertHasErrors(['btn_link' => 'url']);
    });

    it('order_must_be_numeric', function () {
        Livewire::test(Create::class)
            ->set('order', 'abc')
            ->call('save')
            ->assertHasErrors(['order' => 'integer']);
    });
});

describe('slider_form_interactions', function () {
    it('can_toggle_active_status', function () {
        Livewire::test(Create::class)
            ->set('is_active', true)
            ->assertSet('is_active', true)
            ->set('is_active', false)
            ->assertSet('is_active', false);
    });

    it('shows_success_message_after_creation', function () {
        $image = UploadedFile::fake()->image('slider.jpg');

        Livewire::test(Create::class)
            ->set('offer', 'Test Offer')
            ->set('title', 'Test Title')
            ->set('subtitle', 'Test Subtitle')
            ->set('description', 'Test Description')
            ->set('btn_link', 'https://example.com')
            ->set('order', 1)
            ->set('is_active', true)
            ->set('image', $image)
            ->call('save')
            ->assertDispatched('showSuccessMessage', message: 'Slider created successfully');
    });
});

describe('slider_form_security', function () {
    test('unauthorized_users_cannot_access_form', function () {
        $regularUser = User::factory()->create();

        actingAs($regularUser);

        get(route('admin.sliders.create'))
            ->assertForbidden();
    });

    it('unauthorized_users_cannot_submit_form', function () {
        $regularUser = User::factory()->create();

        actingAs($regularUser);

        Livewire::test(Create::class)
            ->call('save')
            ->assertForbidden();
    });
})->skip("need to be implement for gate and policy");
