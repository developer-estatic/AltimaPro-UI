<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class Ib extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol_master_name',
        'symbol_type_id',
        'base_spread_rate',
        'spread_category_id',
        'lot_value',
        'created_by',
        'updated_by',
    ];

    public function symbolType()
    {
        return $this->belongsTo(CRMMetaData::class, 'symbol_type_id');
    }
    public function spreadCategory()
    {
        return $this->belongsTo(CRMMetaData::class, 'spread_category_id');
    }
}
