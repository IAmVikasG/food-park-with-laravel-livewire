<?php

use App\Models\User;
use App\Models\Slider;
use Livewire\Livewire;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\actingAs;
use App\Livewire\Backend\Slider\Index;

pest()->group('slider');

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
});


it('renders_slider_list_page_successfully', function () {
    Livewire::test(Index::class)->assertStatus(200);
});


it('only_admins_can_access_slider_list', function () {
    actingAs($this->admin);
    get(route('admin.sliders.list'))
        ->assertSeeLivewire(Index::class);
});


it('unauthenticated_users_are_redirected', function () {
    get(route('admin.sliders.list'))
        ->assertRedirect();
});


it('regular_users_cannot_access_slider_list', function () {
    actingAs($this->user);
    get(route('admin.sliders.list'))
        ->assertRedirect();
});

it('slider_data_is_displayed_in_datatable', function () {
    actingAs($this->admin);
    $slider = Slider::factory()->create([
        'title' => 'Test Slider',
        'subtitle' => 'Test Subtitle',
        'is_active' => 1
    ]);

    $response = post(route('admin.sliders.data'), [
        '_token' => csrf_token(),
        'draw' => 1,
        'start' => 0,
        'length' => 10,
        'search' => ['value' => ''],
        'order' => [
            [
                'column' => 0,
                'dir' => 'asc'
            ]
        ],
        'columns' => [
            [
                'data' => 'id',
                'name' => 'id',
                'searchable' => true,
                'orderable' => true,
                'search' => ['value' => '']
            ],
            [
                'data' => 'title',
                'name' => 'title',
                'searchable' => true,
                'orderable' => true,
                'search' => ['value' => '']
            ],
            [
                'data' => 'subtitle',
                'name' => 'subtitle',
                'searchable' => true,
                'orderable' => true,
                'search' => ['value' => '']
            ],
            [
                'data' => 'is_active',
                'name' => 'status',
                'searchable' => true,
                'orderable' => true,
                'search' => ['value' => '']
            ],
            [
                'data' => 'actions',
                'name' => 'actions',
                'searchable' => false,
                'orderable' => false,
                'search' => ['value' => '']
            ]
        ]
    ]);

    expect($response->status())->toBe(200);

    $responseData = json_decode($response->getContent(), true);

    expect($responseData)
        ->toHaveKey('recordsTotal', 1)
        ->toHaveKey('recordsFiltered', 1);

    expect($responseData['data'][0])
        ->toHaveKey('id', $slider->id)
        ->toHaveKey('title', $slider->title)
        ->toHaveKey('subtitle', $slider->subtitle);

    $this->assertDatabaseHas('sliders', [
        'id' => $slider->id,
        'title' => 'Test Slider',
        'subtitle' => 'Test Subtitle',
        'is_active' => 1
    ]);
});
