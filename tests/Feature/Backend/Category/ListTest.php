<?php

use App\Models\User;
use App\Models\Category;
use Livewire\Livewire;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\actingAs;
use App\Livewire\Backend\Category\Index;

pest()->group('category');

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
});


it('renders_category_list_page_successfully', function () {
    Livewire::test(Index::class)->assertStatus(200);
});


it('only_admins_can_access_category_list', function () {
    actingAs($this->admin);
    get(route('admin.categories.list'))
        ->assertSeeLivewire(Index::class);
});


it('unauthenticated_users_are_redirected', function () {
    get(route('admin.categories.list'))
        ->assertRedirect();
});


it('regular_users_cannot_access_category_list', function () {
    actingAs($this->user);
    get(route('admin.categories.list'))
        ->assertRedirect();
});

it('category_data_is_displayed_in_datatable', function () {
    actingAs($this->admin);
    $category = Category::factory()->create();

    $response = post(route('admin.categories.data'), [
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
                'data' => 'name',
                'name' => 'name',
                'searchable' => true,
                'orderable' => true,
                'search' => ['value' => '']
            ],
            [
                'data' => 'type',
                'name' => 'type',
                'searchable' => true,
                'orderable' => true,
                'search' => ['value' => '']
            ],
            [
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
        ->toHaveKey('id', $category->id)
        ->toHaveKey('name', $category->name);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => $category->name,
    ]);
});
