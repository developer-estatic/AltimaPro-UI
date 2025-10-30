<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class BusinessUnit extends Model
{
    use HasFactory;
    protected $table = 'business_units';
    protected $fillable = [
        'brand_id',
        'name',
        'status',
        'timezone',
        'language',
        'isparent',
        'parent_business_unit_id',
        'ftd_amount',
        'partial_ftd',
        's3_bucket_name',
        's3_bucket_path',
        'ispamm',
        'issocial',
        'isprop',
        'created_by',
        'updated_by',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function parent()
    {
        return $this->belongsTo(BusinessUnit::class, 'parent_business_unit_id');
    }

    public function children()
    {
        return $this->hasMany(BusinessUnit::class, 'parent_business_unit_id');
    }
}
