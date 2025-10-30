<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class Sms extends Model
{
    protected $fillable = [
        'name',
        'url',
        'parameters',
        'status',
        'brand_id'
    ];

    protected $casts = [
        'parameters' => 'array',
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

}
