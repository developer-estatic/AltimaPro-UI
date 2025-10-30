<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class TradingLeverage extends Model
{
    protected $table = 'trading_leverages';
    protected $fillable = [
        'name',
        'value',
    ];
}
