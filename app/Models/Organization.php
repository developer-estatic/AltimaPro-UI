<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'description',
        'brand_id',
        'status',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function getStatusClassAttribute()
    {
        return getStatusClassAttribute($this->status);
    }

    public function getStatusTextIconAttribute()
    {
        return getStatusTextIconAttribute($this->status);
    }
}
