<?php

use App\Models\User;
use App\Models\Slider;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use App\Livewire\Backend\Slider\Index;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

pest()->group('slider');

describe('slider_form_component', function () {
    beforeEach(function () {
        Storage::fake('public');

        $this->admin = User::factory()->admin()->create();
        actingAs($this->admin);
    });

    describe('delete_slider', function () {
        it('can_delete_slider', function () {
            $slider = Slider::factory()->create();

            Livewire::test(Index::class)
                ->call('delete', $slider->id)
                ->assertDispatched('showSuccessMessage', message: 'Slider deleted successfully');

            $this->assertDatabaseMissing('sliders', [
                'id' => $slider->id,
            ]);

            expect(Slider::find($slider->id))->toBeNull();
        });

        it('shows_error_message_when_deletion_fails', function () {
            $this->expectException(ModelNotFoundException::class);

            Livewire::test(Index::class)
                ->call('delete', 9999);
        });
    });
});
