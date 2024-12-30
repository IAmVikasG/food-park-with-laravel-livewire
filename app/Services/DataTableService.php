<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class DataTableService
{
    /**
     * Handle the DataTable server-side logic.
     *
     * @param Builder $query
     * @param array $columns
     * @return array
     */
    public function handle(Builder $query, array $columns): array
    {
        // Get DataTables request parameters
        $draw = request()->get('draw', 1);
        $start = request()->get('start', 0);
        $length = request()->get('length', 10);
        $searchValue = request()->input('search.value', '');
        $orderColumn = request()->input('order.0.column', 0);
        $orderDirection = request()->input('order.0.dir', 'asc');
        $orderByColumn = $columns[$orderColumn] ?? $columns[0];

        // Apply search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($columns, $searchValue) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $searchValue . '%');
                }
            });
        }

        // Get filtered and total record counts
        $recordsFiltered = $query->count();
        $recordsTotal = $query->toBase()->getCountForPagination();

        // Apply ordering and pagination
        $query->orderBy($orderByColumn, $orderDirection)
            ->skip($start)
            ->take($length);

        // Fetch records
        $data = $query->get();

        return [
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ];
    }
}
