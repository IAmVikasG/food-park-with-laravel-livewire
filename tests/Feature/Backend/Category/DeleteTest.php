<?php

use App\Models\User;
use App\Models\Category;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use App\Livewire\Backend\Category\Index;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

pest()->group('category');

describe('category_form_component', function () {
    beforeEach(function () {
        Storage::fake('public');

        $this->admin = User::factory()->admin()->create();
        actingAs($this->admin);
    });

    describe('delete_category', function () {
        it('can_delete_category', function () {
            $category = Category::factory()->create();

            Livewire::test(Index::class)
                ->call('delete', $category->id)
                ->assertDispatched('showSuccessMessage', message: 'Category deleted successfully');

            $this->assertDatabaseMissing('categories', [
                'id' => $category->id,
            ]);

            expect(Category::find($category->id))->toBeNull();
        });

        it('shows_error_message_when_deletion_fails', function () {
            $this->expectException(ModelNotFoundException::class);

            Livewire::test(Index::class)
                ->call('delete', 9999);
        });
    });
});
