<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


class DatatableQueryBuilder
{
    public $commonQueryMethods;

    public function __construct()
    {
        $this->commonQueryMethods = app(CommonQueryMethods::class);
    }
    public function getData(Model $model, array $params = [], $search = null)
    {
        $query = $model::query();

        // Handle select columns (specific or all)
        if (isset($params['select'])) {
            $this->applySelect($query, $params['select'] ?? ['*']);
        }

        // Apply select raw expressions
        if (isset($params['select_raw'])) {
            $this->applySelectRaw($query, $params['select_raw'] ?? []);
        }

        // Apply relations (eager loading with specific columns, foreign_key, and local_key if specified)
        if (isset($params['with'])) {
            $this->applyRelations($query, $params['with'] ?? []);
        }

        // Apply where conditions for main model
        if (isset($params['where'])) {
            $this->applyWheres($query, $params['where'] ?? []);
        }

        // Apply LIKE conditions
        if (isset($params['where_like']) && $search) {
            $this->applyWhereLike($query, $params['where_like'] ?? [], $search);
        }

        // Apply where groups (AND/OR conditions within a group)
        if (isset($params['where_group'])) {
            $this->applyWhereGroups($query, $params['where_group'] ?? []);
        }

        // Apply OR conditions
        if (isset($params['where_or'])) {
            $this->applyWhereOr($query, $params['where_or'] ?? []);
        }

        // Apply BETWEEN conditions
        // dd($params);
        if (isset($params['whereBetween'])) {
            $this->applyWhereBetween($query, $params['whereBetween'] ?? []);
        }

        // Apply In conditions
        if (isset($params['whereIn'])) {
            $this->applyWhereIn($query, $params['whereIn'] ?? []);
        }

        // Apply raw WHERE conditions
        if (isset($params['where_raw'])) {
            $this->applyWhereRaw($query, $params['where_raw'] ?? []);
        }

        // Apply EXISTS subqueries
        if (isset($params['where_exists'])) {
            $this->applyWhereExists($query, $params['where_exists'] ?? []);
        }

        // Apply whereHas (for checking relationships)
        if (isset($params['where_has'])) {
            $this->applyWhereHas($query, $params['where_has'] ?? []);
        }

        // Apply whereHasGroups (nested whereHas conditions for relationships)
        if (isset($params['where_has_group'])) {
            $this->applyWhereHasGroups($query, $params['where_has_group'] ?? []);
        }

        // Apply complex nested whereHas
        if (isset($params['nested_where_has'])) {
            $this->applyNestedWhereHas($query, $params['nested_where_has'] ?? []);
        }

        // Apply has (for counting conditions on relationships)
        if (isset($params['has'])) {
            $this->applyHas($query, $params['has'] ?? []);
        }

        // Apply joins
        if (isset($params['joins'])) {
            $this->applyJoins($query, $params['joins'] ?? []);
        }

        // Apply aggregates (MIN, MAX, SUM, AVG, COUNT)
        if (isset($params['aggregate'])) {
            $this->applyAggregates($query, $params['aggregate'] ?? []);
        }

        // Apply GROUP BY
        if (isset($params['group_by'])) {
            $this->applyGroupBy($query, $params['group_by'] ?? []);
        }

        // Apply HAVING clauses
        if (isset($params['having'])) {
            $this->applyHaving($query, $params['having'] ?? []);
        }

        // Apply sorting (ordering)
        if (isset($params['sort_by'])) {
            $this->applySorting($query, $params['sort_by']['column'] ?? null, $params['sort_by']['sort_order'] ?? 'asc');
        }

        // Apply multiple sorting
        if (isset($params['multiple_sort'])) {
            $this->applyMultipleSorting($query, $params['multiple_sort'] ?? []);
        }

        // Apply raw ORDER BY
        if (isset($params['order_by_raw'])) {
            $this->applyOrderByRaw($query, $params['order_by_raw'] ?? null);
        }

        // Apply pagination
        /* if(isset($params['page'])) {
            $this->applyPagination($query, $params['page'] ?? 1, $params['per_page'] ?? 15);
        } */


        // \Log::info($query->toSql());
        // \Log::info($query->getBindings());
        return $query;
    }

