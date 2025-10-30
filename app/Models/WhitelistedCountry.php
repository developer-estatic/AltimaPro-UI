<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class WhitelistedCountry extends Model
{
    use HasFactory;

    protected $table = 'whitelisted_countries';

    protected $fillable = [
        'brand_id',
        'countries',
        'name',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'countries' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
