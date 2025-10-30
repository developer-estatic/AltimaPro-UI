<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'type_id',
        'business_unit_id',
        'language',
        'subject',
        'body',
        'created_by',
        'updated_by',
    ];

    public function type()
    {
        return $this->belongsTo(CrmMetaData::class, 'type_id');
    }
}
