<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Services\DatatableQueryBuilder;

class DynamicDatatable extends Component
{

    use WithPagination;

    public $table;
    public $tableHeadColumnsAndDataKeys;
    public $conditions;
    public $search = '';
    public $cloneConditions;
    public $datatableQueryBuilder = DatatableQueryBuilder::class;
    public $finalData;
    public $componentRenderKey;

    public function mount($table, $tableHeadColumnsAndDataKeys, $conditions)
    {
        $this->table = $table;
        $this->tableHeadColumnsAndDataKeys = $tableHeadColumnsAndDataKeys;
        $this->conditions = $conditions;
    }

    public function refreshComponent()
    {
        $this->reload();
        $this->mount($this->table, $this->tableHeadColumnsAndDataKeys, $this->conditions); // Reinitialize the component

    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    /* public function updatedSearch()
    {
        $this->resetPage();
    } */

    #[\Livewire\Attributes\On('resetTable')]
    public function resetTable()
    {
        $this->resetPage();
        $this->conditions = $this->cloneConditions;

    }

    #[\Livewire\Attributes\On('sortChanged')]
    public function resetSortBy($col, $dir)
    {
        $this->resetPage();
        $this->conditions['sort_by'] = ['column' => $col, 'sort_order' => $dir];
    }

    #[\Livewire\Attributes\On('clearFilter')]
    public function clearFilter($operator, $col)
    {
        $this->resetPage();
        if (isset($this->conditions[$operator])) {

            foreach ($this->conditions[$operator] as $key => $condition) {
                if ($condition['column'] === $col) {
                    unset($this->conditions[$operator][$key]);
                }
            }
        }
    }

    #[\Livewire\Attributes\On('applyFilter')]
    public function applyFilter($operator, $col, $value)
    {
        $this->resetPage();

        // Check if the operator exists in conditions
        if (isset($this->conditions[$operator])) {
            foreach ($this->conditions[$operator] as $key => $condition) {
                // If the column already exists, update or remove it
                if ($condition['column'] === $col) {
                    if (empty($value)) {
                        // Remove the condition if the value is empty
                        unset($this->conditions[$operator][$key]);
                    } else {
                        // Update the value if it exists
                        $this->conditions[$operator][$key]['value'] = $value;
                    }
                    // Exit the loop early since the column is found
                    return;
                }
            }
        }

        // If the column does not exist and the value is not empty, add it
        if (!empty($value)) {
            $this->conditions[$operator][] = ['column' => $col, 'value' => $value];
        }
    }

    public function fetchData()
    {
        return $this->setPagination(
            app($this->datatableQueryBuilder)->getData($this->table, $this->conditions, $this->search)
        );
    }

    public function setPagination($data)
    {
        $perPage = $this->conditions['per_page'] ?? 10;

        // When searching, disable pagination for full results
        if ($this->search) {
            return $data->get();
        }

        return $data->paginate($perPage);
    }

    public function exportToExcel()
    {
        $data = app($this->datatableQueryBuilder)->getData($this->table, $this->conditions, $this->search)->get();
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ClientUserExport($data, $this->tableHeadColumnsAndDataKeys), 'datatable_export.xlsx');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $data = $this->fetchData();
        $this->finalData = $data instanceof \Illuminate\Pagination\AbstractPaginator
            ? $data->getCollection()
            : collect($data);
        return view('livewire.dynamic-datatable', [
            'data' => $data,
            'tableHeadColumns' => $this->tableHeadColumnsAndDataKeys,
            'filterOptions' => $this->getFilterOptionsProperty(),

        ]);
    }

