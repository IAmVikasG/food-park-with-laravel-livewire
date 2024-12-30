<?php

namespace App\Actions\Slider;

use App\Models\Slider;
use App\Services\DataTableService;
use Lorisleiva\Actions\Concerns\AsAction;

class SliderTable
{
    use AsAction;

    public function __construct(
        protected DataTableService $dataTableService
    ) {}

    public function handle()
    {
        $query = Slider::query();
        $columns = ['id', 'title', 'subtitle', 'is_active'];

        $result = $this->dataTableService->handle($query, $columns);

        $result['data'] = $result['data']->map(function ($slider) {
            return [
                'id' => $slider->id,
                'title' => $slider->title,
                'subtitle' => $slider->subtitle,
                'status' => $slider->is_active
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">Inactive</span>',
                'created_at' => $slider->created_at->format('Y-m-d'),
                'actions' => '
                    <a href="' . route('admin.sliders.edit', $slider->id) . '" wire:navigate class="btn btn-sm btn-primary">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger" wire:click="delete('.$slider->id.')"
                    wire:confirm="Are you sure you want to delete?">Delete</a>
                ',
            ];
        });

        return response()->json($result);
    }
}