    // Handle select columns (specific or all)
    protected function applySelect($query, array $select)
    {
        if (in_array('*', $select)) {
            return;
        }

        $model = $query->getModel();
        $table = $model->getTable();

        // Prefix the columns with the table name
        $prefixedColumns = array_map(function ($column) use ($table) {
            return "$table.$column";
        }, $select);

        $query->select($prefixedColumns);
    }

    // Apply raw SELECT statements
    protected function applySelectRaw($query, array $selectRaw)
    {
        foreach ($selectRaw as $raw) {
            $query->selectRaw($raw);
        }
    }

    // Apply relations (with eager loading, specific columns, foreign_key, and local_key if specified)
    protected function applyRelations($query, array $relations)
    {
        foreach ($relations as $relation => $columns) {
            $foreignKey = $columns['foreign_key'] ?? null;
            $localKey = $columns['local_key'] ?? null;
            $columns = $columns['columns'] ?? $columns;

            $relationParts = explode('.', $relation);
            $firstRelation = $relationParts[0];

            // Check if the relationship is defined and apply dynamically
            if ($query->getModel()->relationLoaded($firstRelation)) {
                // If it's already defined in the model, apply with() directly
                $query->with([$relation => function ($q) use ($columns) {
                    // Select the columns explicitly for this relation
                    if (!in_array('*', $columns)) {
                        $q->select($columns);
                    }
                }]);
            } else {
                // Dynamically resolve foreign and local keys if necessary
                if ($foreignKey && $localKey) {
                    $query->with([$relation => function ($q) use ($columns, $foreignKey, $localKey) {
                        if (in_array('*', $columns)) {
                            return;
                        }

                        $q->select(array_merge([$foreignKey, $localKey], $columns));
                    }]);
                } else {
                    // If no foreign_key or local_key is provided, use the default Eloquent relationship keys
                    $query->with([$relation => function ($q) use ($columns) {
                        // Select the columns explicitly for this relation
                        if (!in_array('*', $columns)) {
                            $q->select($columns);
                        }
                    }]);
                }
            }
        }
    }

    // Apply where conditions for main model
    protected function applyWheres($query, array $wheres)
    {
        foreach ($wheres as $where) {
            $query->where($where['column'], $where['operator'], $where['value']);
        }
    }

    // Apply LIKE conditions
    protected function applyWhereLike($query, array $whereLike, $search)
    {
        if (!$search) {
            return;
        }

        foreach ($whereLike as $condition) {
            $value = $search;

            $query->orWhere(function ($q) use ($condition, $value) {
                $columnParts = explode('.', $condition['column']);

                if (count($columnParts) === 1) {
                    // Simple column
                    $q->orWhere($columnParts[0], 'like', '%' . $value . '%');
                } else {
                    // Deep relation
                    $column = array_pop($columnParts); // Final column
                    $relationChain = implode('.', $columnParts);

                    $q->orWhereHas($relationChain, function ($subQuery) use ($column, $value) {
                        $subQuery->where($column, 'like', '%' . $value . '%');
                    });
                }
            });
        }

        return $query;
    }


    // Apply where groups (AND/OR conditions within a group)
    protected function applyWhereGroups($query, array $whereGroups)
    {
        foreach ($whereGroups as $group) {
            $query->where(function ($q) use ($group) {
                foreach ($group as $where) {
                    $q->where($where['column'], $where['operator'], $where['value']);
                }
            });
        }
    }

    // Apply OR conditions
    protected function applyWhereOr($query, array $whereOr)
    {
        if (!empty($whereOr)) {
            $query->where(function ($q) use ($whereOr) {
                foreach ($whereOr as $index => $condition) {
                    if ($index === 0) {
                        $q->where($condition['column'], $condition['operator'], $condition['value']);
                    } else {
                        $q->orWhere($condition['column'], $condition['operator'], $condition['value']);
                    }
                }
            });
        }
    }

