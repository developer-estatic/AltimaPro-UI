<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class WhitelistedIp extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'status',
        'ip_address',
        'description',
        'type',
        'created_by',
        'updated_by'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
