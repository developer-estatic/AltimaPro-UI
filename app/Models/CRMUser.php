<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CRMUser extends Model
{
    protected $table = 'crm_users';

    protected $appends = [
        'full_name',
    ];
    public function clientUser()
    {
        return $this->hasOne(ClientUser::class, 'account_id', 'account_id');
    }

    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function makeOrderBy($query, $column, $sortOrder, $relatedModel, $foreignKey, $ownerKey)
    {
        $sortOrder = trim($sortOrder);
        $column = trim($column);
        $sortableExpression = $this->getSortableExpression($column);

        return $query->orderBy(
            $relatedModel::selectRaw($sortableExpression)
                ->whereColumn($foreignKey, $ownerKey)
                ->orderByRaw("$sortableExpression $sortOrder")
                ->limit(1),
            $sortOrder
        );
    }

    public function makeWhereIn($relation, $query, $column, $values)
    {
        if($column == 'full_name') {
            $query = $query->whereHas($relation, function($q) use ($values) {
                $q->whereIn(DB::raw("CONCAT(firstname, ' ', lastname)"), $values);
            });
        }
        return $query;
    }

    public function getSortableExpression($column)
    {
        if (in_array($column, $this->appends)) {
            // Use naming convention to infer logic
            if ($column === 'full_name') {
                return "CONCAT({$this->getTable()}.firstname, ' ', {$this->getTable()}.lastname)";
            }

            // Optionally handle other custom appended attributes here
        }

        return "{$this->getTable()}.$column";
    }
}
