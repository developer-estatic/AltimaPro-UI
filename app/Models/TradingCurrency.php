<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class TradingCurrency extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'status',
        'created_by',
        'updated_by',
    ];
}
