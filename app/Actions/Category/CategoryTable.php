<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Services\DataTableService;
use Lorisleiva\Actions\Concerns\AsAction;

class CategoryTable
{
    use AsAction;

    public function __construct(
        protected DataTableService $dataTableService
    ) {}

    public function handle()
    {
        $query = Category::query();
        $columns = ['id', 'name', 'type'];

        $result = $this->dataTableService->handle($query, $columns);

        $result['data'] = $result['data']->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'type' => $category->type,
                'status' => $category->is_active
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">Inactive</span>',
                'actions' => '
                    <a href="' . route('admin.categories.edit', $category->id) . '" wire:navigate class="btn btn-sm btn-primary">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger" wire:click="delete(' . $category->id . ')"
                    wire:confirm="Are you sure you want to delete?">Delete</a>
                ',
            ];
        });

        return response()->json($result);
    }
}