    // Apply BETWEEN conditions
    protected function applyWhereBetween($query, array $whereBetween)
    {
        foreach ($whereBetween as $between) {
            $query->whereBetween($between['column'], $between['value']);
        }
    }

    // Apply IN conditions

    protected function applyWhereIn($query, array $whereIn)
    {
        foreach ($whereIn as $in) {
            if (empty($in) || empty($in['value'])) {
                continue;
            }

            $column = $in['column'];

            // Check if the column is a relation (dot notation)
            if (Str::contains($column, '.')) {
                $query = $this->commonQueryMethods->applyRelationWhereIn($query, $column, $in['value']);
            } else {
                // Simple column
                $query->whereIn($column, $in['value']);
            }
        }

        return $query;
    }

    // Apply raw WHERE conditions
    protected function applyWhereRaw($query, array $whereRaw)
    {
        foreach ($whereRaw as $raw) {
            $query->whereRaw($raw);
        }
    }

    // Apply EXISTS subqueries
    protected function applyWhereExists($query, array $whereExists)
    {
        foreach ($whereExists as $exists) {
            $query->whereExists($exists['query']);
        }
    }

    // Apply whereHas (for checking relationships)
    protected function applyWhereHas($query, array $whereHas)
    {
        foreach ($whereHas as $relation => $conditions) {
            $query->whereHas($relation, function ($q) use ($conditions) {
                foreach ($conditions as $condition) {
                    $q->where($condition['column'], $condition['operator'], $condition['value']);
                }
            });
        }
    }

    // Apply whereHasGroups (nested whereHas conditions for relationships)
    protected function applyWhereHasGroups($query, array $whereHasGroups)
    {
        foreach ($whereHasGroups as $group) {
            $query->whereHas($group['relation'], function ($q) use ($group) {
                foreach ($group['conditions'] as $condition) {
                    $q->where($condition['column'], $condition['operator'], $condition['value']);
                }
            });
        }
    }

    // Apply complex nested whereHas
    protected function applyNestedWhereHas($query, array $nestedWhereHas)
    {
        foreach ($nestedWhereHas as $config) {
            $this->processNestedRelation($query, $config);
        }
    }

    private function processNestedRelation($query, array $config)
    {
        $relation = $config['relation'];
        $wheres = $config['where'] ?? [];
        $nested = $config['nested'] ?? null;

        $query->whereHas($relation, function ($q) use ($wheres, $nested) {
            // Apply where conditions
            foreach ($wheres as $where) {
                $q->where($where['column'], $where['operator'], $where['value']);
            }

            // Apply nested relation if exists
            if ($nested) {
                $this->processNestedRelation($q, $nested);
            }
        });
    }

    // Apply has (for counting conditions on relationships)
    protected function applyHas($query, array $has)
    {
        foreach ($has as $relation => $count) {
            $query->has($relation, '>=', $count);
        }
    }

    // Apply joins
    protected function applyJoins($query, array $joins)
    {
        foreach ($joins as $join) {
            $type = $join['type'] ?? 'inner';
            $table = $join['table'];
            $first = $join['first'];
            $operator = $join['operator'] ?? '=';
            $second = $join['second'] ?? null;
            $wheres = $join['where'] ?? [];

            switch ($type) {
                case 'inner':
                    if ($second !== null) {
                        $query->join($table, $first, $operator, $second);
                    } else {
                        $query->join($table, function ($join) use ($first, $wheres) {
                            $join->on($first);
                            foreach ($wheres as $where) {
                                $join->where($where['column'], $where['operator'], $where['value']);
                            }
                        });
                    }
                    break;
                case 'left':
                    if ($second !== null) {
                        $query->leftJoin($table, $first, $operator, $second);
                    } else {
                        $query->leftJoin($table, function ($join) use ($first, $wheres) {
                            $join->on($first);
                            foreach ($wheres as $where) {
                                $join->where($where['column'], $where['operator'], $where['value']);
                            }
                        });
                    }
                    break;
                case 'right':
                    if ($second !== null) {
                        $query->rightJoin($table, $first, $operator, $second);
                    } else {
                        $query->rightJoin($table, function ($join) use ($first, $wheres) {
                            $join->on($first);
                            foreach ($wheres as $where) {
                                $join->where($where['column'], $where['operator'], $where['value']);
                            }
                        });
                    }
                    break;
                case 'cross':
                    $query->crossJoin($table);
                    break;
            }

            // Apply additional WHERE clauses to the main query if needed
            if (!empty($wheres) && $second !== null) {
                foreach ($wheres as $where) {
                    $query->where($where['column'], $where['operator'], $where['value']);
                }
            }
        }
    }

