<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class TradingPlatform extends Model
{
    protected $table = 'trading_platforms';
    protected $fillable = [
        'name',
        'status',
        // 'username',
        // 'password',
        'server',
        'created_by',
        'updated_by',
    ];
}
