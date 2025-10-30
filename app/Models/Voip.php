<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class Voip extends Model
{
    protected $table = 'voips';
    protected $fillable = ['brand_id', 'name', 'url', 'extension', 'secret_key', 'status', 'created_by', 'updated_by'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
