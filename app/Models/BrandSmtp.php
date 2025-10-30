<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class BrandSmtp extends Model
{
    protected $table = 'brand_smtps';
    protected $fillable = [
        'brand_id',
        'name',
        'host',
        'username',
        'password',
        'port',
        'encryption',
        'from_email',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