    // Apply aggregates (MIN, MAX, SUM, AVG, COUNT)
    protected function applyAggregates($query, array $aggregates)
    {
        foreach ($aggregates as $type => $config) {
            $column = $config['column'];
            $alias = $config['as'] ?? null;

            switch ($type) {
                case 'count':
                    $query->selectRaw("COUNT($column) as $alias");
                    break;
                case 'sum':
                    $query->selectRaw("SUM($column) as $alias");
                    break;
                case 'avg':
                    $query->selectRaw("AVG($column) as $alias");
                    break;
                case 'min':
                    $query->selectRaw("MIN($column) as $alias");
                    break;
                case 'max':
                    $query->selectRaw("MAX($column) as $alias");
                    break;
            }
        }
    }

    // Apply GROUP BY
    protected function applyGroupBy($query, array $groupBy)
    {
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }
    }

    // Apply HAVING clauses
    protected function applyHaving($query, array $having)
    {
        foreach ($having as $have) {
            $query->having($have['column'], $have['operator'], $have['value']);
        }
    }

    // Apply sorting (ordering)
    protected function applySorting($query, $sortBy = null, $sortOrder = 'asc')
    {
        if (!$sortBy) return $query;

        if (Str::contains($sortBy, '.')) {
            $parts = explode('.', $sortBy);
            $column = array_pop($parts);
            $relation = implode('.', $parts);

            $baseModel = $query->getModel();
            $relatedModel = $baseModel;

            // Traverse to get the final related model
            foreach ($parts as $part) {
                $relatedModel = $relatedModel->{$part}()->getRelated();
            }

            $relatedTable = $relatedModel->getTable();

            // Get root relation (first in chain) to derive keys
            $rootRelation = $baseModel->{$parts[0]}();

            $foreignKey = method_exists($rootRelation, 'getQualifiedForeignKeyName')
                ? $rootRelation->getQualifiedForeignKeyName()
                : $rootRelation->getForeignKeyName();
            $ownerKey = method_exists($rootRelation, 'getQualifiedOwnerKeyName')
                ? $rootRelation->getQualifiedOwnerKeyName()
                : $rootRelation->getLocalKeyName();

            // Fallback if key names are not fully qualified
            if (!Str::contains($foreignKey, '.')) {
                $foreignKey = "{$relatedTable}.{$foreignKey}";
            }
            if (!Str::contains($ownerKey, '.')) {
                $ownerKey = $baseModel->getTable() . '.' . $ownerKey;
            }

            $appended = $relatedModel->getAppends();


            if (in_array($column, $appended)) {
                $query = $relatedModel->makeOrderBy($query, $column, $sortOrder, $relatedModel, $foreignKey, $ownerKey);
            } else {
                $query = $query->orderBy(
                    $relatedModel::select($column)
                        ->whereColumn($foreignKey, $ownerKey)
                        ->take(1),
                    $sortOrder
                );
            }
        } else {
            $query = $query->orderBy($sortBy, $sortOrder);
        }

        return $query;
    }



    // Apply multiple sorting
    protected function applyMultipleSorting($query, array $sorting)
    {
        foreach ($sorting as $sort) {
            $query->orderBy($sort['column'], $sort['direction']);
        }
    }

    // Apply raw ORDER BY
    protected function applyOrderByRaw($query, $orderByRaw)
    {
        if ($orderByRaw) {
            $query->orderByRaw($orderByRaw);
        }
    }

    // Apply pagination
    protected function applyPagination($query, $page = 1, $perPage = 15)
    {
        $query->skip(($page - 1) * $perPage)->take($perPage);
    }
}
