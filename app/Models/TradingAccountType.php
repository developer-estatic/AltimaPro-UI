<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class TradingAccountType extends Model
{
    protected $fillable = [
        'name',
        'value',
        'status',
        'created_by',
        'updated_by',
    ];
}
