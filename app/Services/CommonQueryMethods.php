<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


class CommonQueryMethods
{
    public function applyRelationWhereIn($query, $column, $values)
    {
        $parts = explode('.', $column);
        $field = array_pop($parts); // Extract the final column
        $relationChain = implode('.', $parts); // Build the relation chain

        $baseModel = $query->getModel();
        $relatedModel = $this->getRelatedModel($baseModel, $parts);

        // Handle appended attributes
        if (in_array($field, $relatedModel->getAppends())) {
            $query = $this->applyAppendedWhereIn($query, $relationChain, $field, $values, $relatedModel);
        } else {
            // Standard relational column
            $query->whereHas($relationChain, function ($q) use ($field, $values) {
                $q->whereIn($field, $values);
            });
        }

        return $query;
    }

    public function applyAppendedWhereIn($query, $relation, $field, $values, $relatedModel)
    {
        $query = $relatedModel->makeWhereIn($relation, $query, $field, $values);
        return $query;
    }

    public function getRelatedModel($baseModel, $relationParts)
    {
        $relatedModel = $baseModel;

        // Traverse the relation chain to get the final related model
        foreach ($relationParts as $part) {
            $relatedModel = $relatedModel->{$part}()->getRelated();
        }

        return $relatedModel;
    }
}
