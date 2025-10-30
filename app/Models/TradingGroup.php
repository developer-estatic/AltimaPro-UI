<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class TradingGroup extends Model
{
    protected $table = 'trading_groups';

    protected $fillable = [
        'name',
        'trading_currency_id',
        'trading_account_type_id',
        'trading_currency_id',
        'business_unit_id',
        'trading_platform_id',
        'status'
    ];

    public function tradingAccountType()
    {
        return $this->belongsTo(TradingAccountType::class, 'trading_account_type_id');
    }
    public function tradingCurrency()
    {
        return $this->belongsTo(TradingCurrency::class, 'trading_currency_id');
    }
    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class, 'business_unit_id');
    }
    public function tradingPlatform()
    {
        return $this->belongsTo(TradingPlatform::class, 'trading_platform_id');
    }

}
