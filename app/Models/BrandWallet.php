<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class BrandWallet extends Model
{
    use HasFactory;

    protected $table = 'brand_wallets';

    protected $fillable = [
        'brand_id',
        'name',
        'status',
        'type',
        'currency',
        'markup_amount',
        'service_charge',
        'created_by',
        'updated_by',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

}