    public function getFilterOptionsProperty()
    {
        $columns = $this->tableHeadColumnsAndDataKeys;

        // Separate columns into top filters and side filters
        $topFilters = collect($columns)->filter(fn($col) => $col['table_head_filter'] ?? false)->all();
        $sideFilters = collect($columns)->filter(fn($col) => isset($col['left_filter']))->all();

        // Determine which columns are filterable
        $filterableKeys = collect($topFilters)
            ->filter(fn($col) => isset($col['data_key'])) // Ensure data_key exists
            ->mapWithKeys(fn($col, $label) => [$label => $col['data_key']]);

        // Create a list of all relationships needed for eager loading
        $eagerLoads = [];
        foreach ($columns as $column) {
            if (isset($column['data_key'])) { // Ensure data_key exists
                $keyParts = explode('.', $column['data_key']);
                if (count($keyParts) > 1) {
                    $eagerLoads[] = $keyParts[0]; // Add the first part (relationship) to eager load
                }
            }
        }

        // Load all required relationships in one query
        $query = $this->table->with($eagerLoads);

        // Cache the results for the whole data, so no separate queries for each filter
        $allData = $query->get();

        $filters = [
            'top_filters' => [],
            'side_filters' => []
        ];

        foreach ($filterableKeys as $label => $key) {
            // Split the key into parts (e.g., 'category.name' becomes ['category', 'name'])
            $keyParts = explode('.', $key);

            if (count($keyParts) == 1) {
                // Handle direct column filter (single-level, e.g., 'status')
                $filters['top_filters'][$key] = $allData->pluck($key)
                    ->filter()
                    ->sort()
                    ->values()
                    ->unique()
                    ->all();
            } else {
                // For nested relationships, filter using the already eager-loaded data
                $filters['top_filters'][$key] = $allData->map(function ($item) use ($keyParts) {
                    return $this->getNestedValue($item, $keyParts);
                })
                    ->filter()
                    ->unique()
                    ->sort()
                    ->values()
                    ->all();
            }
        }

        // Add support for side filters
        foreach ($sideFilters as $label => $column) {
            if (isset($column['data_key'])) { // Ensure data_key exists
                $keyParts = explode('.', $column['data_key']);

                $sideFilterKey = $label; // Convert to kebab case

                if (count($keyParts) == 1) {
                    // Handle direct column filter for side filters
                    $filters['side_filters'][$sideFilterKey] = [
                        'values' => $allData->pluck($column['data_key'])
                            ->filter()
                            ->unique()
                            ->sort()
                            ->values()
                            ->all(),
                        'left_filter' => $column['left_filter'],
                        'format' => $column['left_filter']['format'] ?? null,
                        'view_name' => $column['left_filter']['view_name'] ?? null,
                        'order' => $column['left_filter']['order'] ?? null,
                        'has_select_all' => $column['left_filter']['has_select_all'] ?? false,
                        'heading' => $column['left_filter']['heading'] ?? null,
                        'data_key' => $column['data_key'] ?? null,

                    ];
                } else {
                    // Handle nested relationships for side filters
                    $filters['side_filters'][$sideFilterKey] = [
                        'values' => $allData->map(function ($item) use ($keyParts) {
                            return $this->getNestedValue($item, $keyParts);
                        })
                            ->filter()
                            ->unique()
                            ->sort()
                            ->values()
                            ->all(),
                        'left_filter' => $column['left_filter'],
                        'format' => $column['left_filter']['format'] ?? null,
                        'view_name' => $column['left_filter']['view_name'] ?? null,
                        'order' => $column['left_filter']['order'] ?? null,
                        'has_select_all' => $column['left_filter']['has_select_all'] ?? false,
                        'heading' => $column['left_filter']['heading'] ?? null,
                        'data_key' => $column['data_key'] ?? null,
                    ];
                }
            }
        }

        // Sort side filters by the 'order' key
        $filters['side_filters'] = collect($filters['side_filters'])
            ->sortBy(fn($filter) => $filter['order'] ?? PHP_INT_MAX)
            ->toArray();

        return $filters;
    }

    /**
     * Retrieve the nested value from the given item using dot notation.
     */
    private function getNestedValue($item, array $keyParts)
    {
        foreach ($keyParts as $part) {
            if (isset($item->$part)) {
                $item = $item->$part;
            } else {
                return null; // If the nested value does not exist, return null
            }
        }

        return $item;
    }
}
